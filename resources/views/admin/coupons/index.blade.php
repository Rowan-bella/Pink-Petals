<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('messages.coupon_management') }} | Pink Petals Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
    :root {
        --pink-primary: #ec4899;
        --pink-deep: #be185d;
        --pink-hover: #db2777;
        --pink-bg: #fff0f7;
        --pink-soft: #ffe4f0;
        --pink-border: #fbcfe8;
        --text-main: #581c42;
        --sidebar-width: 250px;
    }

    *,
    *::before,
    *::after {
        box-sizing: border-box;
    }

    body {
        background: linear-gradient(135deg, #fff4f9 0%, #ffeaf4 55%, #fff7fb 100%);
        color: var(--text-main);
        font-family: system-ui, -apple-system, "Segoe UI", sans-serif;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    
    .sidebar {
        width: var(--sidebar-width);
        position: fixed;
        top: 14px;
        left: 14px;
        bottom: 14px;
        background: rgba(255, 255, 255, .94);
        border: 1px solid rgba(255, 255, 255, .95);
        border-radius: 30px;
        display: flex;
        flex-direction: column;
        z-index: 100;
        box-shadow: 0 12px 35px rgba(190, 24, 93, .12);
        overflow: hidden;
    }

    .sidebar::after {
        content: "✿";
        position: absolute;
        bottom: -35px;
        left: 8px;
        font-size: 118px;
        line-height: 1;
        color: rgba(236, 72, 153, .12);
        pointer-events: none;
        transform: rotate(-18deg);
    }

    .sidebar-brand {
        padding: 25px 22px 24px;
        font-weight: 800;
        color: var(--pink-deep);
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 1.25rem;
        position: relative;
        z-index: 1;
    }

    .brand-flower {
        width: 42px;
        height: 42px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 15px;
        background: linear-gradient(145deg, #fce7f3, #fbcfe8);
        color: #ec4899;
        font-size: 1.55rem;
        box-shadow: 0 5px 14px rgba(236, 72, 153, .16);
    }

    .brand-subtitle {
        display: block;
        color: #9d5478;
        font-size: .72rem;
        font-weight: 500;
        margin-top: 1px;
        letter-spacing: .02em;
    }

    .sidebar-menu {
        list-style: none;
        padding: 4px 15px 18px;
        margin: 0;
        flex-grow: 1;
        overflow-y: auto;
        position: relative;
        z-index: 1;
    }

    .sidebar-menu li a,
    .sidebar-menu li .logout-button {
        display: flex;
        align-items: center;
        gap: 13px;
        padding: 13px 15px;
        color: #713653;
        text-decoration: none;
        border-radius: 15px;
        margin-bottom: 7px;
        font-weight: 600;
        font-size: .96rem;
        transition: all .22s ease;
        width: 100%;
    }

    .sidebar-menu li a i,
    .sidebar-menu li .logout-button i {
        width: 20px;
        text-align: center;
        font-size: 1.05rem;
        color: #d63384;
    }

    .sidebar-menu li a:hover {
        background: #fff0f7;
        color: var(--pink-deep);
        transform: translateX(3px);
    }

    .sidebar-menu li a:hover i {
        color: var(--pink-deep);
    }

    .sidebar-menu li a.active {
        background: linear-gradient(110deg, #f472b6, #ec4899 60%, #db2777);
        color: #fff;
        box-shadow: 0 8px 18px rgba(236, 72, 153, .25);
    }

    .sidebar-menu li a.active i {
        color: #fff;
    }

    .sidebar-logout {
        border-top: 1px solid #fce1ed;
        margin-top: 10px;
        padding-top: 13px;
    }

    .sidebar-menu li .logout-button {
        border: 0;
        background: transparent;
        color: #e11d48;
        cursor: pointer;
        text-align: left;
    }

    .sidebar-menu li .logout-button:hover {
        background: #fff1f2;
    }

    .sidebar-menu li .logout-button i {
        color: #e11d48;
    }


    .page-wrapper {
        margin-left: calc(var(--sidebar-width) + 14px);
        margin-right: 14px;
        flex: 1;
        display: flex;
        flex-direction: column;
        min-height: calc(100vh - 28px);
    }

    
    .top-navbar {
        background: rgba(255, 255, 255, .94);
        border: 1px solid rgba(255, 255, 255, .95);
        border-radius: 24px;
        margin: 14px 0 0;
        padding: 15px 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        box-shadow: 0 8px 25px rgba(190, 24, 93, .09);
        position: sticky;
        top: 10px;
        z-index: 1050;
        backdrop-filter: blur(12px);
    }

    .top-title-wrap {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .top-title-icon {
        width: 38px;
        height: 38px;
        border-radius: 12px;
        background: linear-gradient(145deg, #fce7f3, #fbcfe8);
        color: var(--pink-deep);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
    }

    .top-navbar h5 {
        color: var(--pink-deep) !important;
        font-size: 1.3rem;
    }

    .flag-icon {
        width: 20px;
        height: 14px;
        object-fit: cover;
        border-radius: 2px;
        box-shadow: 0 0 1px rgba(0, 0, 0, .25);
    }

    .lang-dropdown-btn {
        background: #fff;
        border: 1px solid #f3c5da;
        color: #581c42;
        border-radius: 14px;
        padding: 7px 14px;
        font-weight: 600;
        font-size: 0.88rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 3px 10px rgba(190, 24, 93, .05);
    }

    .lang-dropdown-btn:hover,
    .lang-dropdown-btn:focus {
        background: #fff5fa;
        border-color: var(--pink-primary);
        color: var(--pink-deep);
    }

    .lang-dropdown-menu {
        border: 1px solid #fbcfe8;
        border-radius: 14px;
        padding: 6px;
        box-shadow: 0 10px 24px rgba(190, 24, 93, .12);
        min-width: 150px;
        z-index: 1060;
    }

    .lang-dropdown-menu .dropdown-item {
        border-radius: 10px;
        padding: 8px 12px;
        font-weight: 600;
        font-size: 0.88rem;
        color: #581c42;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .lang-dropdown-menu .dropdown-item:hover,
    .lang-dropdown-menu .dropdown-item.active {
        background: linear-gradient(110deg, #f472b6, #ec4899);
        color: #fff;
    }

    
    .profile-chip {
        display: flex;
        align-items: center;
        gap: 10px;
        background: linear-gradient(135deg, #fff5fa, #ffe8f2);
        border: 1px solid #fbcfe8;
        padding: 6px 13px 6px 7px;
        border-radius: 50px;
        box-shadow: 0 4px 12px rgba(190, 24, 93, .07);
    }

    .profile-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: linear-gradient(145deg, #f472b6, #db2777);
        color: white;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: .95rem;
        object-fit: cover;
        border: 2px solid white;
    }

    .role-badge {
        font-size: .72rem;
        padding: 3px 9px;
        border-radius: 20px;
        font-weight: 700;
        text-transform: capitalize;
        background: #fce7f3;
        color: #be185d;
    }

    
    .main-content {
        padding: 24px 4px;
        flex: 1;
    }

    .form-card,
    .table-card {
        background: rgba(255, 255, 255, .96);
        border: 1px solid rgba(255, 255, 255, .95);
        border-radius: 23px;
        padding: 26px;
        box-shadow: 0 9px 26px rgba(190, 24, 93, .075);
    }

    .table-custom th {
        background: #fff0f7 !important;
        color: var(--pink-deep);
        font-weight: 700;
        border-bottom: 2px solid #fbcfe8;
        padding: 13px 12px;
        font-size: 0.88rem;
    }

    .table-custom td {
        vertical-align: middle;
        padding: 13px 12px;
        color: var(--text-main);
        border-bottom: 1px solid #fce7f3;
    }

    .form-control,
    .form-select {
        border-radius: 12px;
        padding: 11px 14px;
        border-color: #f3c5da;
        color: var(--text-main);
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--pink-primary);
        box-shadow: 0 0 0 0.25rem rgba(236, 72, 153, .18);
    }

    .btn-pink {
        background: linear-gradient(110deg, #f472b6, #ec4899 60%, #db2777);
        color: white;
        border: 0;
        border-radius: 12px;
        font-weight: 600;
        box-shadow: 0 6px 15px rgba(236, 72, 153, .22);
    }

    .btn-pink:hover {
        background: var(--pink-deep);
        color: white;
    }


    .admin-footer {
        position: relative;
        overflow: hidden;
        background: rgba(255, 255, 255, .94);
        border: 1px solid rgba(255, 255, 255, .95);
        border-radius: 22px;
        padding: 17px 23px;
        margin: 0 0 14px;
        color: #814361;
        font-size: .88rem;
        box-shadow: 0 8px 22px rgba(190, 24, 93, .08);
    }

    .footer-brand {
        color: var(--pink-deep);
        font-weight: 700;
    }

    .footer-links {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 9px;
    }

    .footer-links a {
        color: #713653;
        text-decoration: none;
        font-weight: 600;
        transition: color .2s ease;
    }

    .footer-links a:hover {
        color: #ec4899;
    }

    .footer-heart {
        color: #ec4899;
        font-size: 1.1rem;
        margin-left: 3px;
    }


    @media (max-width: 991.98px) {
        :root {
            --sidebar-width: 220px;
        }

        .sidebar {
            left: 9px;
            top: 9px;
            bottom: 9px;
        }

        .page-wrapper {
            margin-left: calc(var(--sidebar-width) + 9px);
            margin-right: 9px;
        }

        .main-content {
            padding: 18px 2px;
        }
    }

    @media (max-width: 767.98px) {
        .sidebar {
            position: relative;
            inset: auto;
            width: auto;
            margin: 10px;
            min-height: auto;
            border-radius: 22px;
        }

        .sidebar-brand {
            padding: 14px 18px;
        }

        .sidebar-menu {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 3px 7px;
            padding: 0 12px 12px;
        }

        .sidebar-menu li a,
        .sidebar-menu li .logout-button {
            font-size: .84rem;
            padding: 10px 9px;
            gap: 8px;
        }

        .sidebar-logout {
            margin-top: 0;
            padding-top: 0;
            border-top: 0;
        }

        .page-wrapper {
            margin: 0 10px;
            min-height: auto;
        }

        .top-navbar {
            margin-top: 0;
            padding: 13px 15px;
            border-radius: 18px;
        }

        .top-navbar h5 {
            font-size: 1.1rem;
        }

        .main-content {
            padding: 16px 0;
        }

        .form-card,
        .table-card {
            padding: 18px;
            border-radius: 18px;
        }

        .admin-footer {
            border-radius: 18px;
            padding: 15px;
        }
    }

    @media (max-width: 420px) {
        .top-navbar {
            align-items: flex-start;
            flex-direction: column;
        }

        .top-navbar>.d-flex {
            width: 100%;
            justify-content: space-between;
            gap: 7px !important;
        }

        .profile-chip {
            padding-right: 9px;
        }

        .footer-links {
            gap: 7px;
        }
    }
    </style>
</head>

<body>


    <div class="sidebar">

        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
            <span class="brand-flower">✿</span>
            <span>
                Pink Petals
                <span class="brand-subtitle">Bloom in Business</span>
            </span>
        </a>

        <ul class="sidebar-menu">

            @if(strtolower(auth()->user()->role) === 'admin' || strtolower(auth()->user()->role) === 'manager')
            <li>
                <a href="{{ route('admin.dashboard') }}"
                    class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-house"></i>
                    {{ __('messages.dashboard') }}
                </a>
            </li>
            @endif

            @if(strtolower(auth()->user()->role) === 'admin' || strtolower(auth()->user()->role) === 'manager')
            <li>
                <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-box"></i>
                    {{ __('messages.products') }}
                </a>
            </li>
            @endif

            <li>
                <a href="{{ route('admin.categories') }}"
                    class="{{ request()->routeIs('admin.categories') || request()->routeIs('admin.category.products') ? 'active' : '' }}">
                    <i class="fa-solid fa-list"></i>
                    {{ __('messages.categories') }}
                </a>
            </li>

            @if(strtolower(auth()->user()->role) === 'admin' || strtolower(auth()->user()->role) === 'manager' ||
            strtolower(auth()->user()->role) === 'staff')
            <li>
                <a href="{{ route('admin.orders') }}" class="{{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
                    <i class="fa-solid fa-cart-shopping"></i>
                    {{ __('messages.orders') }}
                </a>
            </li>
            @endif

            @if(auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->role === 'manager'))
            <li>
                <a href="{{ route('admin.users.index') }}"
                    class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-users"></i>
                    {{ __('messages.users') }}
                </a>
            </li>
            @endif

            @if(auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->role === 'manager'))
            <li>
                <a href="{{ route('admin.coupons.index') }}"
                    class="{{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-ticket"></i>
                    {{ __('messages.coupons') }}
                </a>
            </li>
            @endif

            @if(strtolower(auth()->user()->role) === 'admin' || strtolower(auth()->user()->role) === 'manager')
            <li>
                <a href="{{ route('admin.reports.sales') }}"
                    class="{{ request()->routeIs('admin.reports.sales') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-line"></i>
                    {{ __('messages.sales_report') }}
                </a>
            </li>
            @endif

            @if(strtolower(auth()->user()->role) === 'admin' || strtolower(auth()->user()->role) === 'manager')
            <li>
                <a href="{{ route('admin.reports.inventory') }}"
                    class="{{ request()->routeIs('admin.reports.inventory') ? 'active' : '' }}">
                    <i class="fa-solid fa-boxes-stacked"></i>
                    {{ __('messages.inventory_report') }}
                </a>
            </li>
            @endif

            @if(strtolower(auth()->user()->role) === 'admin' || strtolower(auth()->user()->role) === 'manager')
            <li>
                <a href="{{ route('admin.reports.activity') }}"
                    class="{{ request()->routeIs('admin.reports.activity') ? 'active' : '' }}">
                    <i class="fa-solid fa-users-viewfinder"></i>
                    {{ __('messages.customer_activity') }}
                </a>
            </li>
            @endif

            <!-- LOGOUT -->
            <li class="sidebar-logout">
                <form action="{{ route('logout') }}" method="POST" class="d-inline w-100">
                    @csrf
                    <button type="submit" class="logout-button">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        {{ __('messages.logout') }}
                    </button>
                </form>
            </li>

        </ul>
    </div>

    
    <div class="page-wrapper">


        <header class="top-navbar">

            <div class="top-title-wrap">
                <span class="top-title-icon">
                    <i class="fa-solid fa-ticket"></i>
                </span>
                <h5 class="fw-bold mb-0">
                    {{ __('messages.coupon_management') }}
                </h5>
            </div>

            <div class="d-flex align-items-center gap-3">

                
                <div class="dropdown">
                    <button class="btn lang-dropdown-btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        @if(app()->getLocale() === 'my')
                        <img src="https://flagcdn.com/mm.svg" alt="မြန်မာ" class="flag-icon">
                        <span>မြန်မာ</span>
                        @else
                        <img src="https://flagcdn.com/gb.svg" alt="English" class="flag-icon">
                        <span>English</span>
                        @endif
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end lang-dropdown-menu">
                        <li>
                            <a class="dropdown-item {{ app()->getLocale() === 'en' ? 'active' : '' }}"
                                href="{{ route('lang.switch', 'en') }}">
                                <img src="https://flagcdn.com/gb.svg" alt="English" class="flag-icon">
                                <span>English</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ app()->getLocale() === 'my' ? 'active' : '' }}"
                                href="{{ route('lang.switch', 'my') }}">
                                <img src="https://flagcdn.com/mm.svg" alt="မြန်မာ" class="flag-icon">
                                <span>မြန်မာ</span>
                            </a>
                        </li>
                    </ul>
                </div>

                
                @php
                $currentUser = auth()->user();
                $currentRole = strtolower($currentUser->role ?? 'user');
                @endphp

                <div class="profile-chip">

                    @if(!empty($currentUser->avatar))

                    <img src="{{ asset('storage/' . $currentUser->avatar) }}" alt="{{ $currentUser->name }}"
                        class="profile-avatar">

                    @elseif($currentRole === 'admin')

                    <span class="profile-avatar">
                        <i class="fa-solid fa-user-shield"></i>
                    </span>

                    @elseif($currentRole === 'manager')

                    <span class="profile-avatar">
                        <i class="fa-solid fa-user-tie"></i>
                    </span>

                    @elseif($currentRole === 'staff')

                    <span class="profile-avatar">
                        <i class="fa-solid fa-id-badge"></i>
                    </span>

                    @else

                    <span class="profile-avatar">
                        <i class="fa-solid fa-user"></i>
                    </span>

                    @endif

                    <div class="d-flex flex-column lh-1">

                        <span class="fw-semibold small text-dark mb-1">
                            {{ $currentUser->name ?? '' }}
                        </span>

                        <span class="role-badge
                            @if($currentRole === 'admin') bg-danger-subtle text-danger
                            @elseif($currentRole === 'manager') bg-warning-subtle text-dark
                            @elseif($currentRole === 'staff') bg-info-subtle text-dark
                            @else bg-secondary-subtle text-secondary
                            @endif">

                            {{ __('messages.role_' . $currentRole) }}

                        </span>

                    </div>
                </div>

            </div>
        </header>

    
        <div class="main-content">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                <h3 class="fw-bold mb-0" style="color: var(--pink-deep);">
                    <i class="fa-solid fa-ticket me-2"></i> {{ __('messages.coupon_management') }}
                </h3>
            </div>

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 small" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="form-card">
                        <h5 class="fw-bold mb-3" style="color: var(--pink-deep);">{{ __('messages.create_new_coupon') }}</h5>
                        <form action="{{ route('admin.coupons.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label small fw-semibold text-muted">{{ __('messages.coupon_code') }}</label>
                                <input type="text" name="code"
                                    class="form-control @error('code') is-invalid @enderror"
                                    placeholder="{{ __('messages.coupon_code_placeholder') }}" required
                                    value="{{ old('code') }}">
                                @error('code')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-semibold text-muted">{{ __('messages.discount_type') }}</label>
                                <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                                    <option value="percent" {{ old('type') == 'percent' ? 'selected' : '' }}>{{ __('messages.percentage') }} (%)</option>
                                    <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>{{ __('messages.fixed_amount') }}</option>
                                </select>
                                @error('type')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-semibold text-muted">{{ __('messages.value') }}</label>
                                <input type="number" step="1" name="value"
                                    class="form-control @error('value') is-invalid @enderror"
                                    placeholder="{{ __('messages.coupon_value_placeholder') }}" value="{{ old('value') }}"
                                    required>
                                @error('value')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-semibold text-muted">{{ __('messages.minimum_spend') }}</label>
                                <input type="number" step="1" name="min_spend"
                                    class="form-control @error('min_spend') is-invalid @enderror"
                                    placeholder="{{ __('messages.min_spend_placeholder') }}"
                                    value="{{ old('min_spend') }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-semibold text-muted">{{ __('messages.expires_at') }}</label>
                                <input type="datetime-local" name="expires_at"
                                    class="form-control @error('expires_at') is-invalid @enderror"
                                    value="{{ old('expires_at') }}">
                            </div>

                            <button type="submit"
                                class="btn btn-pink w-100 rounded-pill py-2 fw-semibold shadow-sm">{{ __('messages.save_coupon') }}</button>
                        </form>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="table-card">
                        <h5 class="fw-bold mb-3" style="color: var(--pink-deep);">{{ __('messages.active_coupons_list') }}</h5>
                        <div class="table-responsive">
                            <table class="table table-custom align-middle">
                                <thead>
                                    <tr class="small">
                                        <th>{{ __('messages.code') }}</th>
                                        <th>{{ __('messages.type_and_value') }}</th>
                                        <th>{{ __('messages.min_spend') }}</th>
                                        <th>{{ __('messages.expires') }}</th>
                                        <th class="text-end">{{ __('messages.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($coupons as $coupon)
                                    <tr class="small">
                                        <td class="fw-bold">{{ $coupon->code }}</td>
                                        <td>
                                            @if($coupon->type == 'percent')
                                            <span class="badge bg-info-subtle text-dark px-2 py-1">{{ $coupon->value }}%</span>
                                            @else
                                            <span class="badge bg-success-subtle text-success px-2 py-1">{{ number_format($coupon->value) }} {{ __('messages.mmk') }}</span>
                                            @endif
                                        </td>
                                        <td>{{ number_format($coupon->min_spend) }} {{ __('messages.mmk') }}</td>
                                        <td>{{ $coupon->expires_at ? \Carbon\Carbon::parse($coupon->expires_at)->format('Y-m-d H:i') : __('messages.no_expiry') }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('admin.coupons.edit', $coupon->id) }}"
                                                class="btn btn-sm btn-outline-primary rounded-3 px-2 py-1 me-1"
                                                title="{{ __('messages.edit') }}">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('{{ __('messages.confirm_delete_coupon') }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-3 px-2 py-1"
                                                    title="{{ __('messages.delete') }}">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-5">{{ __('messages.no_coupons_available') }}</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <footer class="admin-footer d-flex flex-wrap justify-content-between align-items-center gap-3">

            <span class="footer-brand">
                ✿ &nbsp;© {{ date('Y') }} Pink Petals.
                {{ __('messages.all_rights_reserved') }}
            </span>

            <nav class="footer-links" aria-label="Footer navigation">

                <a href="#">{{ __('messages.privacy_policy') }}</a>

                <span class="text-muted">|</span>

                <a href="#">{{ __('messages.terms_of_service') }}</a>

                <span class="text-muted">|</span>

                <a href="#">{{ __('messages.contact_us') }}</a>

                <i class="fa-solid fa-heart footer-heart" aria-hidden="true"></i>

            </nav>

        </footer>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.querySelector('.lang-dropdown-btn');
        if (toggleBtn && typeof bootstrap === 'undefined') {
            toggleBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                const menu = this.nextElementSibling;
                if (menu) menu.classList.toggle('show');
            });
            document.addEventListener('click', function() {
                document.querySelectorAll('.lang-dropdown-menu.show').forEach(function(m) {
                    m.classList.remove('show');
                });
            });
        }
    });
    </script>
</body>

</html>