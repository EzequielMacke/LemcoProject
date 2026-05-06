<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis datos — LemcoProject</title>
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
            color: #6b7280; text-decoration: none; font-family: 'Inter', sans-serif;
            transition: all 0.15s;
        }
        .btn-back:hover { background: #f8f9fa; border-color: #d1d5db; color: #111827; }
        .btn-back svg { width: 13px; height: 13px; }

        .nav-sep { width: 1px; height: 18px; background: #e9ecef; }
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

        /* ── Contenido ── */
        .page {
            flex: 1;
            padding: 28px 24px 40px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* ── Cabecera de perfil ── */
        .profile-card {
            background: #fff;
            border: 1.5px solid #e9ecef;
            border-radius: 18px;
            padding: 22px 24px;
            display: flex;
            align-items: center;
            gap: 18px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            animation: fadeUp 0.35s ease both;
        }
        .avatar {
            width: 56px; height: 56px; border-radius: 50%;
            background: linear-gradient(135deg, #1e40af, #1d4ed8);
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; font-weight: 700; color: #fff;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(29,78,216,0.3);
        }
        .profile-info { flex: 1; min-width: 0; }
        .profile-name { font-size: 16px; font-weight: 700; color: #0f172a; margin-bottom: 2px; }
        .profile-sub  { font-size: 12.5px; color: #9ca3af; }

        .status-badge {
            display: inline-flex; align-items: center; gap: 5px;
            font-size: 11.5px; font-weight: 600; padding: 5px 12px;
            border-radius: 99px; flex-shrink: 0;
        }
        .status-completo   { background: #f0fdf4; color: #15803d; border: 1.5px solid #bbf7d0; }
        .status-incompleto { background: #fffbeb; color: #b45309; border: 1.5px solid #fde68a; }
        .status-badge svg  { width: 12px; height: 12px; }

        /* ── Alertas ── */
        .alert {
            border-radius: 10px; padding: 12px 16px; font-size: 13px;
            display: flex; align-items: center; gap: 10px;
            animation: fadeUp 0.35s ease both;
        }
        .alert-success { background: #f0fdf4; border: 1.5px solid #bbf7d0; color: #15803d; }
        .alert-error   { background: #fff1f2; border: 1.5px solid #fecdd3; color: #be123c; }
        .alert svg { width: 16px; height: 16px; flex-shrink: 0; }

        /* ── Form card ── */
        .form-card {
            background: #fff;
            border: 1.5px solid #e9ecef;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            animation: fadeUp 0.4s ease 0.06s both;
        }

        .form-section {
            padding: 22px 24px;
            border-bottom: 1px solid #f1f3f5;
        }
        .form-section:last-child { border-bottom: none; }

        .section-head {
            display: flex; align-items: center; gap: 10px;
            margin-bottom: 18px;
        }
        .section-icon {
            width: 32px; height: 32px; border-radius: 9px;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .icon-id   { background: #eff6ff; color: #1d4ed8; }
        .icon-mail { background: #f0f9ff; color: #0369a1; }
        .icon-work { background: #f0fdf4; color: #15803d; }
        .section-icon svg { width: 15px; height: 15px; }

        .section-label { font-size: 13.5px; font-weight: 600; color: #111827; }
        .section-hint  { font-size: 12px; color: #9ca3af; margin-left: auto; }

        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        .form-grid .full { grid-column: 1 / -1; }

        .field { display: flex; flex-direction: column; gap: 5px; }
        .field label { font-size: 12px; font-weight: 600; color: #374151; }

        .field input {
            width: 100%; border: 1.5px solid #e9ecef; border-radius: 10px;
            padding: 10px 13px; font-size: 13.5px; color: #111827;
            background: #fafafa; outline: none; font-family: 'Inter', sans-serif;
            transition: border-color 0.15s, box-shadow 0.15s, background 0.15s;
        }
        .field input:hover  { border-color: #d1d5db; }
        .field input:focus  {
            border-color: #1d4ed8; background: #fff;
            box-shadow: 0 0 0 3px rgba(29,78,216,0.1);
        }
        .field input:not(:placeholder-shown) { background: #fff; }
        .field input::placeholder { color: #d1d5db; font-size: 13px; }

        /* ── Footer ── */
        .form-footer {
            padding: 16px 24px;
            background: #f8fafc;
            border-top: 1.5px solid #e9ecef;
            display: flex; align-items: center; justify-content: space-between;
        }
        .footer-hint {
            display: flex; align-items: center; gap: 6px;
            font-size: 12px; color: #9ca3af;
        }
        .footer-hint svg { width: 13px; height: 13px; }

        .btn-save {
            display: inline-flex; align-items: center; gap: 7px;
            background: linear-gradient(135deg, #1e40af, #1d4ed8);
            color: #fff; font-size: 13px; font-weight: 600;
            border: none; border-radius: 10px; padding: 10px 20px;
            cursor: pointer; font-family: 'Inter', sans-serif;
            box-shadow: 0 3px 10px rgba(29,78,216,0.3);
            transition: opacity 0.15s, transform 0.1s, box-shadow 0.15s;
        }
        .btn-save:hover {
            opacity: 0.9; transform: translateY(-1px);
            box-shadow: 0 5px 16px rgba(29,78,216,0.4);
        }
        .btn-save:active { transform: translateY(0); }
        .btn-save svg { width: 14px; height: 14px; }

        .field input[readonly] {
            background: #f1f3f5;
            color: #6b7280;
            cursor: default;
        }
        .field input[readonly]:hover  { border-color: #e9ecef; }
        .field input[readonly]:focus  { border-color: #e9ecef; box-shadow: none; background: #f1f3f5; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── Responsive ── */
        @media (max-width: 600px) {
            .page { padding: 20px 16px 32px; }
            .profile-card { padding: 18px; gap: 14px; }
            .avatar { width: 48px; height: 48px; font-size: 17px; }
            .status-badge { display: none; }
            .form-grid { grid-template-columns: 1fr; }
            .form-section { padding: 18px 16px; }
            .form-footer { flex-direction: column; gap: 12px; align-items: stretch; }
            .btn-save { justify-content: center; }
            .footer-hint { justify-content: center; }
            .section-hint { display: none; }
        }
    </style>
</head>
<body>

{{-- Navbar --}}
<nav class="navbar">
    <div class="navbar-left">
        <a href="{{ route('menu.index') }}" class="btn-back">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
            </svg>
            Volver
        </a>
        <div class="nav-sep"></div>
        <span class="navbar-title">Datos personales</span>
    </div>
    <div class="navbar-user">
        <div class="user-chip">{{ strtoupper(substr(session('usuario.nick'), 0, 1)) }}</div>
        {{ session('usuario.nick') }}
    </div>
</nav>

{{-- Página --}}
<main class="page">

    {{-- Cabecera de perfil --}}
    <div class="profile-card">
        <div class="avatar">{{ strtoupper(substr(session('usuario.nick'), 0, 2)) }}</div>
        <div class="profile-info">
            <div class="profile-name">{{ session('usuario.nick') }}</div>
            <div class="profile-sub">Completá o actualizá tu información personal</div>
        </div>
        @if ($persona)
            <span class="status-badge status-completo">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                </svg>
                Datos cargados
            </span>
        @else
            <span class="status-badge status-incompleto">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                </svg>
                Sin datos
            </span>
        @endif
    </div>

    {{-- Alertas --}}
    @if (session('success'))
        <div class="alert alert-success">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-error">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
            </svg>
            {{ $errors->first() }}
        </div>
    @endif

    {{-- Formulario --}}
    @php $puedeEditar = session('permisos', [])['dat']['editar'] ?? false; @endphp

    <form @if($puedeEditar) method="POST" action="{{ route('personas.save') }}" @endif>
        @if($puedeEditar) @csrf @endif
        <div class="form-card">

            {{-- Identificación --}}
            <div class="form-section">
                <div class="section-head">
                    <div class="section-icon icon-id">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z"/>
                        </svg>
                    </div>
                    <span class="section-label">Identificación</span>
                    <span class="section-hint">Datos básicos de identidad</span>
                </div>
                <div class="form-grid">
                    <div class="field">
                        <label>Nombre</label>
                        <input type="text" name="nombre" value="{{ old('nombre', $persona->nombre ?? '') }}" placeholder="Ej: Juan" @unless($puedeEditar) readonly @endunless>
                    </div>
                    <div class="field">
                        <label>Apellido</label>
                        <input type="text" name="apellido" value="{{ old('apellido', $persona->apellido ?? '') }}" placeholder="Ej: Pérez" @unless($puedeEditar) readonly @endunless>
                    </div>
                    <div class="field">
                        <label>CI</label>
                        <input type="text" name="ci" value="{{ old('ci', $persona->ci ?? '') }}" placeholder="Ej: 12345678" @unless($puedeEditar) readonly @endunless>
                    </div>
                    <div class="field">
                        <label>Fecha de nacimiento</label>
                        <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento', $persona->fecha_nacimiento ?? '') }}" @unless($puedeEditar) readonly @endunless>
                    </div>
                </div>
            </div>

            {{-- Contacto --}}
            <div class="form-section">
                <div class="section-head">
                    <div class="section-icon icon-mail">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                        </svg>
                    </div>
                    <span class="section-label">Contacto</span>
                    <span class="section-hint">Información de contacto</span>
                </div>
                <div class="form-grid">
                    <div class="field full">
                        <label>Correo electrónico</label>
                        <input type="email" name="correo" value="{{ old('correo', $persona->correo ?? '') }}" placeholder="Ej: juan@correo.com" @unless($puedeEditar) readonly @endunless>
                    </div>
                </div>
            </div>

            {{-- Profesional --}}
            <div class="form-section">
                <div class="section-head">
                    <div class="section-icon icon-work">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z"/>
                        </svg>
                    </div>
                    <span class="section-label">Información profesional</span>
                    <span class="section-hint">Rol y formación</span>
                </div>
                <div class="form-grid">
                    <div class="field">
                        <label>Cargo</label>
                        <input type="text" name="cargo" value="{{ old('cargo', $persona->cargo ?? '') }}" placeholder="Ej: Gerente de sistemas" @unless($puedeEditar) readonly @endunless>
                    </div>
                    <div class="field">
                        <label>Título</label>
                        <input type="text" name="titulo" value="{{ old('titulo', $persona->titulo ?? '') }}" placeholder="Ej: Dr. Ing. Lic." @unless($puedeEditar) readonly @endunless>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            @if($puedeEditar)
            <div class="form-footer">
                <span class="footer-hint">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
                    </svg>
                    Todos los campos son opcionales
                </span>
                <button type="submit" class="btn-save">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Guardar cambios
                </button>
            </div>
            @else
            <div class="form-footer">
                <span class="footer-hint">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                    </svg>
                    Solo lectura — no tenés permiso para editar
                </span>
            </div>
            @endif

        </div>
    </form>

</main>

</body>
</html>
