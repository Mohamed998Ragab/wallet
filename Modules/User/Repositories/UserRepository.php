<?php

namespace Modules\User\Repositories;

use Modules\User\Models\User;
use Modules\User\Repositories\UserRepositoryInterface;
use Modules\Wallet\Models\Wallet;

class UserRepository implements UserRepositoryInterface
{
    public function create(array $data): User
    {
        // First create the wallet
        $wallet = Wallet::create([
            'balance' => 0,
            'held_balance' => 0
        ]);

        // Then create the user with the wallet_id
        $user = User::create(array_merge($data, [
            'wallet_id' => $wallet->id
        ]));

        return $user;
    }

    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function findById(int $id): ?User
    {
        return User::find($id);
    }
}
