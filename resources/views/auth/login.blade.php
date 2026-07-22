<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - NH Beauty Salon</title>

    <link rel="icon" type="image/png" href="{{ asset('assets/US.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}?v={{ time() }}">
</head>
<body>
    <div class="auth-background"></div>

    <div class="container d-flex flex-column align-items-center">
        <div class="auth-card text-center">
            <a href="{{ route('landing') }}">
                <img src="{{ asset('assets/LOGOBARU.png') }}" alt="Logo" class="auth-logo">
            </a>

            <h4 class="text-white fw-bold mb-4">Welcome Back</h4>

            @if ($errors->any())
                <div class="alert alert-danger border-0 bg-danger bg-opacity-10 text-danger rounded-4 mb-4 small">
                    <ul class="mb-0 list-unstyled">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="text-start mb-3">
                    <label for="username" class="form-label">Username</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" class="form-control" id="username" name="username_p" value="{{ old('username_p') }}" placeholder="Masukkan username" required autofocus>
                    </div>
                </div>

                <div class="text-start mb-4">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" class="form-control" id="password" name="password_p" placeholder="Masukkan password" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-auth w-100">Sign In</button>
            </form>
        </div>

        <a href="{{ route('landing') }}" class="back-to-home">
            <i class="bi bi-arrow-left"></i> Kembali ke Beranda
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
