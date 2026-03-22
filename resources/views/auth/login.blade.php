@extends('layouts.auth')

@section('title', 'Iniciar sesion | CeWy')

@section('content')
    <header class="auth-panel-head">
        <p class="auth-kicker">Bienvenido de vuelta</p>
        <h2>Iniciar sesion</h2>
        <p class="auth-panel-copy">Accede con tu nombre de usuario o correo electronico.</p>
    </header>

    <form class="auth-form" action="#" method="POST" novalidate>
        @csrf

        <label class="auth-label" for="login_identity">Usuario o correo</label>
        <input
            class="auth-input"
            type="text"
            id="login_identity"
            name="identity"
            placeholder="usuario o correo@dominio.com"
            autocomplete="username"
            required
            data-stagger="3"
        >

        <label class="auth-label" for="login_password">Contrasena</label>
        <div class="auth-password-wrap" data-stagger="4">
            <input
                class="auth-input auth-input-password"
                type="password"
                id="login_password"
                name="password"
                placeholder="Tu contrasena"
                autocomplete="current-password"
                minlength="6"
                required
            >
            <button type="button" class="auth-password-toggle" data-toggle-password="login_password" aria-label="Mostrar u ocultar contrasena">
                Mostrar
            </button>
        </div>

        <button class="auth-btn" type="submit" data-loading-text="Entrando..." data-stagger="5">Entrar</button>
    </form>

    <footer class="auth-panel-foot" data-stagger="6">
        <p>¿Aun no tienes cuenta?</p>
        <a href="{{ route('register') }}">Crear cuenta</a>
    </footer>
@endsection
