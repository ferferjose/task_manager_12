@extends('layouts.auth')

@section('title', 'Registro | CeWy')

@section('content')
    <header class="auth-panel-head">
        <p class="auth-kicker">Empieza en minutos</p>
        <h2>Crear cuenta</h2>
        <p class="auth-panel-copy">Prepara tu espacio colaborativo y crea tu primer proyecto.</p>
    </header>

    <form class="auth-form" action="#" method="POST" novalidate>
        @csrf

        <div class="auth-grid" data-stagger="3">
            <div>
                <label class="auth-label" for="name">Nombre</label>
                <input class="auth-input" type="text" id="name" name="name" placeholder="Tu nombre" autocomplete="given-name" required>
            </div>

            <div>
                <label class="auth-label" for="surname">Apellidos</label>
                <input class="auth-input" type="text" id="surname" name="surname" placeholder="Tus apellidos" autocomplete="family-name" required>
            </div>
        </div>

        <label class="auth-label" for="email">Correo electronico</label>
        <input class="auth-input" type="email" id="email" name="email" placeholder="correo@dominio.com" autocomplete="email" required data-stagger="4">

        <label class="auth-label" for="username">Nombre de usuario</label>
        <input class="auth-input" type="text" id="username" name="username" placeholder="usuario_unico" autocomplete="username" required data-stagger="5">

        <label class="auth-label" for="register_password">Contrasena</label>
        <div class="auth-password-wrap" data-stagger="6">
            <input
                class="auth-input auth-input-password"
                type="password"
                id="register_password"
                name="password"
                placeholder="Minimo 6 caracteres"
                autocomplete="new-password"
                minlength="6"
                required
            >
            <button type="button" class="auth-password-toggle" data-toggle-password="register_password" aria-label="Mostrar u ocultar contrasena">
                Mostrar
            </button>
        </div>

        <p class="auth-hint" data-stagger="7">Recomendacion: usa mayusculas, minusculas, numeros y simbolos para una cuenta mas segura.</p>

        <button class="auth-btn" type="submit" data-loading-text="Creando cuenta..." data-stagger="8">Crear cuenta</button>
    </form>

    <footer class="auth-panel-foot" data-stagger="9">
        <p>¿Ya tienes cuenta?</p>
        <a href="{{ route('login') }}">Iniciar sesion</a>
    </footer>
@endsection
