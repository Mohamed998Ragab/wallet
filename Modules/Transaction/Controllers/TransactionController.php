<?php

namespace Modules\Transaction\Controllers;

use App\Http\Controllers\Controller;
use Modules\Transaction\Services\TransactionServiceInterface;
use Modules\Transaction\Resources\TransactionResource;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    protected TransactionServiceInterface $transactionService;

    public function __construct(TransactionServiceInterface $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function index(Request $request)
    {
        $transactions = $this->transactionService->getByWallet($request->user()->wallet_id);
        return response()->json(TransactionResource::collection($transactions));
    }
}