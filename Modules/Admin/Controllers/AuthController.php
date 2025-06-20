<?php

namespace Modules\Admin\Controllers;

use App\Http\Controllers\Controller;
use Modules\Admin\Requests\LoginRequest;
use Modules\Admin\Resources\AdminResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    public function showLoginForm(): \Illuminate\View\View
    {
        return view('admin::admin.auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->validated();

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard')
                ->with('success', 'Logged in successfully');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput();
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')
            ->with('success', 'Logged out successfully');
    }
}