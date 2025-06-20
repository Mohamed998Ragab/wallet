<?php

namespace Modules\WithdrawRequest\Controllers;

use App\Http\Controllers\Controller;
use Modules\WithdrawRequest\Requests\CreateWithdrawRequest;
use Modules\WithdrawRequest\Requests\RejectWithdrawRequest;
use Modules\WithdrawRequest\Services\WithdrawRequestServiceInterface;
use Modules\WithdrawRequest\Resources\WithdrawRequestResource;
use Illuminate\Support\Facades\Auth;
use Modules\Wallet\Exceptions\InsufficientBalanceException;
use Modules\Wallet\Services\WalletServiceInterface;
use Modules\WithdrawRequest\Exceptions\SelfApprovalException;

class WithdrawRequestController extends Controller
{
    protected WithdrawRequestServiceInterface $withdrawRequestService;
    protected WalletServiceInterface $walletService;

    public function __construct(
        WithdrawRequestServiceInterface $withdrawRequestService,
        WalletServiceInterface $walletService
    ) {
        $this->withdrawRequestService = $withdrawRequestService;
        $this->walletService = $walletService;
    }

    /**
     * Display all withdrawal requests
     */
    public function index()
    {
        try {
            $requests = $this->withdrawRequestService->all();
            return view('admin::admin.withdraw_requests.index', [
                'requests' => $requests, // Pass raw collection instead of resource
                'availableBalance' => $this->getCurrentAdminAvailableBalance(),
            ]);
        } catch (\Exception $e) {
            \Log::error('Error loading withdrawal requests: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to load withdrawal requests: ' . $e->getMessage());
        }
    }

    /**
     * Show the withdrawal request creation form
     */
    public function create()
    {
        try {
            return view('admin::admin.withdraw_requests.create', [
                'availableBalance' => $this->getCurrentAdminAvailableBalance(),
            ]);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to load withdrawal form: ' . $e->getMessage());
        }
    }

    /**
     * Store a new withdrawal request
     */
    public function store(CreateWithdrawRequest $request)
    {
        try {
            $this->withdrawRequestService->create(
                Auth::guard('admin')->id(),
                $request->validated()['amount']
            );
            
            return redirect()->route('admin.dashboard')
                ->with('success', 'Withdrawal requested successfully.');
                
        } catch (InsufficientBalanceException $e) {
            return $this->handleInsufficientBalanceError();
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create withdrawal: ' . $e->getMessage());
        }
    }

    /**
     * Approve a withdrawal request
     */
    public function approve(int $id)
    {
        try {
            $this->withdrawRequestService->approve($id, Auth::guard('admin')->id());
            return redirect()->back()
                ->with('success', 'Withdrawal approved successfully.');
                
        } catch (SelfApprovalException $e) {
            return redirect()->back()
                ->with('error', $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to approve withdrawal: ' . $e->getMessage());
        }
    }

    /**
     * Reject a withdrawal request
     */
    public function reject(int $id, RejectWithdrawRequest $request)
    {
        try {
            $this->withdrawRequestService->reject(
                $id,
                Auth::guard('admin')->id(),
                $request->validated()['rejection_reason']
            );
            
            return redirect()->back()
                ->with('success', 'Withdrawal rejected successfully.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to reject withdrawal: ' . $e->getMessage());
        }
    }

    /**
     * Get available balance for current admin
     */
    protected function getCurrentAdminAvailableBalance(): float
    {
        return $this->walletService->getAvailableBalance(
            Auth::guard('admin')->user()->wallet_id
        );
    }

    /**
     * Handle insufficient balance error with proper messaging
     */
    protected function handleInsufficientBalanceError()
    {
        $available = $this->getCurrentAdminAvailableBalance();
        return redirect()->back()
            ->withInput()
            ->with('error', sprintf(
                'Insufficient available balance. Your available balance is $%s',
                number_format($available, 2)
            ));
    }
}