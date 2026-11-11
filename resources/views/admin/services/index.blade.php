<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Services</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Manage Services</h1>
        <div>
            <a href="{{ route('admin.services.create') }}" class="btn btn-primary">Add New Service</a>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">Back to Dashboard</a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row row-cols-1 row-cols-md-3 g-4">
        @forelse ($services as $service)
            <div class="col">
            <div class="card h-100">
                @if ($service->image)
                     <img src="{{ asset('storage/' . $service->image) }}" class="card-img-top"
                        style="aspect-ratio: 4/3; object-fit: cover; {{ ! $service->is_active ? 'filter: blur(4px); opacity: 0.6;' : '' }}">
               @else
                <div class="bg-secondary d-flex align-items-center justify-content-center" style="aspect-ratio: 4/3;">
                    <span class="text-white">No image</span>
                </div>
                @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $service->name }}</h5>
                        <p class="card-text">
                            {{ ucfirst($service->target_gender) }} — {{ $service->price }} dt — {{ intdiv($service->duration_minutes, 60) }}h{{ $service->duration_minutes % 60 ? ' ' . ($service->duration_minutes % 60) . 'm' : '' }}
                        </p>
                        @if (! $service->is_active)
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </div>
            <div class="card-footer d-flex gap-2">
                <a href="{{ route('admin.services.edit', $service->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                 @if ($service->is_active)
                    <form method="POST" action="{{ route('admin.services.destroy', $service->id) }}">
                        @csrf
                        @method('DELETE')
                     <button type="submit" class="btn btn-sm btn-outline-danger">Deactivate</button>
                    </form>
                 @else
                <form method="POST" action="{{ route('admin.services.reactivate', $service->id) }}">
                    @csrf
                     <button type="submit" class="btn btn-sm btn-outline-success">Reactivate</button>
                 </form>
                @endif
            </div>
            </div>
            </div>
            @empty
            <p>No services yet.</p>
        @endforelse
    </div>

</div>
</body>
</html>