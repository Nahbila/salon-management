@extends('layouts.app')

@section('title', __('My appointments'))

@section('content')
    @php
        $labels = [
            'requested' => [__('Pending confirmation'), 'warning'],
            'confirmed' => [__('Confirmed'), 'success'],
            'in_progress' => [__('In progress'), 'info'],
            'completed' => [__('Completed'), 'secondary'],
            'cancelled' => [__('Cancelled'), 'danger'],
        ];
    @endphp

    <div style="max-width: 820px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="page-title mb-0">{{ __('Hello, :name', ['name' => $client->name]) }}</h1>
            <form method="POST" action="{{ route('client.exit') }}">
                @csrf
                <button type="submit" class="btn btn-outline-secondary btn-sm">{{ __('Exit') }}</button>
            </form>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @forelse ($appointments as $appointment)
            @php
                [$label, $color] = $labels[$appointment->status];
                $canChange = in_array($appointment->status, ['requested', 'confirmed']) && $appointment->scheduled_at->isFuture();
            @endphp

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <strong>{{ $appointment->scheduled_at->translatedFormat('d M Y, H:i') }}</strong>
                    <span class="badge bg-{{ $color }}">{{ $label }}</span>
                </div>

                <div class="card-body">
                    <p class="mb-1">
                        <strong>{{ __('Style') }}:</strong>
                        {{ $appointment->service ? $appointment->service->name : __('Custom request') }}
                    </p>

                    <p class="mb-1">
                        <strong>{{ __('Price') }}:</strong>
                        @if ($appointment->service)
                            {{ (float) $appointment->service->price }} dt
                        @elseif ($appointment->quoted_price)
                            {{ (float) $appointment->quoted_price }} dt
                        @else
                            {{ __('To be confirmed. We will call you to discuss it.') }}
                        @endif
                    </p>

                    @if ($appointment->employee)
                        <p class="mb-1"><strong>{{ __('With') }}:</strong> {{ $appointment->employee->name }}</p>
                    @endif

                    @if ($appointment->custom_request_note)
                        <p class="mb-1"><strong>{{ __('Your request') }}:</strong> {{ $appointment->custom_request_note }}</p>
                    @endif

                    <hr>
                    <p class="mb-2 fw-bold small text-muted">{{ __('History') }}</p>
                    <ul class="list-unstyled small mb-0">
                        @foreach ($appointment->statusLogs->sortBy('changed_at') as $log)
                            <li>
                                {{ $log->changed_at->translatedFormat('d M Y, H:i') }}
                                &mdash; {{ $labels[$log->status][0] }}
                            </li>
                        @endforeach
                    </ul>
                </div>

                @if ($canChange)
                    <div class="card-footer bg-white">
                        <form method="POST" action="{{ route('client.reschedule', $appointment->id) }}" class="d-flex gap-2 mb-2">
                            @csrf
                            <input type="datetime-local" name="scheduled_at" class="form-control form-control-sm"
                                   min="{{ now()->format('Y-m-d\TH:i') }}" required>
                            <button type="submit" class="btn btn-sm btn-outline-primary text-nowrap">{{ __('Change date') }}</button>
                        </form>

                        <form method="POST" action="{{ route('client.cancel', $appointment->id) }}"
                              onsubmit="return confirm({{ Js::from(__('Cancel this appointment?')) }});">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-danger">{{ __('Cancel appointment') }}</button>
                        </form>
                    </div>
                @endif
            </div>
        @empty
            <p>{{ __('No appointments yet.') }}</p>
        @endforelse

        <a href="{{ route('catalog.index') }}" class="btn btn-primary">{{ __('Book another appointment') }}</a>
    </div>
@endsection