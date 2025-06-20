<?php 

namespace Modules\Wallet\Controllers\Api;

use App\Http\Controllers\Controller;
use Modules\Wallet\Resources\WalletResource;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function show(Request $request)
    {
        $wallet = $request->user()->wallet;
        return new WalletResource($wallet);
    }
}