<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Wallet</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

    <div class="max-w-3xl mx-auto py-12 px-6">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">💼 Wallet</h1>
            <a href="{{ route('admin.dashboard') }}"
               class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">
                ← Back to Dashboard
            </a>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                <div class="p-4 border rounded text-center">
                    <p class="text-gray-500">Total Balance</p>
                    <p class="text-2xl font-semibold text-green-600">{{ number_format($wallet->balance, 2) }} EGP</p>
                </div>

                <div class="p-4 border rounded text-center">
                    <p class="text-gray-500">Held Balance</p>
                    <p class="text-2xl font-semibold text-yellow-500">{{ number_format($wallet->held_balance, 2) }} EGP</p>
                </div>

                <div class="p-4 border rounded text-center sm:col-span-2">
                    <p class="text-gray-500">Available Balance</p>
                    <p class="text-3xl font-bold text-blue-600">{{ number_format($wallet->balance - $wallet->held_balance, 2) }} EGP</p>
                </div>

            </div>
        </div>
    </div>

</body>
</html>
