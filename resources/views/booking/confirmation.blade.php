@extends('layouts.app')

@section('title', __('booking.booking_details'))

@section('content')
    @php
        $statusLabels = [
            'requested' => __('Pending confirmation'),
            'confirmed' => __('Confirmed'),
            'in_progress' => __('In progress'),
            'completed' => __('Completed'),
            'cancelled' => __('Cancelled'),
        ];
    @endphp

    <div style="max-width: 700px;">
        <div class="alert alert-success">{{ __('booking.confirmation_success') }}</div>

        @unless ($appointment->service)
            <div class="alert alert-info">
                {{ __('We received your custom request. We will call you on :phone to discuss the style and the price.', ['phone' => $appointment->client->phone]) }}
            </div>
        @endunless

        <h1 class="page-title mb-3">{{ __('booking.booking_details') }}</h1>
        <ul class="list-group">
            <li class="list-group-item">
                <strong>{{ __('booking.service') }}:</strong>
                {{ $appointment->service ? $appointment->service->name : __('Custom request') }}
            </li>
            <li class="list-group-item">
                <strong>{{ __('booking.date_time') }}:</strong>
                {{ $appointment->scheduled_at->translatedFormat('d M Y, H:i') }}
            </li>
            <li class="list-group-item">
                <strong>{{ __('booking.total_amount') }}:</strong>
                {{ $appointment->service ? (float) $appointment->service->price . ' dt' : __('To be confirmed') }}
            </li>
            <li class="list-group-item">
                <strong>{{ __('booking.status') }}:</strong>
                {{ $statusLabels[$appointment->status] }}
            </li>
        </ul>

        <p class="text-muted mt-3 small">
            {{ __('You can follow, change or cancel this appointment at any time in My appointments, using your phone number.') }}
        </p>

        <div class="d-flex flex-wrap gap-2 mt-3">
            <a href="{{ url('/') }}" class="btn btn-outline-secondary">{{ __('Back to home') }}</a>
            <a href="{{ route('catalog.index') }}" class="btn btn-primary">{{ __('Book another appointment') }}</a>
            <a href="{{ route('client.lookup') }}" class="btn btn-outline-primary">{{ __('My appointments') }}</a>
        </div>
    </div>
@endsection