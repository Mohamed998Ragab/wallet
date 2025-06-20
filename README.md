# Wallet System with Permissions, Notifications, and API

This project is a robust wallet system built with Laravel, featuring separate admin and user interfaces, custom permissions, notifications, and a RESTful API. It includes superadmin functionality that bypasses all permission checks, along with seeders for initial data setup.

## Features

- **Admin Dashboard:**

  - Superadmin can perform all actions without permission restrictions
  - Manage permissions (superadmin only)
  - View and manage withdrawal requests
  - View and manage top-up requests
  - Generate and view referral codes
  - View wallet balance and transactions

- **User API:**

  - Register with an optional referral code (10 EGP bonus for both referrer and referee)
  - Login and logout
  - Generate referral code
  - Create top-up requests
  - View wallet balance and transactions

- **Permissions:**

  - Custom manual permission system (no external packages)
  - Superadmin bypasses all permission checks
  - Other admins require specific permissions assigned by superadmin

- **Notifications:**

  - Dashboard and email notifications for admins on new requests

- **Database:**

  - Tables: `admins`, `users`, `wallets`, `permissions`, `admin_permissions`, `referral_codes`, `withdrawal_requests`, `top_up_requests`, `transactions`

## Installation

1. **Clone the repository:**

   ```bash
   git clone 
   
   ```

   **Install dependencies:**

   ```bash
   composer install
   npm install
   ```

2. **Set up environment variables:**

   - Copy `.env.example` to `.env`
   - Update database credentials and mail settings in `.env`

3. **Run migrations and seeders:**

   ```bash
   php artisan migrate --seed
   ```

4. **Start the development server:**

   ```bash
   php artisan serve
   ```

5. **Access the application:**

   - Admin Dashboard: `http://localhost:8000/admin/login`
   - API Base URL: `http://localhost:8000/`

## Usage

### Admin Dashboard

- **Login:** Use seeded admin credentials (e.g., `admin1@example.com` / `password`) or create a new admin.
- **Superadmin:** Identified by `is_superadmin = 1`, can perform any action without permission checks.
- **Permissions:** Superadmin manages permissions for other admins via the permissions management interface.
- **Withdrawal Requests:** Admins can create, approve, or reject requests; superadmin can act without restrictions.
- **Top-up Requests:** Admins can approve or reject user top-up requests; superadmin has full control.
- **Referral Codes:** Generate and view referral codes for bonus incentives.

### User API

- **Register:** `POST /register` - Create a new user with an optional referral code.
- **Login:** `POST /login` - Authenticate and receive a token.
- **Logout:** `POST /logout` - Invalidate the current token.
- **Generate Referral Code:** `GET /referral/generate` - Create a new referral code.
- **Create Top-up Request:** `POST /top-up` - Request a wallet top-up.
- **View Top-up Requests:** Get /top-up-requests  - View top-ups requests.
- **View Wallet:** `GET /wallet` - Check wallet balances.
- **View Transactions:** `GET /transactions` - List wallet transactions.

## API Documentation

Detailed API documentation is available in API.md.

## Database Schema

- **admins:** `id`, `name`, `email`, `password`, `is_superadmin`, `wallet_id`, `timestamps`
- **users:** `id`, `name`, `email`, `password`, `wallet_id`, `referred_by_id`, `timestamps`
- **wallets:** `id`, `balance`, `held_balance`, `timestamps`
- **permissions:** `id`, `name`, `timestamps`
- **admin_permissions:** `admin_id`, `permission_id`, `timestamps`
- **referral_codes:** `id`, `code`, `generator_id`, `generator_type`, `used_by_user_id`, `timestamps`
- **withdrawal_requests:** `id`, `admin_id`, `amount`, `status`, `approved_by_admin_id`, `rejection_reason`, `processed_at`, `timestamps`
- **top_up_requests:** `id`, `user_id`, `amount`, `status`, `approved_by_admin_id`, `rejection_reason`, `processed_at`, `timestamps`
- **transactions:** `id`, `wallet_id`, `amount`, `type`, `request_id`, `request_type`, `timestamps`

## Seeders

The project includes seeders to populate initial data:

- **WalletSeeder:** Creates sample wallets with balances.
- **PermissionSeeder:** Seeds a comprehensive list of permissions.
- **AdminSeeder:** Creates sample admins, including a superadmin.
- **TransactionSeeder:** Adds sample transactions.

Run the seeders with:

```bash
php artisan db:seed
```

## Views

Admin dashboard views (built with Tailwind CSS):

- **Dashboard:** Overview with notifications and quick links
- **Login:** Admin authentication
- **Permissions Management:** Superadmin-only interface for assigning permissions
- **Referral Codes:** View and generate referral codes
- **Top-up Requests:** Manage user top-up requests
- **Wallet:** Display wallet balances
- **Withdrawal Requests:** Create and manage withdrawal requests

## Middleware

- **AdminPermissionMiddleware:** Enforces permission checks; superadmin bypasses all checks.
- **EnsureSuperAdmin:** Restricts routes to superadmin only.

## Notifications

- **NewWithdrawalRequestNotification:** Alerts admins of new withdrawal requests.
- **NewTopUpRequestNotification:** Notifies admins of new top-up requests.
If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
