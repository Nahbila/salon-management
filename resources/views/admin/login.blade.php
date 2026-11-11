<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5" style="max-width: 400px;">
    <h1 class="mb-4">Admin Login</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.login.submit') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required autofocus>
        </div>

        <div class="mb-3">
             <label class="form-label">Password</label>
            <div class="position-relative">
                <input type="password" name="password" id="password" class="form-control pe-5" required>
                <span id="togglePassword" role="button"
                    class="position-absolute top-50 end-0 translate-middle-y me-3 text-muted"
                    style="cursor: pointer; font-size: 0.85rem;">
                  show
                </span>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
</div>
<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        const input = document.getElementById('password');
        const isHidden = input.type === 'password';
        input.type = isHidden ? 'text' : 'password';
        this.textContent = isHidden ? 'hide' : 'show';
    });
</script>
</body>
</html>