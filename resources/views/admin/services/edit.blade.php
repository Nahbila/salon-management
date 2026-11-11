<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Service</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5" style="max-width: 600px;">
    <h1 class="mb-4">Edit Service</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($service->image)
        <img src="{{ asset('storage/' . $service->image) }}" style="height: 150px;" class="rounded mb-3">
    @endif

    <form method="POST" action="{{ route('admin.services.update', $service->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $service->name) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control">{{ old('description', $service->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Price (dt)</label>
            <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $service->price) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Duration (minutes)</label>
            <input type="number" name="duration_minutes" class="form-control" value="{{ old('duration_minutes', $service->duration_minutes) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">For</label>
            <select name="target_gender" class="form-select" required>
                <option value="female" @selected(old('target_gender', $service->target_gender) === 'female')>Female</option>
                <option value="male" @selected(old('target_gender', $service->target_gender) === 'male')>Male</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Replace Image (leave empty to keep current)</label>
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" name="is_active" value="1" class="form-check-input" id="isActive" @checked($service->is_active)>
            <label class="form-check-label" for="isActive">Active</label>
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary">Cancel</a>
    </form>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>
<script>
    let cropper;
    const imageInput = document.getElementById('imageInput');
    const cropperImage = document.getElementById('cropperImage');
    const cropContainer = document.getElementById('cropContainer');
    const form = document.querySelector('form');

    imageInput.addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function (event) {
            cropperImage.src = event.target.result;
            cropContainer.style.display = 'block';

            if (cropper) cropper.destroy();
            cropper = new Cropper(cropperImage, {
                aspectRatio: 4/3,
                viewMode: 1,
            });
        };
        reader.readAsDataURL(file);
    });

    form.addEventListener('submit', function (e) {
        if (cropper) {
            e.preventDefault();
            cropper.getCroppedCanvas({ width: 600, height: 600 }).toBlob(function (blob) {
                const dataTransfer = new DataTransfer();
                const croppedFile = new File([blob], 'service.jpg', { type: 'image/jpeg' });
                dataTransfer.items.add(croppedFile);

                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'file';
                hiddenInput.name = 'image';
                hiddenInput.style.display = 'none';
                hiddenInput.files = dataTransfer.files;
                form.appendChild(hiddenInput);

                form.submit();
            }, 'image/jpeg');
        }
    });
</script>
</body>
</html>