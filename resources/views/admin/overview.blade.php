<x-app-layout>
    @php
        $hour = now()->hour;
        $greeting = $hour < 12 ? 'Good Morning' : ($hour < 17 ? 'Good Afternoon' : 'Good Evening');

        $statusMeta = [
            'pending' => ['label' => 'Pending', 'color' => '#f59e0b', 'icon' => 'fa-clock'],
            'shipped' => ['label' => 'Shipped', 'color' => '#3b82f6', 'icon' => 'fa-truck'],
            'completed' => ['label' => 'Completed', 'color' => '#22c55e', 'icon' => 'fa-check-circle'],
            'cancelled' => ['label' => 'Cancelled', 'color' => '#ef4444', 'icon' => 'fa-times-circle'],
        ];
        $statusTotal = max(1, array_sum(array_map(fn ($k) => (int) ($statusCounts[$k] ?? 0), array_keys($statusMeta))));
        $completedPercent = round(((int) ($statusCounts['completed'] ?? 0) / $statusTotal) * 100);
        $customerPercent = $totalUsers > 0 ? round(($totalCustomers / $totalUsers) * 100) : 0;
        $stockHealth = $totalProducts > 0 ? round((($totalProducts - $lowStockCount) / $totalProducts) * 100) : 100;
        $ratingPercent = round(($averageRating / 5) * 100);
    @endphp

    <style>
        .ad-wrap { background: radial-gradient(circle at 0% 0%, #fdf8ea 0%, #f8fafc 35%, #ffffff 100%); }

        /* ===== Entrance animations ===== */
        .ad-reveal { opacity: 0; transform: translateY(28px); transition: opacity .7s cubic-bezier(.2,.8,.2,1), transform .7s cubic-bezier(.2,.8,.2,1); }
        .ad-reveal.is-in { opacity: 1; transform: translateY(0); }

        /* ===== Hero ===== */
        .ad-hero {
            position: relative; overflow: hidden; border-radius: 28px;
            background: linear-gradient(135deg, #0f0f0f 0%, #1f1f1f 45%, #2b2412 100%);
            box-shadow: 0 25px 60px -20px rgba(0,0,0,.45);
        }
        .ad-hero::after {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(115deg, transparent 30%, rgba(212,175,55,.12) 50%, transparent 70%);
            background-size: 250% 100%; animation: adShine 6s linear infinite;
        }
        .ad-orb { position: absolute; border-radius: 50%; filter: blur(2px); opacity: .55; animation: adFloat 9s ease-in-out infinite; }
        .ad-orb.o1 { width: 260px; height: 260px; right: -60px; top: -90px; background: radial-gradient(circle, rgba(212,175,55,.55), transparent 70%); }
        .ad-orb.o2 { width: 180px; height: 180px; right: 22%; bottom: -90px; background: radial-gradient(circle, rgba(212,175,55,.35), transparent 70%); animation-delay: -3s; }
        .ad-orb.o3 { width: 120px; height: 120px; left: 40%; top: -50px; background: radial-gradient(circle, rgba(255,255,255,.15), transparent 70%); animation-delay: -5s; }
        .ad-gold-text { background: linear-gradient(90deg, #f5d97a, #d4af37, #f5d97a); background-size: 200% auto; -webkit-background-clip: text; background-clip: text; color: transparent; animation: adGoldFlow 4s linear infinite; }
        .ad-pill { display: inline-flex; align-items: center; gap: .5rem; padding: .45rem 1rem; border-radius: 999px; background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.12); color: #e5e7eb; font-size: .78rem; backdrop-filter: blur(8px); }
        .ad-live-dot { width: 8px; height: 8px; border-radius: 50%; background: #22c55e; box-shadow: 0 0 0 0 rgba(34,197,94,.7); animation: adPulse 1.8s infinite; }
        .ad-hero-btn { display: inline-flex; align-items: center; gap: .5rem; padding: .7rem 1.2rem; border-radius: 14px; font-size: .8rem; font-weight: 700; transition: all .3s ease; }
        .ad-hero-btn.gold { background: linear-gradient(135deg, #d4af37, #b5952f); color: #fff; box-shadow: 0 10px 25px -8px rgba(212,175,55,.7); }
        .ad-hero-btn.gold:hover { transform: translateY(-2px); box-shadow: 0 14px 30px -8px rgba(212,175,55,.9); }
        .ad-hero-btn.ghost { background: rgba(255,255,255,.08); color: #fff; border: 1px solid rgba(255,255,255,.15); }
        .ad-hero-btn.ghost:hover { background: rgba(255,255,255,.16); }

        /* ===== KPI cards ===== */
        .ad-card { position: relative; background: #fff; border-radius: 22px; border: 1px solid #f1f1f1; box-shadow: 0 4px 20px -8px rgba(15,23,42,.08); transition: transform .35s cubic-bezier(.2,.8,.2,1), box-shadow .35s ease, border-color .35s ease; overflow: hidden; }
        .ad-card:hover { transform: translateY(-6px); box-shadow: 0 22px 45px -18px rgba(15,23,42,.25); border-color: rgba(212,175,55,.35); }
        .ad-kpi::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px; background: var(--accent); }
        .ad-kpi .ad-kpi-bg { position: absolute; right: -30px; bottom: -30px; width: 130px; height: 130px; border-radius: 50%; background: var(--accent); opacity: .07; transition: transform .6s ease; }
        .ad-kpi:hover .ad-kpi-bg { transform: scale(1.5); }
        .ad-icon { width: 54px; height: 54px; border-radius: 16px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1.25rem; background: var(--accent); box-shadow: 0 10px 22px -10px var(--shadow); transition: transform .4s ease; }
        .ad-card:hover .ad-icon { transform: rotate(-8deg) scale(1.08); }
        .ad-progress { height: 6px; border-radius: 999px; background: #f1f5f9; overflow: hidden; }
        .ad-progress > span { display: block; height: 100%; width: 0; border-radius: 999px; background: var(--accent); transition: width 1.6s cubic-bezier(.2,.8,.2,1); }
        .ad-chip { font-size: .68rem; font-weight: 700; padding: .3rem .65rem; border-radius: 999px; }

        /* ===== Section titles ===== */
        .ad-title { font-family: 'Playfair Display', serif; font-weight: 700; color: #111827; }
        .ad-link { font-size: .75rem; font-weight: 700; color: #b5952f; display: inline-flex; align-items: center; gap: .35rem; transition: gap .25s ease; }
        .ad-link:hover { gap: .6rem; }

        /* ===== Lists ===== */
        .ad-row { transition: background .25s ease, padding-left .25s ease; }
        .ad-row:hover { background: linear-gradient(90deg, rgba(212,175,55,.07), transparent); padding-left: 1.75rem; }
        .ad-badge { display: inline-flex; align-items: center; gap: .3rem; padding: .25rem .6rem; border-radius: 999px; font-size: .62rem; font-weight: 800; text-transform: uppercase; letter-spacing: .05em; }
        .ad-avatar { width: 40px; height: 40px; border-radius: 14px; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; background: linear-gradient(135deg, #d4af37, #8a6d1d); box-shadow: 0 6px 14px -6px rgba(212,175,55,.8); }

        /* ===== Quick actions ===== */
        .ad-action { display: flex; flex-direction: column; align-items: center; justify-content: center; gap: .6rem; padding: 1.25rem .75rem; border-radius: 18px; background: #fff; border: 1px solid #f1f1f1; text-align: center; transition: all .3s ease; }
        .ad-action i { width: 46px; height: 46px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.05rem; color: #fff; background: var(--accent); transition: transform .35s ease; }
        .ad-action span { font-size: .78rem; font-weight: 700; color: #374151; }
        .ad-action:hover { transform: translateY(-5px); box-shadow: 0 18px 35px -18px rgba(15,23,42,.3); border-color: rgba(212,175,55,.4); }
        .ad-action:hover i { transform: scale(1.12) rotate(6deg); }

        /* ===== Stock bar ===== */
        .ad-stock-bar { height: 6px; width: 90px; background: #f1f5f9; border-radius: 999px; overflow: hidden; display: inline-block; vertical-align: middle; }
        .ad-stock-bar span { display: block; height: 100%; border-radius: 999px; }

        /* ===== Filters ===== */
        .ad-period { display: inline-flex; align-items: center; padding: .5rem 1rem; border-radius: 999px; font-size: .75rem; font-weight: 600; color: #4b5563; background: #f8fafc; border: 1px solid #eef2f7; transition: all .25s ease; cursor: pointer; }
        .ad-period:hover { border-color: rgba(212,175,55,.6); color: #b5952f; transform: translateY(-1px); }
        .ad-period.active { background: linear-gradient(135deg, #1a1a1a, #333); color: #f5d97a; border-color: transparent; box-shadow: 0 8px 18px -8px rgba(0,0,0,.5); }
        .ad-filter-toggle { display: inline-flex; align-items: center; gap: .5rem; padding: .55rem 1rem; border-radius: 12px; font-size: .78rem; font-weight: 700; color: #fff; background: linear-gradient(135deg, #d4af37, #b5952f); box-shadow: 0 8px 18px -8px rgba(212,175,55,.8); transition: all .25s ease; }
        .ad-filter-toggle:hover { transform: translateY(-1px); }
        .ad-filter-reset { display: inline-flex; align-items: center; gap: .4rem; padding: .55rem .9rem; border-radius: 12px; font-size: .75rem; font-weight: 700; color: #6b7280; border: 1px solid #e5e7eb; transition: all .25s ease; }
        .ad-filter-reset:hover { color: #ef4444; border-color: #fecaca; background: #fef2f2; }
        .ad-label { display: block; font-size: .68rem; font-weight: 700; color: #9ca3af; text-transform: uppercase; letter-spacing: .06em; margin-bottom: .35rem; }
        .ad-input { width: 100%; border-radius: 12px; border: 1px solid #e5e7eb; background: #f9fafb; font-size: .85rem; padding: .55rem .8rem; transition: all .2s ease; }
        .ad-input:focus { border-color: #d4af37; box-shadow: 0 0 0 3px rgba(212,175,55,.18); background: #fff; outline: none; }
        .ad-apply { display: inline-flex; align-items: center; justify-content: center; gap: .5rem; padding: .62rem 1rem; border-radius: 12px; font-size: .8rem; font-weight: 700; color: #fff; background: linear-gradient(135deg, #1a1a1a, #333); transition: all .25s ease; }
        .ad-apply:hover { background: linear-gradient(135deg, #d4af37, #b5952f); }
        .ad-active-chip { display: inline-flex; align-items: center; gap: .35rem; padding: .3rem .75rem; border-radius: 999px; font-size: .7rem; font-weight: 600; color: #8a6d1d; background: #fdf8ea; border: 1px solid rgba(212,175,55,.35); animation: adChipIn .4s ease both; }
        @keyframes adChipIn { from { opacity: 0; transform: scale(.85); } to { opacity: 1; transform: scale(1); } }

        /* ===== Doughnut center ===== */
        .ad-donut-center { position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; pointer-events: none; }

        @keyframes adShine { 0% { background-position: 200% 0; } 100% { background-position: -50% 0; } }
        @keyframes adFloat { 0%, 100% { transform: translate(0, 0) scale(1); } 50% { transform: translate(-18px, 14px) scale(1.06); } }
        @keyframes adGoldFlow { to { background-position: 200% center; } }
        @keyframes adPulse { 0% { box-shadow: 0 0 0 0 rgba(34,197,94,.7); } 70% { box-shadow: 0 0 0 10px rgba(34,197,94,0); } 100% { box-shadow: 0 0 0 0 rgba(34,197,94,0); } }

        @media (prefers-reduced-motion: reduce) {
            .ad-reveal { opacity: 1; transform: none; transition: none; }
            .ad-hero::after, .ad-orb, .ad-gold-text, .ad-live-dot { animation: none; }
        }
    </style>

    <div class="ad-wrap py-10 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <!-- ===== HERO ===== -->
            <section class="ad-hero ad-reveal p-8 md:p-10">
                <span class="ad-orb o1"></span>
                <span class="ad-orb o2"></span>
                <span class="ad-orb o3"></span>

                <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8">
                    <div>
                        <div class="flex flex-wrap items-center gap-3 mb-5">
                            <span class="ad-pill"><span class="ad-live-dot"></span> Live Overview</span>
                            <span class="ad-pill"><i class="far fa-calendar text-[#d4af37]"></i> {{ now()->format('l, F d, Y') }}</span>
                            <span class="ad-pill"><i class="far fa-clock text-[#d4af37]"></i> <span id="adClock">{{ now()->format('h:i:s A') }}</span></span>
                        </div>
                        <p class="text-gray-400 text-sm tracking-[0.25em] uppercase mb-2">{{ $greeting }}</p>
                        <h1 class="text-3xl md:text-4xl font-bold text-white" style="font-family: 'Playfair Display', serif;">
                            Welcome back, <span class="ad-gold-text">{{ Auth::user()->name }}</span>
                        </h1>
                        <p class="text-gray-400 mt-3 max-w-xl text-sm leading-relaxed">
                            Here's what's happening with <span class="text-white font-semibold">Fashion Gallery</span>
                            ({{ strtolower($periodLabels[$period] ?? 'all time') }}).
                            You have <span class="text-[#f5d97a] font-semibold">{{ $pendingOrders }} pending orders</span>
                            and <span class="text-[#f5d97a] font-semibold">{{ $pendingInquiries }} open inquiries</span> waiting.
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('admin.reports.sales') }}" class="ad-hero-btn gold">
                            <i class="fas fa-chart-line"></i> Sales Report
                        </a>
                        <a href="{{ route('admin.dashboard') }}" class="ad-hero-btn ghost">
                            <i class="fas fa-th-large"></i> Admin Panel
                        </a>
                    </div>
                </div>
            </section>

            <!-- ===== FILTERS ===== -->
            <section class="ad-card ad-reveal p-5" x-data="{ period: '{{ $period }}', open: {{ $activeFilters->isNotEmpty() ? 'true' : 'false' }} }">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gray-900 text-[#d4af37] flex items-center justify-center"><i class="fas fa-sliders"></i></div>
                        <div>
                            <h3 class="ad-title">Dashboard Filters</h3>
                            <p class="text-[11px] text-gray-400">Narrow down stats by period, designer, category, or payment method</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        @if($activeFilters->isNotEmpty())
                            <a href="{{ route('admin.overview') }}" class="ad-filter-reset"><i class="fas fa-rotate-left"></i> Reset</a>
                        @endif
                        <button type="button" @click="open = !open" class="ad-filter-toggle">
                            <i class="fas fa-filter"></i>
                            <span x-text="open ? 'Hide Filters' : 'Show Filters'"></span>
                            <i class="fas fa-chevron-down text-[10px] transition-transform duration-300" :class="{ 'rotate-180': open }"></i>
                        </button>
                    </div>
                </div>

                <!-- Quick period pills -->
                <div class="flex flex-wrap gap-2 mt-5">
                    @foreach($periodLabels as $key => $label)
                        @continue($key === 'custom')
                        <a href="{{ route('admin.overview', array_filter(array_merge(request()->except(['period', 'from', 'to']), ['period' => $key === 'all' ? null : $key]))) }}"
                            class="ad-period {{ $period === $key ? 'active' : '' }}">{{ $label }}</a>
                    @endforeach
                    <button type="button" @click="open = true; period = 'custom'" class="ad-period {{ $period === 'custom' ? 'active' : '' }}">
                        <i class="far fa-calendar mr-1"></i> Custom
                    </button>
                </div>

                <!-- Advanced filters -->
                <form method="GET" action="{{ route('admin.overview') }}" x-show="open" x-transition.opacity.duration.300ms
                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-4 mt-5 pt-5 border-t border-gray-100" style="display: none;">
                    <div>
                        <label class="ad-label">Period</label>
                        <select name="period" x-model="period" class="ad-input">
                            @foreach($periodLabels as $key => $label)
                                <option value="{{ $key }}" {{ $period === $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div x-show="period === 'custom'">
                        <label class="ad-label">From</label>
                        <input type="date" name="from" value="{{ request('from') }}" class="ad-input" :disabled="period !== 'custom'">
                    </div>
                    <div x-show="period === 'custom'">
                        <label class="ad-label">To</label>
                        <input type="date" name="to" value="{{ request('to') }}" class="ad-input" :disabled="period !== 'custom'">
                    </div>
                    <div>
                        <label class="ad-label">Designer</label>
                        <select name="designer" class="ad-input">
                            <option value="">All Designers</option>
                            @foreach($designers as $d)
                                <option value="{{ $d->id }}" {{ (string) $designerId === (string) $d->id ? 'selected' : '' }}>{{ $d->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="ad-label">Category</label>
                        <select name="category" class="ad-input">
                            <option value="">All Categories</option>
                            @foreach($categories as $c)
                                <option value="{{ $c }}" {{ $category === $c ? 'selected' : '' }}>{{ $c }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="ad-label">Payment</label>
                        <select name="payment" class="ad-input">
                            <option value="">All Methods</option>
                            @foreach($paymentMethods as $pm)
                                <option value="{{ $pm }}" {{ $paymentMethod === $pm ? 'selected' : '' }}>{{ strtoupper($pm) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="ad-apply w-full"><i class="fas fa-check"></i> Apply</button>
                    </div>
                </form>

                <!-- Active filter chips -->
                @if($activeFilters->isNotEmpty())
                    <div class="flex flex-wrap items-center gap-2 mt-4">
                        <span class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Active:</span>
                        @foreach($activeFilters as $f)
                            <span class="ad-active-chip"><i class="fas fa-check-circle"></i> {{ $f }}</span>
                        @endforeach
                    </div>
                @endif
            </section>

            <!-- ===== KPI CARDS ===== -->
            <section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">
                <!-- Revenue -->
                <div class="ad-card ad-kpi ad-reveal p-6" style="--accent: linear-gradient(135deg,#d4af37,#b5952f); --shadow: rgba(212,175,55,.9);">
                    <span class="ad-kpi-bg"></span>
                    <div class="flex items-start justify-between mb-5">
                        <div class="ad-icon"><i class="fas fa-coins"></i></div>
                        <span class="ad-chip bg-emerald-50 text-emerald-600"><i class="fas fa-arrow-trend-up mr-1"></i>Revenue</span>
                    </div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Revenue</p>
                    <h3 class="text-2xl font-bold text-gray-900 mt-1">
                        Rs. <span data-count="{{ $totalRevenue }}" data-decimals="2">0.00</span>
                    </h3>
                    <div class="mt-5">
                        <div class="flex justify-between text-[11px] text-gray-400 mb-1.5"><span>Completion rate</span><span class="font-bold text-gray-600">{{ $completedPercent }}%</span></div>
                        <div class="ad-progress"><span data-width="{{ $completedPercent }}"></span></div>
                    </div>
                </div>

                <!-- Orders -->
                <div class="ad-card ad-kpi ad-reveal p-6" style="--accent: linear-gradient(135deg,#3b82f6,#1d4ed8); --shadow: rgba(59,130,246,.9);">
                    <span class="ad-kpi-bg"></span>
                    <div class="flex items-start justify-between mb-5">
                        <div class="ad-icon"><i class="fas fa-shopping-bag"></i></div>
                        <span class="ad-chip bg-amber-50 text-amber-600"><i class="fas fa-clock mr-1"></i>{{ $pendingOrders }} Pending</span>
                    </div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Orders</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-1"><span data-count="{{ $totalOrders }}">0</span></h3>
                    <div class="mt-5">
                        @php $pendingPercent = $totalOrders > 0 ? round(($pendingOrders / $totalOrders) * 100) : 0; @endphp
                        <div class="flex justify-between text-[11px] text-gray-400 mb-1.5"><span>Pending share</span><span class="font-bold text-gray-600">{{ $pendingPercent }}%</span></div>
                        <div class="ad-progress"><span data-width="{{ $pendingPercent }}"></span></div>
                    </div>
                </div>

                <!-- Users -->
                <div class="ad-card ad-kpi ad-reveal p-6" style="--accent: linear-gradient(135deg,#a855f7,#7e22ce); --shadow: rgba(168,85,247,.9);">
                    <span class="ad-kpi-bg"></span>
                    <div class="flex items-start justify-between mb-5">
                        <div class="ad-icon"><i class="fas fa-users"></i></div>
                        <span class="ad-chip bg-purple-50 text-purple-600"><i class="fas fa-palette mr-1"></i>{{ $totalDesigners }} Designers</span>
                    </div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Users</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-1"><span data-count="{{ $totalUsers }}">0</span></h3>
                    <div class="mt-5">
                        <div class="flex justify-between text-[11px] text-gray-400 mb-1.5"><span>{{ $totalCustomers }} Customers · <span class="text-purple-600 font-semibold">+{{ $newUsers }} new</span></span><span class="font-bold text-gray-600">{{ $customerPercent }}%</span></div>
                        <div class="ad-progress"><span data-width="{{ $customerPercent }}"></span></div>
                    </div>
                </div>

                <!-- Products -->
                <div class="ad-card ad-kpi ad-reveal p-6" style="--accent: linear-gradient(135deg,#f43f5e,#be123c); --shadow: rgba(244,63,94,.9);">
                    <span class="ad-kpi-bg"></span>
                    <div class="flex items-start justify-between mb-5">
                        <div class="ad-icon"><i class="fas fa-tshirt"></i></div>
                        <span class="ad-chip bg-rose-50 text-rose-600"><i class="fas fa-triangle-exclamation mr-1"></i>{{ $lowStockCount }} Low Stock</span>
                    </div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Products</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-1"><span data-count="{{ $totalProducts }}">0</span></h3>
                    <div class="mt-5">
                        <div class="flex justify-between text-[11px] text-gray-400 mb-1.5"><span>Stock health</span><span class="font-bold text-gray-600">{{ $stockHealth }}%</span></div>
                        <div class="ad-progress"><span data-width="{{ $stockHealth }}"></span></div>
                    </div>
                </div>
            </section>

            <!-- ===== MINI STATS ===== -->
            <section class="grid grid-cols-2 lg:grid-cols-4 gap-5">
                <div class="ad-card ad-reveal p-5 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg"><i class="fas fa-user"></i></div>
                    <div>
                        <div class="text-xl font-bold text-gray-900" data-count="{{ $totalCustomers }}">0</div>
                        <div class="text-[11px] uppercase tracking-wider text-gray-400 font-semibold">Customers</div>
                    </div>
                </div>
                <div class="ad-card ad-reveal p-5 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-lg"><i class="fas fa-palette"></i></div>
                    <div>
                        <div class="text-xl font-bold text-gray-900" data-count="{{ $totalDesigners }}">0</div>
                        <div class="text-[11px] uppercase tracking-wider text-gray-400 font-semibold">Designers</div>
                    </div>
                </div>
                <div class="ad-card ad-reveal p-5 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-lg"><i class="fas fa-headset"></i></div>
                    <div>
                        <div class="text-xl font-bold text-gray-900" data-count="{{ $pendingInquiries }}">0</div>
                        <div class="text-[11px] uppercase tracking-wider text-gray-400 font-semibold">Open Inquiries</div>
                    </div>
                </div>
                <div class="ad-card ad-reveal p-5 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center text-lg"><i class="fas fa-star"></i></div>
                    <div class="flex-1">
                        <div class="flex items-baseline gap-1">
                            <span class="text-xl font-bold text-gray-900" data-count="{{ $averageRating }}" data-decimals="1">0.0</span>
                            <span class="text-xs text-gray-400">/ 5</span>
                        </div>
                        <div class="text-[11px] uppercase tracking-wider text-gray-400 font-semibold">Avg. Rating</div>
                        <div class="ad-progress mt-1.5" style="--accent: linear-gradient(90deg,#fbbf24,#f59e0b);"><span data-width="{{ $ratingPercent }}"></span></div>
                    </div>
                </div>
            </section>

            <!-- ===== CHARTS ===== -->
            <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="ad-card ad-reveal lg:col-span-2 p-6">
                    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
                        <div>
                            <h3 class="ad-title text-lg">Revenue & Orders Trend</h3>
                            <p class="text-xs text-gray-400">{{ $chartSubtitle }} · {{ $periodLabels[$period] ?? 'All Time' }}{{ $period === 'all' ? ' (last 6 months shown)' : '' }} · excluding cancelled orders</p>
                        </div>
                        <div class="flex items-center gap-4 text-xs text-gray-500">
                            <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full" style="background:#d4af37"></span>Revenue</span>
                            <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full" style="background:#1f2937"></span>Orders</span>
                            <a href="{{ route('admin.reports.sales') }}" class="ad-link">Full Report <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                    <div class="h-80"><canvas id="revenueChart"></canvas></div>
                </div>

                <div class="ad-card ad-reveal p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="ad-title text-lg">Order Status</h3>
                            <p class="text-xs text-gray-400">Distribution of all orders</p>
                        </div>
                        <a href="{{ route('admin.orders') }}" class="ad-link">View <i class="fas fa-arrow-right"></i></a>
                    </div>
                    <div class="relative h-52">
                        <canvas id="statusChart"></canvas>
                        <div class="ad-donut-center">
                            <span class="text-3xl font-bold text-gray-900" data-count="{{ $totalOrders }}">0</span>
                            <span class="text-[10px] uppercase tracking-widest text-gray-400 font-semibold">Orders</span>
                        </div>
                    </div>
                    <div class="mt-5 space-y-3">
                        @foreach($statusMeta as $key => $meta)
                            @php
                                $count = (int) ($statusCounts[$key] ?? 0);
                                $pct = round(($count / $statusTotal) * 100);
                            @endphp
                            <div>
                                <div class="flex items-center justify-between text-xs mb-1">
                                    <span class="flex items-center gap-2 text-gray-600 font-medium">
                                        <i class="fas {{ $meta['icon'] }}" style="color: {{ $meta['color'] }}"></i>{{ $meta['label'] }}
                                    </span>
                                    <span class="font-bold text-gray-800">{{ $count }} <span class="text-gray-400 font-normal">({{ $pct }}%)</span></span>
                                </div>
                                <div class="ad-progress" style="height:5px; --accent: {{ $meta['color'] }};"><span data-width="{{ $pct }}"></span></div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>

            <!-- ===== QUICK ACTIONS ===== -->
            <section class="ad-reveal">
                <h3 class="ad-title text-lg mb-4">Quick Actions</h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                    <a href="{{ route('admin.users') }}" class="ad-action" style="--accent: linear-gradient(135deg,#ef4444,#b91c1c);"><i class="fas fa-users-cog"></i><span>Users</span></a>
                    <a href="{{ route('admin.orders') }}" class="ad-action" style="--accent: linear-gradient(135deg,#d4af37,#b5952f);"><i class="fas fa-box-open"></i><span>Orders</span></a>
                    <a href="{{ route('admin.inquiries') }}" class="ad-action" style="--accent: linear-gradient(135deg,#f43f5e,#be123c);"><i class="fas fa-headset"></i><span>Inquiries</span></a>
                    <a href="{{ route('admin.reports.designers') }}" class="ad-action" style="--accent: linear-gradient(135deg,#a855f7,#7e22ce);"><i class="fas fa-award"></i><span>Designers</span></a>
                    <a href="{{ route('admin.reports.customers') }}" class="ad-action" style="--accent: linear-gradient(135deg,#3b82f6,#1d4ed8);"><i class="fas fa-user-friends"></i><span>Customers</span></a>
                    <a href="{{ route('admin.reports.reviews') }}" class="ad-action" style="--accent: linear-gradient(135deg,#f59e0b,#d97706);"><i class="fas fa-star"></i><span>Reviews</span></a>
                </div>
            </section>

            <!-- ===== RECENT ORDERS & USERS ===== -->
            <section class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="ad-card ad-reveal">
                    <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-amber-50 text-[#b5952f] flex items-center justify-center"><i class="fas fa-receipt"></i></div>
                            <div>
                                <h3 class="ad-title">Recent Orders</h3>
                                <p class="text-[11px] text-gray-400">Latest 5 orders placed</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.orders') }}" class="ad-link">All Orders <i class="fas fa-arrow-right"></i></a>
                    </div>
                    <div class="divide-y divide-gray-50">
                        @forelse($recentOrders as $order)
                            @php $m = $statusMeta[$order->status] ?? $statusMeta['pending']; @endphp
                            <div class="ad-row px-6 py-4 flex items-center justify-between gap-4">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-11 h-11 rounded-xl bg-gray-900 text-[#d4af37] text-xs font-bold flex items-center justify-center shrink-0">#{{ $order->id }}</div>
                                    <div class="min-w-0">
                                        <div class="font-semibold text-gray-900 text-sm truncate">{{ $order->user->name ?? 'Deleted User' }}</div>
                                        <div class="text-[11px] text-gray-400">{{ $order->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 shrink-0">
                                    <div class="text-right">
                                        <div class="font-bold text-sm text-gray-900">Rs. {{ number_format($order->total_amount, 2) }}</div>
                                        <span class="ad-badge" style="background: {{ $m['color'] }}1a; color: {{ $m['color'] }};">
                                            <i class="fas {{ $m['icon'] }}"></i>{{ $m['label'] }}
                                        </span>
                                    </div>
                                    <a href="{{ route('admin.orders.show', $order->id) }}" title="View Order"
                                        class="w-9 h-9 rounded-xl bg-gray-100 text-gray-600 flex items-center justify-center hover:bg-[#d4af37] hover:text-white transition">
                                        <i class="fas fa-eye text-xs"></i>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="p-10 text-center text-gray-400 text-sm"><i class="fas fa-inbox text-3xl mb-2 block text-gray-300"></i>No orders yet.</div>
                        @endforelse
                    </div>
                </div>

                <div class="ad-card ad-reveal">
                    <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center"><i class="fas fa-user-plus"></i></div>
                            <div>
                                <h3 class="ad-title">New Members</h3>
                                <p class="text-[11px] text-gray-400">Recently registered users</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.users') }}" class="ad-link">All Users <i class="fas fa-arrow-right"></i></a>
                    </div>
                    <div class="divide-y divide-gray-50">
                        @forelse($recentUsers as $user)
                            @php
                                $roleColors = ['admin' => '#ef4444', 'designer' => '#a855f7', 'customer' => '#3b82f6'];
                                $rc = $roleColors[$user->role] ?? '#6b7280';
                            @endphp
                            <div class="ad-row px-6 py-4 flex items-center justify-between gap-4">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="ad-avatar shrink-0">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                                    <div class="min-w-0">
                                        <div class="font-semibold text-gray-900 text-sm truncate">{{ $user->name }}</div>
                                        <div class="text-[11px] text-gray-400 truncate">{{ $user->email }}</div>
                                    </div>
                                </div>
                                <div class="text-right shrink-0">
                                    <span class="ad-badge" style="background: {{ $rc }}1a; color: {{ $rc }};">{{ ucfirst($user->role) }}</span>
                                    <div class="text-[11px] text-gray-400 mt-1">{{ $user->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        @empty
                            <div class="p-10 text-center text-gray-400 text-sm">No users found.</div>
                        @endforelse
                    </div>
                </div>
            </section>

            <!-- ===== LOW STOCK ===== -->
            <section class="ad-card ad-reveal">
                <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-500 flex items-center justify-center"><i class="fas fa-triangle-exclamation"></i></div>
                        <div>
                            <h3 class="ad-title">Low Stock Alerts</h3>
                            <p class="text-[11px] text-gray-400">Products with 5 or fewer items remaining</p>
                        </div>
                    </div>
                    <span class="ad-chip bg-rose-50 text-rose-600">{{ $lowStockCount }} items</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="text-[11px] uppercase tracking-wider text-gray-400 bg-gray-50/60">
                                <th class="text-left px-6 py-3 font-semibold">Product</th>
                                <th class="text-left px-6 py-3 font-semibold">Designer</th>
                                <th class="text-left px-6 py-3 font-semibold">Category</th>
                                <th class="text-right px-6 py-3 font-semibold">Price</th>
                                <th class="text-right px-6 py-3 font-semibold">Stock Level</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-sm">
                            @forelse($lowStockProducts as $product)
                                @php
                                    $qty = (int) $product->stock_quantity;
                                    $barColor = $qty == 0 ? '#ef4444' : ($qty <= 2 ? '#f97316' : '#f59e0b');
                                    $barWidth = min(100, ($qty / 5) * 100);
                                @endphp
                                <tr class="ad-row">
                                    <td class="px-6 py-4 font-semibold text-gray-900">{{ $product->name }}</td>
                                    <td class="px-6 py-4 text-gray-600">{{ $product->user->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4"><span class="ad-badge bg-gray-100 text-gray-600">{{ $product->category ?? 'N/A' }}</span></td>
                                    <td class="px-6 py-4 text-right font-semibold text-gray-800">Rs. {{ number_format($product->price, 2) }}</td>
                                    <td class="px-6 py-4 text-right whitespace-nowrap">
                                        <span class="ad-stock-bar mr-2"><span style="width: {{ $barWidth }}%; background: {{ $barColor }};"></span></span>
                                        <span class="font-bold text-xs" style="color: {{ $barColor }};">{{ $qty == 0 ? 'Out of stock' : $qty . ' left' }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-400">
                                        <i class="fas fa-circle-check text-3xl text-emerald-400 mb-2 block"></i>
                                        All products are well stocked.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // ===== Live clock =====
            const clock = document.getElementById('adClock');
            if (clock) {
                setInterval(() => {
                    clock.textContent = new Date().toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
                }, 1000);
            }

            // ===== Count-up numbers =====
            const animateCount = (el) => {
                const target = parseFloat(el.dataset.count) || 0;
                const decimals = parseInt(el.dataset.decimals || '0', 10);
                const duration = 1600;
                const start = performance.now();
                const fmt = (v) => v.toLocaleString('en-US', { minimumFractionDigits: decimals, maximumFractionDigits: decimals });
                const step = (now) => {
                    const p = Math.min((now - start) / duration, 1);
                    const eased = 1 - Math.pow(1 - p, 3);
                    el.textContent = fmt(target * eased);
                    if (p < 1) requestAnimationFrame(step);
                };
                requestAnimationFrame(step);
            };

            // ===== Reveal on scroll (staggered) =====
            const revealEls = document.querySelectorAll('.ad-reveal');
            const io = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (!entry.isIntersecting) return;
                    const el = entry.target;
                    el.classList.add('is-in');
                    el.querySelectorAll('[data-count]').forEach((c) => { if (!c.dataset.done) { c.dataset.done = 1; animateCount(c); } });
                    el.querySelectorAll('[data-width]').forEach((b) => { setTimeout(() => b.style.width = b.dataset.width + '%', 250); });
                    io.unobserve(el);
                });
            }, { threshold: 0.15 });

            revealEls.forEach((el, i) => {
                el.style.transitionDelay = (Math.min(i, 8) * 80) + 'ms';
                io.observe(el);
            });

            if (typeof Chart === 'undefined') return;

            Chart.defaults.font.family = "'Poppins', sans-serif";
            Chart.defaults.color = '#9ca3af';

            // ===== Revenue & Orders chart =====
            const revCanvas = document.getElementById('revenueChart');
            if (revCanvas) {
                const ctx = revCanvas.getContext('2d');
                const gold = ctx.createLinearGradient(0, 0, 0, 320);
                gold.addColorStop(0, 'rgba(212, 175, 55, 0.45)');
                gold.addColorStop(1, 'rgba(212, 175, 55, 0.02)');

                new Chart(ctx, {
                    data: {
                        labels: @json($chartLabels),
                        datasets: [
                            {
                                type: 'line',
                                label: 'Revenue (Rs.)',
                                data: @json($chartRevenues),
                                borderColor: '#d4af37',
                                backgroundColor: gold,
                                fill: true,
                                tension: 0.42,
                                borderWidth: 3,
                                pointRadius: 5,
                                pointHoverRadius: 8,
                                pointBackgroundColor: '#fff',
                                pointBorderColor: '#d4af37',
                                pointBorderWidth: 3,
                                yAxisID: 'y',
                            },
                            {
                                type: 'bar',
                                label: 'Orders',
                                data: @json($chartOrders),
                                backgroundColor: 'rgba(31, 41, 55, 0.85)',
                                hoverBackgroundColor: '#111827',
                                borderRadius: 10,
                                barPercentage: 0.45,
                                yAxisID: 'y1',
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: { mode: 'index', intersect: false },
                        animation: { duration: 1800, easing: 'easeOutQuart' },
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#111827',
                                titleColor: '#f5d97a',
                                padding: 12,
                                cornerRadius: 12,
                                callbacks: {
                                    label: (c) => c.dataset.yAxisID === 'y'
                                        ? ' Revenue: Rs. ' + Number(c.raw).toLocaleString('en-US', { minimumFractionDigits: 2 })
                                        : ' Orders: ' + c.raw
                                }
                            }
                        },
                        scales: {
                            x: { grid: { display: false } },
                            y: {
                                beginAtZero: true,
                                grid: { color: 'rgba(0,0,0,0.04)' },
                                ticks: { callback: (v) => 'Rs. ' + Number(v).toLocaleString() }
                            },
                            y1: {
                                beginAtZero: true,
                                position: 'right',
                                grid: { display: false },
                                ticks: { precision: 0 }
                            }
                        }
                    }
                });
            }

            // ===== Status doughnut =====
            const statusCanvas = document.getElementById('statusChart');
            if (statusCanvas) {
                new Chart(statusCanvas, {
                    type: 'doughnut',
                    data: {
                        labels: ['Pending', 'Shipped', 'Completed', 'Cancelled'],
                        datasets: [{
                            data: [
                                {{ (int) ($statusCounts['pending'] ?? 0) }},
                                {{ (int) ($statusCounts['shipped'] ?? 0) }},
                                {{ (int) ($statusCounts['completed'] ?? 0) }},
                                {{ (int) ($statusCounts['cancelled'] ?? 0) }}
                            ],
                            backgroundColor: ['#f59e0b', '#3b82f6', '#22c55e', '#ef4444'],
                            borderColor: '#fff',
                            borderWidth: 4,
                            hoverOffset: 10,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '74%',
                        animation: { animateRotate: true, animateScale: true, duration: 1800, easing: 'easeOutQuart' },
                        plugins: {
                            legend: { display: false },
                            tooltip: { backgroundColor: '#111827', padding: 10, cornerRadius: 10 }
                        }
                    }
                });
            }
        });
    </script>
</x-app-layout>
