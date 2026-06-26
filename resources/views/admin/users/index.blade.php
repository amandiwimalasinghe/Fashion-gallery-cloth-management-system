<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div
                class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center shadow-lg shadow-red-500/20">
                <i class="fas fa-users-cog text-white text-lg"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">
                    {{ __('User Management') }}
                </h2>
                <p class="text-sm text-gray-500">Admin Dashboard - Manage all system users</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-b from-gray-50 to-white min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
                <div
                    class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-lg transition-shadow">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-md">
                        <i class="fas fa-users text-white text-xl"></i>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-gray-900">{{ $users->total() }}</div>
                        <div class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Total Users</div>
                    </div>
                </div>
            </div>

            <!-- Users Table -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                                <th class="text-left p-5 text-xs font-bold text-gray-400 uppercase tracking-wider">ID
                                </th>
                                <th class="text-left p-5 text-xs font-bold text-gray-400 uppercase tracking-wider">User
                                </th>
                                <th class="text-left p-5 text-xs font-bold text-gray-400 uppercase tracking-wider">Email
                                </th>
                                <th class="text-left p-5 text-xs font-bold text-gray-400 uppercase tracking-wider">Role
                                </th>
                                <th class="text-left p-5 text-xs font-bold text-gray-400 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($users as $user)
                                <tr class="hover:bg-gray-50/50 transition-colors group">
                                    <!-- ID -->
                                    <td class="p-5">
                                        <span class="text-sm font-bold text-gray-400">#{{ $user->id }}</span>
                                    </td>

                                    <!-- User -->
                                    <td class="p-5">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 rounded-xl bg-gradient-to-br from-gray-200 to-gray-100 flex items-center justify-center text-gray-500 font-bold border border-gray-200">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <span class="font-bold text-gray-800">{{ $user->name }}</span>
                                        </div>
                                    </td>

                                    <!-- Email -->
                                    <td class="p-5">
                                        <span class="text-gray-600 text-sm">{{ $user->email }}</span>
                                    </td>

                                    <!-- Role Badge -->
                                    <td class="p-5">
                                        @php
                                            $roleConfig = [
                                                'admin' => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'border' => 'border-red-200', 'icon' => 'fa-shield-alt'],
                                                'designer' => ['bg' => 'bg-purple-50', 'text' => 'text-purple-700', 'border' => 'border-purple-200', 'icon' => 'fa-palette'],
                                                'tailor' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'border' => 'border-blue-200', 'icon' => 'fa-cut'],
                                                'customer' => ['bg' => 'bg-gray-50', 'text' => 'text-gray-700', 'border' => 'border-gray-200', 'icon' => 'fa-user'],
                                                'user' => ['bg' => 'bg-gray-50', 'text' => 'text-gray-700', 'border' => 'border-gray-200', 'icon' => 'fa-user'],
                                            ];
                                            $config = $roleConfig[$user->role] ?? $roleConfig['user'];
                                        @endphp
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-wider border {{ $config['bg'] }} {{ $config['text'] }} {{ $config['border'] }}">
                                            <i class="fas {{ $config['icon'] }}"></i>
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>

                                    <!-- Actions -->
                                    <td class="p-5">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('admin.users.edit', $user->id) }}"
                                                class="w-9 h-9 bg-gradient-to-r from-amber-400 to-amber-500 text-white rounded-lg flex items-center justify-center hover:shadow-lg hover:shadow-amber-500/30 transition-all duration-300"
                                                title="Edit">
                                                <i class="fas fa-edit text-sm"></i>
                                            </a>

                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                                class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="confirmDelete(this)"
                                                    class="w-9 h-9 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-lg flex items-center justify-center hover:shadow-lg hover:shadow-red-500/30 transition-all duration-300"
                                                    title="Delete">
                                                    <i class="fas fa-trash-alt text-sm"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="p-5 border-t border-gray-100">
                    {{ $users->links() }}
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(button) {
            Swal.fire({
                title: 'Delete User?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: '<i class="fas fa-trash mr-2"></i>Yes, delete!',
                cancelButtonText: 'Cancel',
                background: '#fff',
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-full px-6 py-3 font-bold uppercase text-sm tracking-wider',
                    cancelButton: 'rounded-full px-6 py-3 font-bold uppercase text-sm tracking-wider'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit();
                }
            });
        }
    </script>
</x-app-layout>