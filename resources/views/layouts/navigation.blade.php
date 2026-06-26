<nav x-data="{ open: false, scrolled: false }"
    x-init="window.addEventListener('scroll', () => { scrolled = window.pageYOffset > 20 })"
    :class="{ 'nav-glass shadow-lg': scrolled, 'bg-white border-b border-gray-100': !scrolled }"
    class="sticky top-0 z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex w-full justify-between items-center">

                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="group flex items-center gap-1"
                        style="text-decoration: none;">
                        <h1 class="text-xl md:text-2xl font-bold text-gray-900 tracking-wider transition-all duration-300 group-hover:tracking-widest"
                            style="font-family: 'Playfair Display', serif;">
                            FASHION GALLERY<span
                                class="text-[#d4af37] group-hover:text-gray-900 transition duration-300">.</span>
                        </h1>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden sm:flex sm:items-center sm:space-x-1">



                    <!-- Designer Studio (Only for designers) -->
                    @if(Auth::user()->role === 'designer')
                        <x-nav-link :href="route('designer.show', Auth::id())" :active="request()->routeIs('designer.show')"
                            class="group flex items-center gap-2 px-4 py-2 rounded-full text-gray-600 hover:text-gray-900 hover:bg-gray-100/80 transition-all duration-300"
                            style="font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 0.9rem;">
                            <i
                                class="fas fa-palette {{ request()->routeIs('designer.show') ? 'text-[#d4af37]' : 'text-gray-400 group-hover:text-[#d4af37]' }} transition duration-300"></i>
                            <span>{{ __('My Studio') }}</span>
                        </x-nav-link>
                    @endif

                    <!-- Profile -->
                    <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')"
                        class="group flex items-center gap-2 px-4 py-2 rounded-full text-gray-600 hover:text-gray-900 hover:bg-gray-100/80 transition-all duration-300"
                        style="font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 0.9rem;">
                        <i
                            class="fas fa-user {{ request()->routeIs('profile.edit') ? 'text-[#d4af37]' : 'text-gray-400 group-hover:text-[#d4af37]' }} transition duration-300"></i>
                        <span>{{ __('Profile') }}</span>
                    </x-nav-link>

                    @if(Auth::user()->role === 'admin')
                        <x-nav-link :href="route('admin.users')" :active="request()->routeIs('admin.users')"
                            class="group flex items-center gap-2 px-4 py-2 rounded-full text-gray-600 hover:text-gray-900 hover:bg-gray-100/80 transition-all duration-300"
                            style="font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 0.9rem;">
                            <i class="fas fa-user-shield {{ request()->routeIs('admin.users') ? 'text-[#d4af37]' : 'text-gray-400 group-hover:text-[#d4af37]' }} transition duration-300"></i>
                            <span>{{ __('Admin') }}</span>
                        </x-nav-link>
                    @endif

                    @if(Auth::check() && Auth::user()->role === 'admin')
                        <x-nav-link :href="route('admin.inquiries')" :active="request()->routeIs('admin.inquiries')"
                            class="group flex items-center gap-2 px-4 py-2 rounded-full text-gray-600 hover:text-gray-900 hover:bg-gray-100/80 transition-all duration-300"
                            style="font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 0.9rem;">
                            <i class="fas fa-exclamation-circle {{ request()->routeIs('admin.inquiries') ? 'text-[#d4af37]' : 'text-gray-400 group-hover:text-[#d4af37]' }} transition duration-300"></i>
                            <span>{{ __('Inquiries') }}</span>
                        </x-nav-link>
                    @endif







                    <!-- My Orders -->
                    <x-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.index')"
                        class="group flex items-center gap-2 px-4 py-2 rounded-full text-gray-600 hover:text-gray-900 hover:bg-gray-100/80 transition-all duration-300"
                        style="font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 0.9rem;">
                        <i
                            class="fas fa-box {{ request()->routeIs('orders.index') ? 'text-[#d4af37]' : 'text-gray-400 group-hover:text-[#d4af37]' }} transition duration-300"></i>
                        <span class="hidden md:inline">{{ __('Orders') }}</span>
                    </x-nav-link>

                    <!-- VFR -->
                    <x-nav-link :href="route('TryOn')" :active="request()->routeIs('TryOn')"
                        class="group flex items-center gap-2 px-4 py-2 rounded-full text-gray-600 hover:text-gray-900 hover:bg-gray-100/80 transition-all duration-300"
                        style="font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 0.9rem;">
                        <i
                            class="fas fa-person-booth {{ request()->routeIs('TryOn') ? 'text-[#d4af37]' : 'text-gray-400 group-hover:text-[#d4af37]' }} transition duration-300"></i>
                        <span class="hidden md:inline">{{ __('Try-On') }}</span>
                    </x-nav-link>

                    <x-nav-link :href="route('customizer.index')" :active="request()->routeIs('customizer.index')"
                        class="group flex items-center gap-2 px-4 py-2 rounded-full text-gray-600 hover:text-gray-900 hover:bg-gray-100/80 transition-all duration-300"
                        style="font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 0.9rem;">

                        <i class="fas fa-shirt {{ request()->routeIs('customizer.index') ? 'text-[#d4af37]' : 'text-gray-400 group-hover:text-[#d4af37]' }} transition duration-300"></i>

                        <span>{{ __('Designer') }}</span>
                    </x-nav-link>

                    <!-- Cart with Badge -->
                    <x-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')"
                        class="group flex items-center gap-2 px-4 py-2 rounded-full text-gray-600 hover:text-gray-900 hover:bg-gray-100/80 transition-all duration-300 relative"
                        style="font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 0.9rem;">
                        <div class="relative">
                            <i
                                class="fas fa-shopping-bag text-lg {{ request()->routeIs('cart.index') ? 'text-[#d4af37]' : 'text-gray-400 group-hover:text-[#d4af37]' }} transition duration-300"></i>
                            @php
                                $cartCount = \App\Models\CartItem::where('user_id', Auth::id())->sum('quantity');
                            @endphp
                            @if($cartCount > 0)
                                <span
                                    class="absolute -top-2 -right-2.5 bg-gradient-to-r from-[#d4af37] to-[#e5c76b] text-white text-[10px] font-bold min-w-[18px] h-[18px] flex items-center justify-center rounded-full shadow-md animate-pulse">
                                    {{ $cartCount > 9 ? '9+' : $cartCount }}
                                </span>
                            @endif
                        </div>
                    </x-nav-link>

                    <!-- Divider -->
                    <div class="h-6 w-px bg-gray-200 mx-2"></div>

                    <!-- Logout Button -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="group flex items-center gap-2 px-5 py-2.5 rounded-full border-2 border-gray-200 text-gray-600 hover:border-[#d4af37] hover:bg-[#d4af37] hover:text-white transition-all duration-300 ease-out cursor-pointer hover:shadow-lg hover:shadow-[#d4af37]/20"
                            style="font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 0.85rem;">
                            <i class="fas fa-sign-out-alt group-hover:rotate-12 transition-transform duration-300"></i>
                            <span>{{ __('Log Out') }}</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Mobile Menu Button -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2.5 rounded-xl text-gray-500 hover:text-[#d4af37] hover:bg-gray-100 focus:outline-none transition duration-300">
                    <div class="relative w-6 h-5">
                        <span class="absolute left-0 w-full h-0.5 bg-current transform transition-all duration-300"
                            :class="{ 'rotate-45 top-2': open, 'top-0': !open }"></span>
                        <span class="absolute left-0 top-2 w-full h-0.5 bg-current transition-all duration-300"
                            :class="{ 'opacity-0': open }"></span>
                        <span class="absolute left-0 w-full h-0.5 bg-current transform transition-all duration-300"
                            :class="{ '-rotate-45 top-2': open, 'top-4': !open }"></span>
                    </div>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <div x-show="open" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4" class="sm:hidden bg-white border-t border-gray-100 shadow-lg"
        style="display: none;">
        <div class="pt-3 pb-4 px-4 space-y-1">

            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-50 transition">
                <i class="fas fa-th-large text-[#d4af37]"></i>
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @if(Auth::user()->role === 'designer')
                <x-responsive-nav-link :href="route('designer.show', Auth::id())"
                    :active="request()->routeIs('designer.show')"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-50 transition">
                    <i class="fas fa-palette text-[#d4af37]"></i>
                    {{ __('My Studio') }}
                </x-responsive-nav-link>
            @endif

            <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')"
                class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-50 transition">
                <i class="fas fa-user text-[#d4af37]"></i>
                {{ __('Profile') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.index')"
                class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-50 transition">
                <i class="fas fa-box text-[#d4af37]"></i>
                {{ __('My Orders') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')"
                class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-50 transition">
                <i class="fas fa-shopping-bag text-[#d4af37]"></i>
                {{ __('Cart') }}
                @if($cartCount > 0)
                    <span
                        class="ml-auto bg-[#d4af37] text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $cartCount }}</span>
                @endif
            </x-responsive-nav-link>

            <div class="border-t border-gray-100 pt-3 mt-3">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-500 hover:bg-red-50 transition">
                        <i class="fas fa-sign-out-alt"></i>
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>

        <!-- User Info Card -->
        <div class="px-4 pb-4">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl p-4 border border-gray-200">
                <div class="flex items-center gap-3">
                    <div
                        class="w-12 h-12 rounded-full bg-gradient-to-br from-[#d4af37] to-[#b5952f] flex items-center justify-center text-white font-bold text-lg shadow-md">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="font-semibold text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<style>
    .nav-glass {
        background: rgba(255, 255, 255, 0.95) !important;
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
    }
</style>
