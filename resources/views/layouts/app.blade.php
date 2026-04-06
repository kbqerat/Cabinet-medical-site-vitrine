<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediAssist — Logiciel de Gestion de Cabinet Médical</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

    {{-- Floating contact widget --}}
    <div class="fixed bottom-6 right-6 z-50 flex flex-col items-end gap-3"
         x-data="{
             open: false,
             view: 'menu',
             sending: false,
             sent: false,
             error: false,
             name: '', email: '', message: '',
             async sendEmail() {
                 this.sending = true;
                 this.error = false;
                 try {
                     const res = await fetch('/contact-widget', {
                         method: 'POST',
                         headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content },
                         body: JSON.stringify({ name: this.name, email: this.email, message: this.message })
                     });
                     if (res.ok) { this.sent = true; }
                     else { this.error = true; }
                 } catch { this.error = true; }
                 this.sending = false;
             }
         }">

        {{-- Panel --}}
        <div class="w-80 bg-white rounded-3xl shadow-2xl shadow-black/15 border border-gray-100 overflow-hidden"
             x-show="open"
             x-transition:enter="transition ease-out duration-250"
             x-transition:enter-start="opacity-0 translate-y-4 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 scale-95">

            {{-- Header panel --}}
            <div class="bg-gradient-to-br from-blue-600 to-indigo-700 px-5 py-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-white/15 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-white text-sm font-bold leading-none">Nous contacter</p>
                        <p class="text-blue-200 text-[11px] mt-0.5">Réponse rapide garantie</p>
                    </div>
                </div>
                <button @click="open = false; view = 'menu'; sent = false"
                        class="w-7 h-7 bg-white/10 hover:bg-white/20 rounded-lg flex items-center justify-center transition-colors">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Menu --}}
            <div x-show="view === 'menu'" class="p-4 space-y-3">
                <p class="text-xs text-gray-400 font-medium px-1">Choisissez votre moyen de contact</p>

                {{-- WhatsApp --}}
                <a href="https://wa.me/212721667521?text=Bonjour%2C%20je%20suis%20int%C3%A9ress%C3%A9%20par%20MediAssist%20et%20j%27aimerais%20en%20savoir%20plus."
                   target="_blank"
                   class="flex items-center gap-4 p-3.5 rounded-2xl border border-gray-100 hover:border-[#25D366]/30 hover:bg-[#25D366]/5 transition-all duration-200 group cursor-pointer">
                    <div class="w-11 h-11 bg-[#25D366] rounded-xl flex items-center justify-center shrink-0 shadow-sm group-hover:scale-105 transition-transform">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-800">WhatsApp</p>
                        <p class="text-xs text-gray-400">Réponse en quelques minutes</p>
                    </div>
                    <svg class="w-4 h-4 text-gray-300 group-hover:text-[#25D366] group-hover:translate-x-0.5 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>

                {{-- Email --}}
                <button @click="view = 'email'"
                        class="w-full flex items-center gap-4 p-3.5 rounded-2xl border border-gray-100 hover:border-blue-200 hover:bg-blue-50/50 transition-all duration-200 group text-left cursor-pointer">
                    <div class="w-11 h-11 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shrink-0 shadow-sm group-hover:scale-105 transition-transform">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-800">Email</p>
                        <p class="text-xs text-gray-400">Réponse sous 24h</p>
                    </div>
                    <svg class="w-4 h-4 text-gray-300 group-hover:text-blue-400 group-hover:translate-x-0.5 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>

            {{-- Formulaire email --}}
            <div x-show="view === 'email' && !sent" class="p-4">
                <button @click="view = 'menu'" class="flex items-center gap-1.5 text-xs text-gray-400 hover:text-gray-600 mb-4 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Retour
                </button>
                <div class="space-y-3">
                    <div>
                        <input x-model="name" type="text" placeholder="Votre nom"
                               class="w-full text-sm px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 outline-none transition-all placeholder-gray-400">
                    </div>
                    <div>
                        <input x-model="email" type="email" placeholder="Votre email"
                               class="w-full text-sm px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 outline-none transition-all placeholder-gray-400">
                    </div>
                    <div>
                        <textarea x-model="message" rows="3" placeholder="Votre message..."
                                  class="w-full text-sm px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 outline-none transition-all placeholder-gray-400 resize-none"></textarea>
                    </div>
                    <div x-show="error" class="text-xs text-red-500 bg-red-50 px-3 py-2 rounded-lg">
                        Une erreur est survenue. Réessayez.
                    </div>
                    <button @click="sendEmail()"
                            :disabled="sending || !name || !email || !message"
                            class="w-full bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed text-white text-sm font-semibold py-2.5 rounded-xl transition-all duration-200 flex items-center justify-center gap-2">
                        <svg x-show="sending" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                        </svg>
                        <span x-text="sending ? 'Envoi...' : 'Envoyer'"></span>
                    </button>
                </div>
            </div>

            {{-- Succès --}}
            <div x-show="sent" class="p-6 flex flex-col items-center text-center gap-3">
                <div class="w-14 h-14 bg-emerald-100 rounded-2xl flex items-center justify-center">
                    <svg class="w-7 h-7 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-800">Message envoyé !</p>
                    <p class="text-xs text-gray-400 mt-1">Nous vous répondrons sous 24h.</p>
                </div>
                <button @click="open = false; view = 'menu'; sent = false; name = ''; email = ''; message = ''"
                        class="text-xs text-blue-500 hover:text-blue-700 transition-colors font-medium">
                    Fermer
                </button>
            </div>
        </div>

        {{-- Bouton principal --}}
        <button @click="open = !open"
                class="w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40 transition-all duration-200 hover:scale-105 relative">
            <svg x-show="!open" x-transition:enter="transition duration-150" x-transition:enter-start="opacity-0 scale-75" x-transition:enter-end="opacity-100 scale-100" class="w-6 h-6 text-white absolute" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
            <svg x-show="open" x-transition:enter="transition duration-150" x-transition:enter-start="opacity-0 scale-75" x-transition:enter-end="opacity-100 scale-100" class="w-5 h-5 text-white absolute" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

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
