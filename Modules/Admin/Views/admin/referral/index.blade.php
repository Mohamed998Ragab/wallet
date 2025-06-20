<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Referral Codes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">My Referral Codes</h1>
            <div class="flex gap-4">
                <a href="{{ route('admin.referral.generate') }}"
                   class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    Generate New Code
                </a>
                <a href="{{ route('admin.dashboard') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                    Back to Dashboard
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <!-- Current Unused Referral Codes -->
        <div class="bg-white shadow rounded-lg p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4">Available Referral Codes</h2>
            
            @if($unusedCodes->isNotEmpty())
                <div class="space-y-4">
                    @foreach($unusedCodes as $code)
                        <div class="border rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="font-mono text-xl font-bold">{{ $code->code }}</span>
                                    <span class="ml-4 px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        Active
                                    </span>
                                </div>
                                <span class="text-sm text-gray-500">Created: {{ $code->created_at->format('M d, Y H:i') }}</span>
                            </div>
                            
                            <div class="mt-3">
                                <h3 class="font-medium mb-2">Share this code:</h3>
                                <div class="flex">
                                    <input type="text" value="{{ $code->code }}" 
                                           class="flex-1 border rounded-l px-4 py-2" readonly>
                                    <button onclick="copyToClipboard('{{ $code->code }}')"
                                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-r">
                                        Copy
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <p class="text-gray-500 mb-4">You don't have any active referral codes</p>
                </div>
            @endif
        </div>

        <!-- Used Referral Codes History -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Referral History</h2>
            
            @if($usedCodes->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Used By</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Used</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($usedCodes as $code)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap font-mono">{{ $code->code }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($code->used_by_user_id)
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">{{ $code->usedByUser->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $code->usedByUser->email }}</div>
                                            </div>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $code->updated_at->format('M d, Y H:i') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 text-center py-8">No used referral codes yet</p>
            @endif
        </div>
    </div>

    <script>
        function copyToClipboard(code) {
            const tempInput = document.createElement('input');
            tempInput.value = code;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand('copy');
            document.body.removeChild(tempInput);
            
            // Show tooltip or alert
            alert('Referral code copied to clipboard!');
        }
    </script>
</body>
</html>