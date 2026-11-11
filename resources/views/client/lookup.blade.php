@extends('layouts.app')

@section('title', __('My appointments'))

@section('content')
    <h1 class="page-title">{{ __('My appointments') }}</h1>
    <p class="text-muted mb-4">{{ __('Enter the phone number you used when booking.') }}</p>

    <div class="form-card" style="max-width: 460px;">
        <form method="POST" action="{{ route('client.find') }}">
            @csrf
            <div class="mb-3">
                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                       value="{{ old('phone') }}" placeholder="{{ __('Your phone number') }}" required autofocus>
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary w-100">{{ __('See my appointments') }}</button>
        </form>
    </div>

    <a href="{{ route('catalog.index') }}" class="d-inline-block mt-4">&larr; {{ __('Back to home') }}</a>
@endsection