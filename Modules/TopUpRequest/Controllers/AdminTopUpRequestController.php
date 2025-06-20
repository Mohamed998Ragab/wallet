<?php

namespace Modules\TopUpRequest\Controllers;

use App\Http\Controllers\Controller;
use Modules\TopUpRequest\Services\TopUpRequestServiceInterface;
use Modules\TopUpRequest\Resources\TopUpRequestResource;
use Illuminate\Support\Facades\Auth;
use Modules\TopUpRequest\Requests\RejectTopUpRequest;

class AdminTopUpRequestController extends Controller
{
    protected TopUpRequestServiceInterface $topUpRequestService;

    public function __construct(TopUpRequestServiceInterface $topUpRequestService)
    {
        $this->topUpRequestService = $topUpRequestService;
    }

    public function index()
    {
        try {
            $requests = $this->topUpRequestService->all();
            return view('admin::admin.top_up_requests.index', [
                'requests' => $requests, // Passing raw collection
            ]);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to load top-up requests: ' . $e->getMessage());
        }
    }

    public function approve(int $id)
    {
        try {
            $this->topUpRequestService->approve($id, Auth::guard('admin')->id());
            return redirect()->back()
                ->with('success', 'Top-up approved successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to approve top-up: ' . $e->getMessage());
        }
    }

    public function reject(int $id, RejectTopUpRequest $request)
    {
        try {
            $this->topUpRequestService->reject(
                $id,
                Auth::guard('admin')->id(),
                $request->validated()['rejection_reason']
            );
            return redirect()->back()
                ->with('success', 'Top-up rejected successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to reject top-up: ' . $e->getMessage());
        }
    }
}
