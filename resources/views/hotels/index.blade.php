@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary: #D4AF37;
        --primary-dark: #1a2332;
        --secondary: #2c3e50;
        --text-primary: #2C2C2C;
        --text-secondary: #666666;
        --border-light: #F0EFEC;
        --bg-neutral: #FAFAF8;
    }
    body {
        background-color: var(--bg-neutral);
    }
    .hero {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--secondary) 100%);
        color: white;
        padding: 60px 20px;
        text-align: center;
    }
    .search-box {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        margin: -30px 20px 40px;
        position: relative;
        z-index: 10;
    }
    .btn-search {
        background: var(--primary);
        color: var(--text-primary);
        border: none;
        font-weight: 600;
    }
    .btn-search:hover {
        background: #F5C842;
        color: var(--text-primary);
    }
    .hotel-card {
        border: 1px solid var(--border-light);
        border-radius: 8px;
        overflow: hidden;
        transition: all 0.3s ease;
        height: 100%;
    }
    .hotel-card:hover {
        box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        transform: translateY(-4px);
    }
    .hotel-img {
        width: 100%;
        height: 220px;
        object-fit: cover;
        background: linear-gradient(135deg, var(--secondary) 0%, var(--primary-dark) 100%);
    }
    .hotel-title {
        font-weight: 700;
        color: var(--text-primary);
        font-size: 1.1rem;
    }
    .hotel-address {
        font-size: 0.9rem;
        color: var(--text-secondary);
    }
    .hotel-rating {
        color: var(--primary);
        font-size: 0.9rem;
    }
    .btn-details {
        background: var(--primary);
        color: var(--text-primary);
        border: none;
        font-weight: 600;
    }
    .btn-details:hover {
        background: #F5C842;
        color: var(--text-primary);
    }
</style>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <h1>Discover Luxury Hotels</h1>
        <p>Find your perfect accommodation</p>
    </div>
</section>

<!-- Search Box -->
<div class="container">
    <div class="search-box">
        <form method="GET" class="row g-2">
            <div class="col-md-5">
                <input type="text" name="name" class="form-control" placeholder="Hotel name" value="{{ request('name') }}">
            </div>
            <div class="col-md-5">
                <input type="text" name="address" class="form-control" placeholder="City/Location" value="{{ request('address') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-search w-100"><i class="fa fa-search"></i> Search</button>
            </div>
        </form>
    </div>
</div>

<!-- Hotels Grid -->
<div class="container pb-5">
    @if($hotels->count() > 0)
        <div class="row g-4">
            @foreach($hotels as $hotel)
                <div class="col-md-6 col-lg-4">
                    <div class="card hotel-card">
                        <!-- Image -->
                        <div style="height: 220px; overflow: hidden;">
                            @if($hotel->image)
                                <img src="{{ asset('storage/' . $hotel->image) }}" alt="{{ $hotel->name }}" class="hotel-img">
                            @else
                                <div class="d-flex align-items-center justify-content-center" style="height: 100%; background: linear-gradient(135deg, var(--secondary) 0%, var(--primary-dark) 100%); color: rgba(255,255,255,0.3);">
                                    <i class="fas fa-image fa-3x"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Body -->
                        <div class="card-body d-flex flex-column">
                            <h5 class="hotel-title mb-2">{{ $hotel->name }}</h5>
                            
                            <p class="hotel-address mb-2">
                                <i class="fas fa-map-marker-alt" style="color: var(--primary);"></i> {{ $hotel->address }}
                            </p>

                            <div class="hotel-rating mb-3">
                                @for($i = 0; $i < 5; $i++)
                                    @if($i < intval($hotel->rating))
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                                <span style="color: var(--text-secondary); margin-left: 8px;">{{ $hotel->rating }}/5</span>
                            </div>

                            <a href="{{ route('hotels.show', $hotel->id) }}" class="btn btn-details mt-auto">View Details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-5">
            {{ $hotels->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-search" style="font-size: 3rem; color: var(--border-light);"></i>
            <h4 class="mt-3" style="color: var(--text-primary);">No Hotels Found</h4>
            <p style="color: var(--text-secondary);">Try adjusting your search filters</p>
        </div>
    @endif
</div>

@endsection
