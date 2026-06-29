<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verso & Tinta — Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --vino:#6B1C1C; --vino-dark:#3d0f0f; --vino-light:#8B2525; --crema:#f5f0e8; --dorado:#c9a87c; }
        * { box-sizing:border-box; }
        body { background-color:var(--crema); min-height:100vh; display:flex; align-items:center; justify-content:center; font-family:'Montserrat',sans-serif; padding:20px 0; }

        .login-card { width:100%; max-width:420px; border-radius:16px; overflow:hidden; box-shadow:0 12px 40px rgba(61,15,15,0.18); }

        .login-header { background:linear-gradient(135deg,var(--vino-dark),var(--vino)); padding:2.2rem 2rem; text-align:center; position:relative; }
        .login-header::after { content:''; position:absolute; bottom:-1px; left:0; right:0; height:20px; background:#fff; border-radius:50% 50% 0 0 / 100% 100% 0 0; }
        .login-header h4 { margin:0 0 4px; font-weight:800; font-size:1.5rem; color:#fff; font-family:Georgia,serif; letter-spacing:1px; }
        .login-header .subtitulo { font-size:0.78rem; color:var(--dorado); letter-spacing:2px; text-transform:uppercase; }
        .login-header .separador { width:40px; height:3px; background:var(--dorado); margin:12px auto 0; border-radius:2px; }

        .login-body { background:#fff; padding:2rem 2rem 2.5rem; }

        .form-label { font-size:0.85rem; font-weight:600; color:var(--vino-dark); margin-bottom:5px; }
        .form-control { border:1.5px solid #e0d6cc; border-radius:8px; padding:10px 14px; font-size:0.9rem; font-family:'Montserrat',sans-serif; transition:border-color 0.2s; }
        .form-control:focus { border-color:var(--vino); box-shadow:0 0 0 3px rgba(107,28,28,0.12); outline:none; }

        .btn-login { background:linear-gradient(135deg,var(--vino-dark),var(--vino)); color:#fff; border:none; width:100%; padding:11px; font-weight:700; font-size:0.95rem; border-radius:8px; font-family:'Montserrat',sans-serif; letter-spacing:0.5px; transition:opacity 0.2s; margin-top:4px; }
        .btn-login:hover { opacity:0.9; color:#fff; }

        .link-vino { color:var(--vino); text-decoration:none; font-size:0.82rem; font-weight:600; }
        .link-vino:hover { color:var(--vino-dark); text-decoration:underline; }

        .divider { border:none; border-top:1px solid #f0e8e0; margin:1.2rem 0; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <h4>Verso & Tinta</h4>
            <p class="subtitulo">Crear cuenta</p>
            <div class="separador"></div>
        </div>
        <div class="login-body">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Nombre</label>
                    <input id="name" type="text" name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}" required autofocus autocomplete="name"
                        placeholder="Tu nombre completo">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <input id="email" type="email" name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}" required autocomplete="username"
                        placeholder="tucorreo@email.com">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input id="password" type="password" name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        required autocomplete="new-password"
                        placeholder="Mínimo 8 caracteres">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                    <input id="password_confirmation" type="password" name="password_confirmation"
                        class="form-control"
                        required autocomplete="new-password"
                        placeholder="Repite tu contraseña">
                </div>

                <button type="submit" class="btn-login">Crear cuenta</button>

                <hr class="divider">

                <div class="text-center">
                    <a href="{{ route('login') }}" class="link-vino">¿Ya estás registrado? Inicia sesión</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>