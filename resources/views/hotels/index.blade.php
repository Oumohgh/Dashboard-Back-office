@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary: #D4AF37;
        --primary-dark: #1a2332;
        --secondary: #2c3e50;
        --light: #F8F7F4;
        --dark: #1a1a1a;
        --text-primary: #2C2C2C;
        --text-secondary: #666666;
        --border: #E8E6E1;
        --border-light: #F0EFEC;
        --bg-neutral: #FAFAF8;
    }

    .hero-section {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--secondary) 100%);
        color: white;
        padding: 80px 20px;
        text-align: center;
        margin-bottom: 60px;
    }

    .hero-section h1 {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 15px;
        letter-spacing: -1px;
    }

    .hero-section p {
        font-size: 1.25rem;
        color: rgba(255, 255, 255, 0.85);
        margin-bottom: 40px;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    .search-form {
        background: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        max-width: 600px;
        margin: 0 auto;
    }

    .search-form .form-group {
        margin-bottom: 15px;
    }

    .search-form .form-control {
        border: 1px solid var(--border-light);
        padding: 12px 15px;
        border-radius: 8px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .search-form .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
    }

    .search-form .btn-search {
        background: var(--primary);
        color: var(--dark);
        border: none;
        padding: 12px 40px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        width: 100%;
    }

    .search-form .btn-search:hover {
        background: #F5C842;
        box-shadow: 0 4px 12px rgba(212, 175, 55, 0.3);
    }

    .hotels-container {
        padding: 40px 20px;
        background: var(--light);
        min-height: 60vh;
    }

    .hotels-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 30px;
        max-width: 1400px;
        margin: 0 auto;
    }

    .hotel-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid var(--border-light);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
    }

    .hotel-card:hover {
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.15);
        transform: translateY(-5px);
    }

    .hotel-image {
        width: 100%;
        height: 220px;
        background: linear-gradient(135deg, var(--secondary) 0%, var(--primary-dark) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgba(255, 255, 255, 0.5);
        font-size: 2rem;
        overflow: hidden;
        position: relative;
    }

    .hotel-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .hotel-card-body {
        padding: 20px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .hotel-name {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 8px;
    }

    .hotel-location {
        display: flex;
        align-items: center;
        color: var(--text-secondary);
        font-size: 0.9rem;
        margin-bottom: 12px;
    }

    .hotel-location i {
        color: var(--primary);
        margin-right: 6px;
    }

    .hotel-description {
        color: var(--text-secondary);
        font-size: 0.9rem;
        line-height: 1.6;
        margin-bottom: 15px;
        flex-grow: 1;
    }

    .hotel-rating {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .stars {
        color: var(--primary);
        font-size: 0.85rem;
        margin-right: 8px;
    }

    .rating-count {
        color: var(--text-secondary);
        font-size: 0.8rem;
    }

    .hotel-footer {
        display: flex;
        gap: 10px;
        margin-top: auto;
    }

    .btn-view {
        background: var(--primary);
        color: var(--dark);
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
        flex: 1;
        text-align: center;
        text-decoration: none;
        display: inline-block;
    }

    .btn-view:hover {
        background: #F5C842;
        box-shadow: 0 3px 8px rgba(212, 175, 55, 0.3);
    }

    .empty-state {
        text-align: center;
        padding: 80px 20px;
        background: var(--light);
    }

    .empty-state-icon {
        font-size: 4rem;
        color: var(--border);
        margin-bottom: 20px;
    }

    .empty-state-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 10px;
    }

    .empty-state-text {
        color: var(--text-secondary);
        font-size: 1rem;
        margin-bottom: 30px;
        max-width: 400px;
        margin-left: auto;
        margin-right: auto;
    }

    .pagination-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 50px;
        padding-bottom: 40px;
    }

    .pagination {
        display: flex;
        gap: 5px;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .pagination li {
        margin: 0;
    }

    .pagination a,
    .pagination span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        height: 40px;
        padding: 0;
        border: 1px solid var(--border);
        border-radius: 6px;
        color: var(--text-primary);
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .pagination a:hover {
        border-color: var(--primary);
        color: var(--primary);
        background: rgba(212, 175, 55, 0.08);
    }

    .pagination .active span {
        background: var(--primary);
        color: var(--dark);
        border-color: var(--primary);
    }

    .pagination .disabled span {
        color: var(--border);
        cursor: not-allowed;
    }

    @media (max-width: 768px) {
        .hero-section h1 {
            font-size: 2rem;
        }

        .hero-section p {
            font-size: 1rem;
        }

        .hotels-grid {
            grid-template-columns: 1fr;
        }

        .search-form {
            padding: 20px;
        }
    }
</style>

<!-- Hero Section -->
<div class="hero-section">
    <div class="container">
        <h1>Discover Our Approved Hotels</h1>
        <p>Explore a curated selection of premium accommodations across the world</p>

        <!-- Search Form -->
        <form action="{{ route('hotels.index') }}" method="GET" class="search-form">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" class="form-control" name="name" placeholder="Hotel name" value="{{ request('name') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" class="form-control" name="address" placeholder="City or location" value="{{ request('address') }}">
                    </div>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn-search">
                        <i class="fa fa-search me-2"></i>Search Hotels
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Hotels Section -->
<div class="hotels-container">
    <div class="container">
        @if($hotels->count() > 0)
            <div class="hotels-grid">
                @foreach($hotels as $hotel)
                    <div class="hotel-card">
                        <!-- Hotel Image -->
                        <div class="hotel-image">
                            @if($hotel->image)
                                <img src="{{ asset('storage/' . $hotel->image) }}" alt="{{ $hotel->name }}">
                            @else
                                <i class="fa fa-image"></i>
                            @endif
                        </div>

                        <!-- Hotel Info -->
                        <div class="hotel-card-body">
                            <h3 class="hotel-name">{{ $hotel->name }}</h3>

                            <div class="hotel-location">
                                <i class="fa fa-map-marker-alt"></i>
                                <span>{{ $hotel->address }}</span>
                            </div>

                            <p class="hotel-description">
                                {{ Str::limit($hotel->description, 80) }}
                            </p>

                            <div class="hotel-rating">
                                <span class="stars">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star-half-alt"></i>
                                </span>
                                <span class="rating-count">4.5 (128 reviews)</span>
                            </div>

                            <div class="hotel-footer">
                                <a href="{{ route('hotels.show', $hotel) }}" class="btn-view">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($hotels->hasPages())
                <div class="pagination-wrapper">
                    {{ $hotels->appends(request()->query())->links() }}
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fa fa-search"></i>
                </div>
                <h3 class="empty-state-title">No Hotels Found</h3>
                <p class="empty-state-text">
                    We couldn't find any hotels matching your search. Try adjusting your filters or browsing all available properties.
                </p>
                <a href="{{ route('hotels.index') }}" class="btn-view" style="width: 200px; margin: 0 auto;">
                    Clear Filters
                </a>
            </div>
        @endif
    </div>
</div>

@endsection
