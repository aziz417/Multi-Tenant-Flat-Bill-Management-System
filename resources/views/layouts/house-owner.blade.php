@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
            <div class="position-sticky pt-3">
                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>House Owner Panel</span>
                </h6>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('house-owner.dashboard') ? 'active' : '' }}" href="{{ route('house-owner.dashboard') }}">
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('house-owner.buildings.*') ? 'active' : '' }}" href="{{ route('house-owner.buildings.index') }}">
                            Buildings
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('house-owner.flats.*') ? 'active' : '' }}" href="{{ route('house-owner.flats.index') }}">
                            Flats
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('house-owner.bill-categories.*') ? 'active' : '' }}" href="{{ route('house-owner.bill-categories.index') }}">
                            Bill Categories
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('house-owner.bills.*') ? 'active' : '' }}" href="{{ route('house-owner.bills.index') }}">
                            Bills
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('house-owner-content')
        </main>
    </div>
</div>
@endsection

@push('styles')
<style>
    .sidebar {
        position: fixed;
        top: 56px;
        bottom: 0;
        left: 0;
        z-index: 100;
        padding: 48px 0 0;
        box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
    }
    .sidebar .nav-link {
        font-weight: 500;
        color: #333;
    }
    .sidebar .nav-link.active {
        color: #0d6efd;
    }
</style>
@endpush