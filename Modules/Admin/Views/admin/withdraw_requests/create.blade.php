<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Withdrawal Request</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8 max-w-md">
        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">Create Withdrawal Request</h1>
                <a href="{{ route('admin.dashboard') }}" 
                   class="text-blue-500 hover:text-blue-700">
                    Cancel
                </a>
            </div>

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.withdrawals.store') }}">
                @csrf
                <div class="mb-4">
                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">Amount</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">$</span>
                        </div>
                        <input type="number" name="amount" id="amount" step="0.01" min="0.01" required
                               value="{{ old('amount') }}"
                               class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-7 pr-12 py-2 sm:text-sm border-gray-300 rounded-md"
                               placeholder="0.00">
                    </div>
                </div>
                <div class="mt-6">
                    <button type="submit" 
                            class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md transition-colors">
                        Submit Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>