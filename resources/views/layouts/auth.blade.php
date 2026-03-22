<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'CeWy Auth')</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700|space-grotesk:500,600,700" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="auth-shell">
        <div class="auth-bg-grid" aria-hidden="true"></div>
        <div class="auth-glow auth-glow-a" aria-hidden="true"></div>
        <div class="auth-glow auth-glow-b" aria-hidden="true"></div>

        <main class="auth-page">
            <section class="auth-branding auth-entrance" data-stagger="1">
                <div class="auth-badge">CeWy</div>
                <h1 class="auth-brand-title">Gestiona tareas en equipo sin friccion.</h1>
                <p class="auth-brand-copy">
                    Un espacio visual y rapido para planear, ejecutar y entregar proyectos con tu equipo.
                </p>

                <div class="auth-feature-list">
                    <article class="auth-feature-card" data-stagger="2">
                        <h2>Kanban + Tabla</h2>
                        <p>Alterna de vista segun tu flujo, sin perder filtros ni contexto.</p>
                    </article>
                    <article class="auth-feature-card" data-stagger="3">
                        <h2>Colaboracion por roles</h2>
                        <p>Invita miembros y controla permisos por proyecto facilmente.</p>
                    </article>
                    <article class="auth-feature-card" data-stagger="4">
                        <h2>UX enfocada en productividad</h2>
                        <p>Interfaz clara, transiciones suaves y accesible en cualquier dispositivo.</p>
                    </article>
                </div>
            </section>

            <section class="auth-panel auth-entrance" data-stagger="2">
                @yield('content')
            </section>
        </main>
    </body>
</html>
