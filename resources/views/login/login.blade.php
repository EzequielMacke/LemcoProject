<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión — LemcoProject</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            color: #111827;
            display: flex;
            flex-direction: column;
        }

        /* ── Navbar ── */
        .navbar {
            background: #fff;
            border-bottom: 1px solid #e9ecef;
            padding: 0 24px;
            height: 54px;
            display: flex; align-items: center;
            flex-shrink: 0;
        }
        .brand {
            display: flex; align-items: center; gap: 9px;
            text-decoration: none;
        }
        .brand-icon {
            width: 30px; height: 30px; border-radius: 7px;
            background: linear-gradient(135deg, #1e40af, #1d4ed8);
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 2px 6px rgba(29,78,216,0.3);
            flex-shrink: 0;
        }
        .brand-icon svg { width: 15px; height: 15px; color: #fff; }
        .brand-name { font-size: 14px; font-weight: 700; color: #111827; }

        /* ── Página ── */
        .page {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px 16px 48px;
        }

        /* ── Card del formulario ── */
        .form-card {
            background: #fff;
            border: 1.5px solid #e9ecef;
            border-radius: 18px;
            padding: 32px 28px 28px;
            width: 100%;
            max-width: 380px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            animation: fadeUp 0.4s ease both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Cabecera */
        .form-heading { margin-bottom: 28px; }
        .form-heading h2 {
            font-size: 20px; font-weight: 700; color: #0f172a;
            letter-spacing: -0.4px; margin-bottom: 4px;
        }
        .form-heading p { font-size: 13px; color: #6b7280; }

        /* Alerta */
        .alert-error {
            display: flex; align-items: center; gap: 9px;
            background: #fff1f2; border: 1.5px solid #fecdd3;
            color: #be123c; border-radius: 10px;
            padding: 11px 13px; font-size: 13px; margin-bottom: 20px;
        }
        .alert-error svg { width: 15px; height: 15px; flex-shrink: 0; }

        /* Campos */
        .field { margin-bottom: 14px; }
        .field label {
            display: block; font-size: 12px; font-weight: 600;
            color: #374151; margin-bottom: 5px;
        }
        .input-wrap { position: relative; }
        .input-wrap .icon {
            position: absolute; left: 12px; top: 50%;
            transform: translateY(-50%);
            color: #9ca3af; pointer-events: none;
            display: flex; align-items: center;
        }
        .input-wrap .icon svg { width: 14px; height: 14px; }

        .field input {
            width: 100%; background: #fafafa;
            border: 1.5px solid #e9ecef; border-radius: 10px;
            padding: 10px 13px 10px 38px;
            font-size: 13.5px; font-family: 'Inter', sans-serif;
            color: #111827; outline: none;
            transition: border-color 0.15s, box-shadow 0.15s, background 0.15s;
        }
        .field input::placeholder { color: #d1d5db; font-size: 13px; }
        .field input:hover  { border-color: #d1d5db; }
        .field input:focus  {
            border-color: #1d4ed8; background: #fff;
            box-shadow: 0 0 0 3px rgba(29,78,216,0.1);
        }

        /* Botón principal */
        .btn-primary {
            width: 100%;
            background: linear-gradient(135deg, #1e40af, #1d4ed8);
            color: #fff; font-size: 13.5px; font-weight: 600;
            font-family: 'Inter', sans-serif;
            border: none; border-radius: 10px; padding: 11px;
            cursor: pointer; margin-top: 6px;
            box-shadow: 0 3px 10px rgba(29,78,216,0.3);
            transition: opacity 0.15s, transform 0.1s, box-shadow 0.15s;
        }
        .btn-primary:hover {
            opacity: 0.92; transform: translateY(-1px);
            box-shadow: 0 5px 16px rgba(29,78,216,0.4);
        }
        .btn-primary:active { transform: translateY(0); }

        /* Divider */
        .divider {
            display: flex; align-items: center; gap: 10px;
            margin: 20px 0; color: #9ca3af;
            font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;
        }
        .divider::before, .divider::after {
            content: ''; flex: 1; height: 1px; background: #e9ecef;
        }

        /* Botón secundario */
        .btn-secondary {
            width: 100%; background: #fff; color: #374151;
            font-size: 13px; font-weight: 500;
            font-family: 'Inter', sans-serif;
            border: 1.5px solid #e9ecef; border-radius: 10px; padding: 10px;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 7px;
            text-decoration: none;
            transition: background 0.15s, border-color 0.15s, color 0.15s;
        }
        .btn-secondary:hover { background: #f8f9fa; border-color: #d1d5db; color: #111827; }
        .btn-secondary svg { width: 14px; height: 14px; }

        /* Links */
        .bottom-links { margin-top: 16px; text-align: center; }
        .bottom-links a {
            font-size: 12px; color: #9ca3af;
            text-decoration: none; transition: color 0.15s;
        }
        .bottom-links a:hover { color: #1d4ed8; }

        /* Footer */
        .form-footer {
            margin-top: 28px; padding-top: 20px;
            border-top: 1px solid #f1f3f5;
            text-align: center; font-size: 11px; color: #9ca3af;
        }
    </style>
</head>
<body>

{{-- Navbar --}}
<nav class="navbar">
    <a href="#" class="brand">
        <div class="brand-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/>
            </svg>
        </div>
        <span class="brand-name">LemcoProject</span>
    </a>
</nav>

{{-- Contenido --}}
<main class="page">
    <div class="form-card">

        <div class="form-heading">
            <h2>Bienvenido</h2>
            <p>Ingresá tus credenciales para continuar</p>
        </div>

        @if ($errors->any())
            <div class="alert-error">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                </svg>
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            <div class="field">
                <label for="nick">Usuario</label>
                <div class="input-wrap">
                    <span class="icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                        </svg>
                    </span>
                    <input type="text" id="nick" name="nick"
                           value="{{ old('nick') }}" placeholder="Tu usuario" autofocus>
                </div>
            </div>

            <div class="field">
                <label for="contrasena">Contraseña</label>
                <div class="input-wrap">
                    <span class="icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                        </svg>
                    </span>
                    <input type="password" id="contrasena" name="contrasena" placeholder="••••••••">
                </div>
            </div>

            <button type="submit" class="btn-primary">Ingresar</button>

        </form>

        <div class="divider">o</div>

        <a href="{{ route('usuarios.create') }}" class="btn-secondary">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z"/>
            </svg>
            Crear cuenta
        </a>

        <div class="bottom-links">
            <a href="#">¿Olvidaste tu contraseña?</a>
        </div>

        <div class="form-footer">
            Acceso restringido &mdash; Solo personal autorizado
        </div>

    </div>
</main>

</body>
</html>
