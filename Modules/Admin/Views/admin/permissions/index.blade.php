<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permission Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-100 text-gray-800">

    <div class="max-w-7xl mx-auto py-8 px-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold flex items-center">
                🔐 Permission Management
            </h1>
            <a href="{{ route('admin.dashboard') }}" 
               class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded transition-colors">
                ← Back to Dashboard
            </a>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <!-- Permission Assignment Form -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-8" x-data="permissionManager()">
            <h2 class="text-xl font-semibold mb-6 flex items-center">
                👥 Assign Permissions to Admin
            </h2>

            <form @submit.prevent="submitPermissions()">
                @csrf
                
                <!-- Admin Selection -->
                <div class="mb-6">
                    <label for="admin_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Select Admin
                    </label>
                    <select x-model="selectedAdmin" 
                            @change="loadAdminPermissions()"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Choose an admin...</option>
                        @foreach($admins as $admin)
                            <option value="{{ $admin->id }}">{{ $admin->name }} ({{ $admin->email }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Loading State -->
                <div x-show="loading" class="text-center py-4">
                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500"></div>
                    <p class="mt-2 text-gray-600">Loading permissions...</p>
                </div>

                <!-- Permissions Grid -->
                <div x-show="selectedAdmin && !loading" class="mb-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Permissions</h3>
                        <div class="flex gap-2">
                            <button type="button" @click="selectAll()" 
                                    class="text-sm bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded">
                                Select All
                            </button>
                            <button type="button" @click="selectNone()" 
                                    class="text-sm bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                                Select None
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($permissions as $permission)
                            <div class="flex items-center p-3 border rounded-lg hover:bg-gray-50 transition-colors">
                                <input type="checkbox" 
                                       x-model="selectedPermissions"
                                       value="{{ $permission->id }}"
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label class="ml-3 text-sm font-medium text-gray-700 cursor-pointer flex-1">
                                    {{ ucwords(str_replace('_', ' ', $permission->name)) }}
                                    <span class="block text-xs text-gray-500">{{ $permission->name }}</span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Submit Button -->
                <div x-show="selectedAdmin && !loading" class="flex justify-end">
                    <button type="submit" 
                            :disabled="!selectedAdmin || selectedPermissions.length === 0"
                            class="bg-blue-500 hover:bg-blue-600 disabled:bg-gray-400 text-white py-2 px-6 rounded transition-colors">
                        Update Permissions
                    </button>
                </div>
            </form>
        </div>

        <!-- All Permissions List -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-6 flex items-center">
                📋 All Available Permissions
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($permissions as $permission)
                    <div class="p-4 border rounded-lg bg-gray-50">
                        <h3 class="font-medium text-gray-900">
                            {{ ucwords(str_replace('_', ' ', $permission->name)) }}
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">{{ $permission->name }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        function permissionManager() {
            return {
                selectedAdmin: '',
                selectedPermissions: [],
                loading: false,
                
                async loadAdminPermissions() {
                    if (!this.selectedAdmin) {
                        this.selectedPermissions = [];
                        return;
                    }
                    
                    this.loading = true;
                    
                    try {
                        const response = await fetch(`/admin/permissions/admin-permissions?admin_id=${this.selectedAdmin}`, {
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json',
                            }
                        });
                        
                        if (response.ok) {
                            const data = await response.json();
                            this.selectedPermissions = data.permissions;
                        } else {
                            console.error('Failed to load admin permissions');
                            this.selectedPermissions = [];
                        }
                    } catch (error) {
                        console.error('Error loading admin permissions:', error);
                        this.selectedPermissions = [];
                    } finally {
                        this.loading = false;
                    }
                },
                
                async submitPermissions() {
                    if (!this.selectedAdmin) return;
                    
                    this.loading = true;
                    
                    try {
                        const formData = new FormData();
                        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                        formData.append('admin_id', this.selectedAdmin);
                        
                        this.selectedPermissions.forEach(permissionId => {
                            formData.append('permissions[]', permissionId);
                        });
                        
                        const response = await fetch('/admin/permissions/bulk-assign', {
                            method: 'POST',
                            body: formData
                        });
                        
                        if (response.ok) {
                            window.location.reload();
                        } else {
                            alert('Failed to update permissions. Please try again.');
                        }
                    } catch (error) {
                        console.error('Error updating permissions:', error);
                        alert('An error occurred. Please try again.');
                    } finally {
                        this.loading = false;
                    }
                },
                
                selectAll() {
                    const allPermissions = @json($permissions->pluck('id'));
                    this.selectedPermissions = [...allPermissions];
                },
                
                selectNone() {
                    this.selectedPermissions = [];
                }
            }
        }
    </script>
</body>
</html>