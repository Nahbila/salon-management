@extends('layouts.app')

@section('title', __('Choose your style'))

@section('content')
    <h1 class="page-title">{{ __('Choose your style') }}</h1>
    <p class="text-muted mb-0">{{ __('Pick the style you like, then choose a date.') }}</p>

    <div class="filters" role="group" aria-label="{{ __('Filter styles') }}">
        <button type="button" class="filter-btn active" data-filter="all">{{ __('All') }}</button>
        <button type="button" class="filter-btn" data-filter="female">{{ __('Women') }}</button>
        <button type="button" class="filter-btn" data-filter="male">{{ __('Men') }}</button>
    </div>

    @if ($services->isEmpty())
        <p>{{ __('No styles are available right now. Check back soon.') }}</p>
    @endif

    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-4" id="styleGrid">
        @foreach ($services as $service)
            <div class="col" data-gender="{{ $service->target_gender }}">
                <article class="style-card">
                    <div class="style-photo">
                        @if ($service->image)
                            <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" loading="lazy">
                        @else
                            <div class="no-photo">{{ __('Photo coming soon') }}</div>
                        @endif
                    </div>
                    <div class="style-body">
                        <div class="style-head">
                            <h2 class="style-name">{{ $service->name }}</h2>
                            <span class="style-price">{{ (float) $service->price }} dt</span>
                        </div>
                        <p class="style-meta">
                            <span>{{ $service->target_gender === 'female' ? __('Women') : __('Men') }}</span>
                            <span>{{ $service->duration_label }}</span>
                        </p>
                        <a href="{{ route('booking.create', ['service' => $service->id]) }}" class="btn btn-primary">{{ __('Book this style') }}</a>
                    </div>
                </article>
            </div>
        @endforeach

        <div class="col" data-gender="custom">
            <article class="style-card custom-card">
                <div class="style-body">
                    <h2 class="style-name mb-2">{{ __("Can't find your style?") }}</h2>
                    <p class="text-muted">{{ __('Describe it or send a photo. We will call you to agree on the price.') }}</p>
                    <a href="{{ route('booking.create') }}" class="btn btn-outline-primary">{{ __('Request a custom style') }}</a>
                </div>
            </article>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    const buttons = document.querySelectorAll('.filter-btn');
    const cards = document.querySelectorAll('#styleGrid [data-gender]');

    buttons.forEach(button => {
        button.addEventListener('click', () => {
            buttons.forEach(b => b.classList.remove('active'));
            button.classList.add('active');

            const filter = button.dataset.filter;
            cards.forEach(card => {
                const gender = card.dataset.gender;
                card.hidden = !(filter === 'all' || gender === filter || gender === 'custom');
            });
        });
    });
</script>
@endpush