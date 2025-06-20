<?php

namespace Modules\Wallet\Controllers;

use App\Http\Controllers\Controller;
use Modules\Wallet\Resources\WalletResource;
use Illuminate\Support\Facades\Auth;

class AdminWalletController extends Controller
{
    public function show()
    {
        $wallet = Auth::guard('admin')->user()->wallet;
        return view(
            'admin::admin.wallet.show',
            [
                'wallet' => $wallet, 
            ]
        );
    }
}
