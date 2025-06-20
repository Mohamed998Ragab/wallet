<?php

namespace Modules\TopUpRequest\Controllers\Api;

use App\Http\Controllers\Controller;
use Modules\TopUpRequest\Requests\CreateTopUpRequest;
use Modules\TopUpRequest\Services\TopUpRequestServiceInterface;
use Modules\TopUpRequest\Resources\TopUpRequestResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TopUpRequestController extends Controller
{
    protected TopUpRequestServiceInterface $topUpRequestService;

    public function __construct(TopUpRequestServiceInterface $topUpRequestService)
    {
        $this->topUpRequestService = $topUpRequestService;
    }

    public function index(Request $request): JsonResponse
{
    
    $requests = $this->topUpRequestService->getUserRequests(
        $request->user()->id,
    );
    
    return response()->json(TopUpRequestResource::collection($requests));
}

    public function store(CreateTopUpRequest $request): JsonResponse
    {
        $topUpRequest = $this->topUpRequestService->create(
            $request->user()->id,
            $request->validated()['amount']
        );
        return response()->json(new TopUpRequestResource($topUpRequest), 201);
    }
}