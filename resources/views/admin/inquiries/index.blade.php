<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div
                class="w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg shadow-orange-500/20">
                <i class="fas fa-exclamation-circle text-white text-lg"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">
                    {{ __('Product Inquiries & Issues') }}
                </h2>
                <p class="text-sm text-gray-500">Manage customer complaints and product issues</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-b from-gray-50 to-white min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Inquiries Table -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                                <th class="text-left p-5 text-xs font-bold text-gray-400 uppercase tracking-wider">Date
                                </th>
                                <th class="text-left p-5 text-xs font-bold text-gray-400 uppercase tracking-wider">
                                    Customer</th>
                                <th class="text-left p-5 text-xs font-bold text-gray-400 uppercase tracking-wider">
                                    Product</th>
                                <th class="text-left p-5 text-xs font-bold text-gray-400 uppercase tracking-wider">Issue
                                </th>
                                <th class="text-left p-5 text-xs font-bold text-gray-400 uppercase tracking-wider">
                                    Status</th>
                                <th class="text-left p-5 text-xs font-bold text-gray-400 uppercase tracking-wider">
                                    Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($inquiries as $inq)
                                <tr class="hover:bg-gray-50/50 transition-colors group">
                                    <!-- Date -->
                                    <td class="p-5">
                                        <span class="text-sm text-gray-600 flex items-center gap-1">
                                            <i class="fas fa-calendar text-gray-400 text-xs"></i>
                                            {{ $inq->created_at->format('d M Y') }}
                                        </span>
                                    </td>

                                    <!-- Customer -->
                                    <td class="p-5">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 rounded-lg bg-gradient-to-br from-gray-200 to-gray-100 flex items-center justify-center text-gray-500 font-bold text-xs">
                                                {{ strtoupper(substr($inq->user->name, 0, 1)) }}
                                            </div>
                                            <span class="font-medium text-gray-800 text-sm">{{ $inq->user->name }}</span>
                                        </div>
                                    </td>

                                    <!-- Product -->
                                    <td class="p-5">
                                        <span class="text-sm text-gray-600">{{ $inq->product->name }}</span>
                                    </td>

                                    <!-- Issue Preview -->
                                    <td class="p-5">
                                        <span class="text-sm text-red-600 italic">{{ Str::limit($inq->message, 40) }}</span>
                                    </td>

                                    <!-- Status Badge -->
                                    <td class="p-5">
                                        @php
                                            $statusConfig = [
                                                'pending' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'border' => 'border-amber-200', 'icon' => 'fa-clock'],
                                                'processing' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'border' => 'border-blue-200', 'icon' => 'fa-spinner'],
                                                'resolved' => ['bg' => 'bg-green-50', 'text' => 'text-green-700', 'border' => 'border-green-200', 'icon' => 'fa-check-circle'],
                                            ];
                                            $config = $statusConfig[$inq->status] ?? $statusConfig['pending'];
                                        @endphp
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-wider border {{ $config['bg'] }} {{ $config['text'] }} {{ $config['border'] }}">
                                            <i class="fas {{ $config['icon'] }}"></i>
                                            {{ ucfirst($inq->status) }}
                                        </span>
                                    </td>

                                    <!-- Action -->
                                    <td class="p-5">
                                        <div x-data="{ openReply: false }">
                                            <button @click="openReply = true"
                                                class="inline-flex items-center gap-2 bg-gradient-to-r from-[#1a1a1a] to-[#333] text-white px-4 py-2 rounded-lg text-xs font-bold hover:from-[#d4af37] hover:to-[#b5952f] transition-all duration-300 shadow-sm">
                                                <i class="fas fa-reply"></i>
                                                View & Reply
                                            </button>

                                            <!-- Modal -->
                                            <div x-show="openReply" style="display: none;"
                                                x-transition:enter="transition ease-out duration-300"
                                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                                x-transition:leave="transition ease-in duration-200"
                                                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                                class="fixed inset-0 z-50 overflow-y-auto">
                                                <div class="flex items-center justify-center min-h-screen p-4">
                                                    <div class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm"
                                                        @click="openReply = false"></div>

                                                    <div
                                                        class="relative bg-white rounded-2xl shadow-2xl max-w-lg w-full p-8 border-t-4 border-orange-500">
                                                        <!-- Modal Header -->
                                                        <div class="flex items-center gap-4 mb-6">
                                                            <div
                                                                class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                                                                <i
                                                                    class="fas fa-exclamation-triangle text-orange-600 text-xl"></i>
                                                            </div>
                                                            <div>
                                                                <h3 class="text-xl font-bold text-gray-900"
                                                                    style="font-family: 'Playfair Display', serif;">Issue
                                                                    Details</h3>
                                                                <p class="text-xs text-gray-500">From {{ $inq->user->name }}
                                                                    about {{ $inq->product->name }}</p>
                                                            </div>
                                                        </div>

                                                        <!-- Issue Message -->
                                                        <div
                                                            class="bg-red-50 border-l-4 border-red-400 p-4 rounded-r-xl mb-6">
                                                            <p class="text-sm text-red-700 italic">"{{ $inq->message }}"</p>
                                                        </div>

                                                        <form action="{{ route('admin.inquiries.update', $inq->id) }}"
                                                            method="POST" class="space-y-5">
                                                            @csrf

                                                            <!-- Reply -->
                                                            <div>
                                                                <label
                                                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                                                    <i class="fas fa-reply text-green-500 mr-1"></i> Admin
                                                                    Reply / Solution
                                                                </label>
                                                                <textarea name="admin_reply" rows="3"
                                                                    class="w-full border-2 border-gray-200 rounded-xl focus:border-[#d4af37] focus:ring-[#d4af37] transition-all p-4"
                                                                    placeholder="Type your response here...">{{ $inq->admin_reply }}</textarea>
                                                            </div>

                                                            <!-- Status -->
                                                            <div>
                                                                <label
                                                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                                                    <i class="fas fa-flag text-blue-500 mr-1"></i> Update
                                                                    Status
                                                                </label>
                                                                <select name="status"
                                                                    class="w-full border-2 border-gray-200 rounded-xl py-3 px-4 focus:border-[#d4af37] focus:ring-[#d4af37] cursor-pointer">
                                                                    <option value="pending" {{ $inq->status == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                                                    <option value="processing" {{ $inq->status == 'processing' ? 'selected' : '' }}>🔍 Processing</option>
                                                                    <option value="resolved" {{ $inq->status == 'resolved' ? 'selected' : '' }}>✅ Resolved</option>
                                                                </select>
                                                            </div>

                                                            <!-- Actions -->
                                                            <div class="flex justify-end gap-3 pt-4">
                                                                <button type="button" @click="openReply = false"
                                                                    class="px-6 py-3 border-2 border-gray-200 text-gray-600 rounded-xl font-semibold hover:bg-gray-50 transition-colors">
                                                                    Cancel
                                                                </button>
                                                                <button type="submit"
                                                                    class="inline-flex items-center gap-2 bg-gradient-to-r from-green-500 to-green-600 text-white px-6 py-3 rounded-xl font-bold uppercase text-sm tracking-widest hover:shadow-lg hover:shadow-green-500/30 transition-all duration-300">
                                                                    <i class="fas fa-check"></i>
                                                                    Update Inquiry
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="p-5 border-t border-gray-100">
                    {{ $inquiries->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
