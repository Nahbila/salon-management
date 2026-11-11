@extends('layouts.app')

@section('title', __('booking.title'))

@section('content')
    <h1 class="page-title mb-4">{{ __('booking.title') }}</h1>

    <div class="form-card">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('booking.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">{{ __('booking.choose_service') }}</label>
                <select name="service_id" class="form-select">
                    <option value="">{{ __('Custom request (no fixed style)') }}</option>
                    @foreach ($services as $service)
                        <option value="{{ $service->id }}" @selected($selectedServiceId == $service->id)>
                            {{ $service->name }} ({{ $service->target_gender === 'female' ? __('Women') : __('Men') }})
                            &mdash; {{ (float) $service->price }} dt &mdash; {{ $service->duration_label }}
                        </option>
                    @endforeach
                </select>
                <div class="form-hint">{{ __('Choosing a custom request? Describe it below and we will call you to agree on the price.') }}</div>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('booking.preferred_datetime') }}</label>
                <input type="datetime-local" name="scheduled_at" class="form-control"
                       value="{{ old('scheduled_at') }}" min="{{ now()->format('Y-m-d\TH:i') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('booking.your_name') }}</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('booking.phone_number') }}</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
                <div class="form-hint">{{ __('You will use this number to see or change your appointment later.') }}</div>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('booking.email_optional') }}</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('Anything we should know? (optional)') }}</label>
                <textarea name="custom_request_note" class="form-control" rows="3">{{ old('custom_request_note') }}</textarea>
            </div>

            <div class="mb-4">
                <label class="form-label">{{ __('Reference photo (optional)') }}</label>
                <input type="file" name="custom_request_image" class="form-control" accept="image/*">
            </div>

            <button type="submit" class="btn btn-primary">{{ __('booking.submit') }}</button>
            <a href="{{ route('catalog.index') }}" class="btn btn-outline-secondary ms-2">{{ __('Back to styles') }}</a>
        </form>
    </div>
@endsection