<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediAssist — Logiciel de Gestion de Cabinet Médical</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-gray-800 font-sans">

    {{-- Navbar --}}
    @include('components.navbar')

    {{-- Contenu principal --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('components.footer')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('a[data-scroll]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    const href = this.getAttribute('href');
                    if (!href || !href.startsWith('#')) return;
                    const target = document.querySelector(href);
                    if (!target) return;
                    e.preventDefault();
                    const navHeight = document.querySelector('nav')?.offsetHeight ?? 70;
                    const top = target.getBoundingClientRect().top + window.scrollY - navHeight - 12;
                    window.scrollTo({ top, behavior: 'smooth' });
                });
            });
        });
    </script>

</body>
</html>
