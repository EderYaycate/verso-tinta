<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verso & Tinta — Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --vino: #6B1C1C;
            --vino-dark: #3d0f0f;
            --vino-light: #8B2525;
            --crema: #f5f0e8;
        }
        body {
            background-color: var(--crema);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.12);
            width: 100%;
            max-width: 420px;
        }
        .card-header {
            background-color: var(--vino);
            color: white;
            text-align: center;
            border-radius: 12px 12px 0 0 !important;
            padding: 2rem;
        }
        .card-header h4 { margin: 0; font-weight: 700; letter-spacing: 1px; }
        .card-header p { margin: 0; font-size: 0.85rem; opacity: 0.8; }
        .btn-vino { background-color: var(--vino); color: white; border: none; width: 100%; padding: 0.6rem; font-weight: 600; }
        .btn-vino:hover { background-color: var(--vino-dark); color: white; }
        .form-control:focus { border-color: var(--vino-light); box-shadow: 0 0 0 0.2rem rgba(107,28,28,0.2); }
    </style>
</head>
<body>
    <div class="card">
        <div class="card-header">
            <h4>Verso & Tinta</h4>
            <p>Librería digital</p>
        </div>
        <div class="card-body p-4">

            @if (session('status'))
                <div class="alert alert-success mb-3">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <input type="hidden" name="redirect" value="{{ request('redirect') }}">

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Correo electrónico</label>
                    <input id="email" type="email" name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}" required autofocus autocomplete="username">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Contraseña</label>
                    <input id="password" type="password" name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        required autocomplete="current-password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                    <label class="form-check-label" for="remember_me">Recordarme</label>
                </div>

                <button type="submit" class="btn btn-vino">Iniciar sesión</button>

                @if (Route::has('password.request'))
                    <div class="text-center mt-3">
                        <a href="{{ route('password.request') }}"
                            class="text-decoration-none small"
                            style="color: var(--vino);">
                            ¿Olvidaste tu contraseña?
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>