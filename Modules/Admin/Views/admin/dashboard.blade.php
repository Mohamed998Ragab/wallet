<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-800">

    <div class="max-w-6xl mx-auto py-10 px-6">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">Admin Dashboard</h1>
            <div class="flex gap-4">
                @auth('admin')
                    @if (auth('admin')->user()->isSuperAdmin())
                        <a href="{{ route('admin.permissions.index') }}"
                            class="bg-purple-500 hover:bg-purple-600 text-white py-2 px-4 rounded">
                            🔐 Manage Permissions
                        </a>
                    @endif
                @endauth
                <a href="{{ route('admin.logout') }}" class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded">
                    Logout
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @auth('admin')
            <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                <h2 class="text-xl font-semibold mb-4">Notifications</h2>

                @php
                    $notifications = auth('admin')->user()?->unreadNotifications;
                @endphp

                @if ($notifications && $notifications->count())
                    <ul class="space-y-2">
                        @foreach ($notifications as $notification)
                            <li class="p-3 bg-gray-50 border rounded">
                                {{ $notification->data['message'] ?? 'No message' }}
                                @if (!empty($notification->data['link']))
                                    - <a href="{{ $notification->data['link'] }}" class="text-blue-600 underline">View</a>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500">No new notifications.</p>
                @endif
            </div>
        @endauth

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            <a href="{{ route('admin.wallet.show') }}"
                class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition text-center">
                💼 <div class="font-semibold mt-2">View Wallet</div>
            </a>

            <a href="{{ route('admin.withdrawals.create') }}"
                class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition text-center">
                💸 <div class="font-semibold mt-2">Request Withdrawal</div>
            </a>

            <a href="{{ route('admin.withdrawals.index') }}"
                class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition text-center">
                📄 <div class="font-semibold mt-2">Manage Withdrawals</div>
            </a>

            <a href="{{ route('admin.topups.index') }}"
                class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition text-center">
                🔁 <div class="font-semibold mt-2">Manage Top-ups</div>
            </a>

            <a href="{{ route('admin.referral.index') }}"
                class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition text-center">
                🔗 <div class="font-semibold mt-2">My Referral Codes</div>
            </a>
        </div>
    </div>

</body>

</html>
