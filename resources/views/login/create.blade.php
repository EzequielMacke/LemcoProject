<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo usuario — LemcoProject</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

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
            display: flex; align-items: center; justify-content: space-between;
            flex-shrink: 0;
        }
        .navbar-left { display: flex; align-items: center; gap: 12px; }

        .btn-back {
            display: flex; align-items: center; gap: 6px;
            background: none; border: 1.5px solid #e9ecef; border-radius: 8px;
            padding: 6px 11px; font-size: 13px; font-weight: 500;
            color: #6b7280; text-decoration: none;
            transition: all 0.15s;
        }
        .btn-back:hover { background: #f8f9fa; border-color: #d1d5db; color: #111827; }
        .btn-back svg { width: 13px; height: 13px; }

        .nav-sep      { width: 1px; height: 18px; background: #e9ecef; }
        .navbar-title { font-size: 14px; font-weight: 600; color: #111827; }

        .navbar-user {
            display: flex; align-items: center; gap: 7px;
            font-size: 13px; font-weight: 500; color: #374151;
            background: #f1f3f5; border: 1.5px solid #e9ecef;
            padding: 4px 11px 4px 5px; border-radius: 99px;
        }
        .user-chip {
            width: 24px; height: 24px; border-radius: 50%;
            background: linear-gradient(135deg, #1e40af, #1d4ed8);
            display: flex; align-items: center; justify-content: center;
            font-size: 10px; font-weight: 700; color: #fff; flex-shrink: 0;
        }

        /* ── Page ── */
        .page {
            flex: 1;
            padding: 28px 24px 40px;
            display: flex; flex-direction: column;
            align-items: center; gap: 20px;
        }

        /* ── Header ── */
        .page-header {
            width: 100%; max-width: 440px;
            animation: fadeUp 0.35s ease both;
        }
        .page-label   { font-size: 11.5px; font-weight: 600; color: #0e7490; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }
        .page-heading { font-size: 20px; font-weight: 700; color: #0f172a; letter-spacing: -0.3px; }
        .page-sub     { font-size: 13px; color: #6b7280; margin-top: 3px; }

        /* ── Alertas ── */
        .alert {
            width: 100%; max-width: 440px;
            border-radius: 10px; padding: 12px 16px; font-size: 13px;
            display: flex; align-items: center; gap: 10px;
            animation: fadeUp 0.35s ease both;
        }
        .alert-success { background: #f0fdf4; border: 1.5px solid #bbf7d0; color: #15803d; }
        .alert-error   { background: #fff1f2; border: 1.5px solid #fecdd3; color: #be123c; }
        .alert svg { width: 16px; height: 16px; flex-shrink: 0; }

        /* ── Form card ── */
        .form-card {
            width: 100%; max-width: 440px;
            background: #fff;
            border: 1.5px solid #e9ecef;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            animation: fadeUp 0.4s ease 0.06s both;
        }

        .form-body { padding: 24px; display: flex; flex-direction: column; gap: 18px; }

        /* ── Fields ── */
        .field { display: flex; flex-direction: column; gap: 5px; }
        .field label { font-size: 12px; font-weight: 600; color: #374151; }

        .input-wrap { position: relative; }
        .input-wrap input {
            width: 100%; border: 1.5px solid #e9ecef; border-radius: 10px;
            padding: 10px 40px 10px 13px; font-size: 13.5px; color: #111827;
            background: #fafafa; outline: none; font-family: 'Inter', sans-serif;
            transition: border-color 0.15s, box-shadow 0.15s, background 0.15s;
        }
        .input-wrap input:hover  { border-color: #d1d5db; }
        .input-wrap input:focus  {
            border-color: #0e7490; background: #fff;
            box-shadow: 0 0 0 3px rgba(14,116,144,0.1);
        }
        .input-wrap input.is-invalid { border-color: #f87171; }
        .input-wrap input.is-invalid:focus {
            border-color: #f87171;
            box-shadow: 0 0 0 3px rgba(248,113,113,0.15);
        }

        /* Ícono dentro del input (sólo nick) */
        .input-icon {
            position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
            color: #d1d5db; pointer-events: none;
        }
        .input-icon svg { width: 15px; height: 15px; }

        /* Toggle mostrar/ocultar contraseña */
        .btn-eye {
            position: absolute; right: 10px; top: 50%; transform: translateY(-50%);
            background: none; border: none; cursor: pointer; color: #9ca3af;
            display: flex; align-items: center; padding: 2px;
            transition: color 0.15s;
        }
        .btn-eye:hover { color: #374151; }
        .btn-eye svg { width: 16px; height: 16px; }

        .field-error { font-size: 12px; color: #be123c; }
        .field-hint  { font-size: 12px; }
        .hint-ok     { color: #15803d; }
        .hint-taken  { color: #be123c; }

        /* ── Divisor ── */
        .divider {
            height: 1px; background: #f1f3f5; margin: 0 -24px;
        }

        /* ── Footer ── */
        .form-footer {
            padding: 16px 24px;
            background: #f8fafc;
            border-top: 1.5px solid #e9ecef;
            display: flex; align-items: center; justify-content: flex-end;
        }

        .btn-submit {
            display: inline-flex; align-items: center; gap: 7px;
            background: linear-gradient(135deg, #164e63, #0e7490);
            color: #fff; font-size: 13px; font-weight: 600;
            border: none; border-radius: 10px; padding: 10px 22px;
            cursor: pointer; font-family: 'Inter', sans-serif;
            box-shadow: 0 3px 10px rgba(14,116,144,0.3);
            transition: opacity 0.15s, transform 0.1s;
        }
        .btn-submit:hover  { opacity: 0.9; transform: translateY(-1px); }
        .btn-submit:active { transform: translateY(0); }
        .btn-submit svg { width: 14px; height: 14px; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 600px) {
            .page { padding: 20px 16px 32px; }
        }
    </style>
</head>
<body>

{{-- Navbar --}}
<nav class="navbar">
    <div class="navbar-left">
        <a href="{{ route('login') }}" class="btn-back">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
            </svg>
            Volver
        </a>
        <div class="nav-sep"></div>
        <span class="navbar-title">Nuevo usuario</span>
    </div>
    @if(session('usuario.nick'))
    <div class="navbar-user">
        <div class="user-chip">{{ strtoupper(substr(session('usuario.nick'), 0, 1)) }}</div>
        {{ session('usuario.nick') }}
    </div>
    @endif
</nav>

<main class="page">

    {{-- Header --}}
    <div class="page-header">
        <div class="page-label">Módulo · Usuarios</div>
        <div class="page-heading">Nuevo usuario</div>
        <div class="page-sub">Completá los datos para crear una cuenta</div>
    </div>

    {{-- Alertas --}}
    @if(session('success'))
    <div class="alert alert-success">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- Formulario --}}
    <div class="form-card">
        <form method="POST" action="{{ route('usuarios.store') }}">
            @csrf
            <div class="form-body">

                {{-- Nick --}}
                <div class="field">
                    <label for="nick">Nick</label>
                    <div class="input-wrap">
                        <input
                            type="text"
                            id="nick"
                            name="nick"
                            value="{{ old('nick') }}"
                            placeholder="Ej: jperez"
                            autocomplete="username"
                            class="{{ $errors->has('nick') ? 'is-invalid' : '' }}"
                            autofocus
                        >
                        <span class="input-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                            </svg>
                        </span>
                    </div>
                    @error('nick')
                        <span class="field-error">{{ $message }}</span>
                    @else
                        <span id="nick-hint" class="field-hint" style="display:none"></span>
                    @enderror
                </div>

                {{-- Contraseña --}}
                <div class="field">
                    <label for="contrasena">Contraseña</label>
                    <div class="input-wrap">
                        <input
                            type="password"
                            id="contrasena"
                            name="contrasena"
                            placeholder="Mínimo 6 caracteres"
                            autocomplete="new-password"
                            class="{{ $errors->has('contrasena') ? 'is-invalid' : '' }}"
                        >
                        <button type="button" class="btn-eye" onclick="togglePassword('contrasena', this)" tabindex="-1">
                            <svg id="eye-contrasena" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </button>
                    </div>
                    @error('contrasena')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Confirmar contraseña --}}
                <div class="field">
                    <label for="contrasena_confirmation">Confirmar contraseña</label>
                    <div class="input-wrap">
                        <input
                            type="password"
                            id="contrasena_confirmation"
                            name="contrasena_confirmation"
                            placeholder="Repetí la contraseña"
                            autocomplete="new-password"
                        >
                        <button type="button" class="btn-eye" onclick="togglePassword('contrasena_confirmation', this)" tabindex="-1">
                            <svg id="eye-contrasena_confirmation" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </button>
                    </div>
                </div>

            </div>

            <div class="form-footer">
                <button type="submit" class="btn-submit">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z"/>
                    </svg>
                    Crear usuario
                </button>
            </div>
        </form>
    </div>

</main>

<script>
    function togglePassword(id, btn) {
        const input = document.getElementById(id);
        const isText = input.type === 'text';
        input.type = isText ? 'password' : 'text';
        btn.querySelector('svg').style.opacity = isText ? '1' : '0.4';
    }

    // Verificación en tiempo real del nick
    const nickInput = document.getElementById('nick');
    const nickHint  = document.getElementById('nick-hint');
    let debounce;

    if (nickInput && nickHint) {
        nickInput.addEventListener('input', () => {
            clearTimeout(debounce);
            nickHint.style.display = 'none';
            nickInput.classList.remove('is-invalid');

            const nick = nickInput.value.trim();
            if (!nick) return;

            debounce = setTimeout(async () => {
                try {
                    const res  = await fetch(`{{ route('usuarios.nickDisponible') }}?nick=${encodeURIComponent(nick)}`);
                    const data = await res.json();

                    nickHint.style.display = 'block';
                    if (data.disponible) {
                        nickHint.className  = 'field-hint hint-ok';
                        nickHint.textContent = '✓ Nick disponible';
                        nickInput.classList.remove('is-invalid');
                    } else {
                        nickHint.className  = 'field-hint hint-taken';
                        nickHint.textContent = '✗ Ese nick ya está en uso';
                        nickInput.classList.add('is-invalid');
                    }
                } catch {}
            }, 400);
        });
    }
</script>

</body>
</html>
