<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Modules\Admin\Repositories\AdminRepository;
use Modules\Admin\Repositories\AdminRepositoryInterface;
use Modules\Admin\Services\AdminService;
use Modules\Admin\Services\AdminServiceInterface;
use Modules\Permission\Repositories\PermissionRepository;
use Modules\Permission\Repositories\PermissionRepositoryInterface;
use Modules\Permission\Services\PermissionService;
use Modules\Permission\Services\PermissionServiceInterface;
use Modules\Wallet\Repositories\WalletRepository;
use Modules\Wallet\Repositories\WalletRepositoryInterface;
use Modules\Wallet\Services\WalletService;
use Modules\Wallet\Services\WalletServiceInterface;
use Modules\Transaction\Repositories\TransactionRepository;
use Modules\Transaction\Repositories\TransactionRepositoryInterface;
use Modules\Transaction\Services\TransactionService;
use Modules\Transaction\Services\TransactionServiceInterface;
use Modules\ReferralCode\Repositories\ReferralCodeRepository;
use Modules\ReferralCode\Repositories\ReferralCodeRepositoryInterface;
use Modules\ReferralCode\Services\ReferralCodeService;
use Modules\ReferralCode\Services\ReferralCodeServiceInterface;
use Modules\User\Repositories\UserRepository;
use Modules\User\Repositories\UserRepositoryInterface;
use Modules\User\Services\UserService;
use Modules\User\Services\UserServiceInterface;
use Modules\WithdrawRequest\Repositories\WithdrawRequestRepository;
use Modules\WithdrawRequest\Repositories\WithdrawRequestRepositoryInterface;
use Modules\WithdrawRequest\Services\WithdrawRequestService;
use Modules\WithdrawRequest\Services\WithdrawRequestServiceInterface;
use Modules\TopUpRequest\Repositories\TopUpRequestRepository;
use Modules\TopUpRequest\Repositories\TopUpRequestRepositoryInterface;
use Modules\TopUpRequest\Services\TopUpRequestService;
use Modules\TopUpRequest\Services\TopUpRequestServiceInterface;

class ModuleServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Bind Admin interfaces
        $this->app->bind(AdminRepositoryInterface::class, AdminRepository::class);
        $this->app->bind(AdminServiceInterface::class, AdminService::class);

        // Bind Permission interfaces
        $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);
        $this->app->bind(PermissionServiceInterface::class, PermissionService::class);

        // Bind Wallet interfaces
        $this->app->bind(WalletRepositoryInterface::class, WalletRepository::class);
        $this->app->bind(WalletServiceInterface::class, WalletService::class);

        // Bind Transaction interfaces
        $this->app->bind(TransactionRepositoryInterface::class, TransactionRepository::class);
        $this->app->bind(TransactionServiceInterface::class, TransactionService::class);


        // Bind Users Interfaces
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);

        // Bind ReferralCode interfaces
        $this->app->bind(ReferralCodeRepositoryInterface::class, ReferralCodeRepository::class);
        $this->app->bind(ReferralCodeServiceInterface::class, ReferralCodeService::class);


        // Bind WithdrawalRequest interfaces
        $this->app->bind(WithdrawRequestRepositoryInterface::class, WithdrawRequestRepository::class);
        $this->app->bind(WithdrawRequestServiceInterface::class, WithdrawRequestService::class);

        // Bind TopUpRequest interfaces
        $this->app->bind(TopUpRequestRepositoryInterface::class, TopUpRequestRepository::class);
        $this->app->bind(TopUpRequestServiceInterface::class, TopUpRequestService::class);
    }

    public function boot()
    {
        // Load Admin module
        if (file_exists(base_path('Modules/Admin/Routes/web.php'))) {
            Route::middleware('web')
                ->namespace('Modules\\Admin\\Controllers')
                ->group(base_path('Modules/Admin/Routes/web.php'));
        }
        if (file_exists(base_path('Modules/Admin/Routes/api.php'))) {
            Route::middleware('api')
                ->namespace('Modules\\Admin\\Controllers')
                ->group(base_path('Modules/Admin/Routes/api.php'));
        }
        $this->loadViewsFrom(base_path('Modules/Admin/Views'), 'admin');
        $this->loadMigrationsFrom(base_path('Modules/Admin/Database/Migrations'));

        // Load Permission module
        if (file_exists(base_path('Modules/Permission/Routes/web.php'))) {
            Route::middleware('web')
                ->namespace('Modules\\Permission\\Controllers')
                ->group(base_path('Modules/Permission/Routes/web.php'));
        }
        if (file_exists(base_path('Modules/Permission/Routes/api.php'))) {
            Route::middleware('api')
                ->namespace('Modules\\Permission\\Controllers')
                ->group(base_path('Modules/Permission/Routes/api.php'));
        }

        $this->loadViewsFrom(base_path('Modules/Permission/Views'), 'permission');
        $this->loadMigrationsFrom(base_path('Modules/Permission/Database/Migrations'));

        // Load Wallet module
        if (file_exists(base_path('Modules/Wallet/Routes/web.php'))) {
            Route::middleware('web')
                ->namespace('Modules\\Wallet\\Controllers')
                ->group(base_path('Modules/Wallet/Routes/web.php'));
        }

        if (file_exists(base_path('Modules/Wallet/Routes/api.php'))) {
            Route::middleware('api')
                ->namespace('Modules\\Wallet\\Controllers')
                ->group(base_path('Modules/Wallet/Routes/api.php'));
        }

        $this->loadViewsFrom(base_path('Modules/Wallet/Views'), 'wallet');
        $this->loadMigrationsFrom(base_path('Modules/Wallet/Database/Migrations'));

        // Load Users module
        if (file_exists(base_path('Modules/User/Routes/web.php'))) {
            Route::middleware('web')
                ->namespace('Modules\\User\\Controllers')
                ->group(base_path('Modules/User/Routes/web.php'));
        }
        if (file_exists(base_path('Modules/User/Routes/api.php'))) {
            Route::middleware('api')
                ->namespace('Modules\\User\\Controllers')
                ->group(base_path('Modules/User/Routes/api.php'));
        }
        $this->loadViewsFrom(base_path('Modules/User/Views'), 'user');
        $this->loadMigrationsFrom(base_path('Modules/User/Database/Migrations'));


        // Load ReferralCode module
        if (file_exists(base_path('Modules/ReferralCode/Routes/web.php'))) {
            Route::middleware('web')
                ->namespace('Modules\\ReferralCode\\Controllers')
                ->group(base_path('Modules/ReferralCode/Routes/web.php'));
        }
        if (file_exists(base_path('Modules/ReferralCode/Routes/api.php'))) {
            Route::middleware('api')
                ->namespace('Modules\\ReferralCode\\Controllers')
                ->group(base_path('Modules/ReferralCode/Routes/api.php'));
        }
        $this->loadViewsFrom(base_path('Modules/ReferralCode/Views'), 'referralCode');
        $this->loadMigrationsFrom(base_path('Modules/ReferralCode/Database/Migrations'));



        // Load WithdrawRequest module
        if (file_exists(base_path('Modules/WithdrawRequest/Routes/web.php'))) {
            Route::middleware('web')
                ->namespace('Modules\\WithdrawRequest\\Controllers')
                ->group(base_path('Modules/WithdrawRequest/Routes/web.php'));
        }
        if (file_exists(base_path('Modules/WithdrawRequest/Routes/api.php'))) {
            Route::middleware('api')
                ->namespace('Modules\\WithdrawRequest\\Controllers')
                ->group(base_path('Modules/WithdrawRequest/Routes/api.php'));
        }
        $this->loadViewsFrom(base_path('Modules/WithdrawRequest/Views'), 'WithdrawRequest');
        $this->loadMigrationsFrom(base_path('Modules/WithdrawRequest/Database/Migrations'));

        // Load TopUpRequest module
        if (file_exists(base_path('Modules/TopUpRequest/Routes/web.php'))) {
            Route::middleware('web')
                ->namespace('Modules\\TopUpRequest\\Controllers')
                ->group(base_path('Modules/TopUpRequest/Routes/web.php'));
        }
        if (file_exists(base_path('Modules/TopUpRequest/Routes/api.php'))) {
            Route::middleware('api')
                ->namespace('Modules\\TopUpRequest\\Controllers')
                ->group(base_path('Modules/TopUpRequest/Routes/api.php'));
        }
        $this->loadViewsFrom(base_path('Modules/TopUpRequest/Views'), 'TopUpRequest');
        $this->loadMigrationsFrom(base_path('Modules/TopUpRequest/Database/Migrations'));

        // Load Transaction module
        if (file_exists(base_path('Modules/Transaction/Routes/web.php'))) {
            Route::middleware('web')
                ->namespace('Modules\\Transaction\\Controllers')
                ->group(base_path('Modules/Transaction/Routes/web.php'));
        }

        if (file_exists(base_path('Modules/Transaction/Routes/api.php'))) {
            Route::middleware('api')
                ->namespace('Modules\\Transaction\\Controllers')
                ->group(base_path('Modules/Transaction/Routes/api.php'));
        }
        $this->loadViewsFrom(base_path('Modules/Transaction/Views'), 'transaction');
        $this->loadMigrationsFrom(base_path('Modules/Transaction/Database/Migrations'));
    }
}
