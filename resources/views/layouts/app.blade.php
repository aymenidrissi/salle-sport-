<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name', 'Athleticore'))</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="relative min-h-screen overflow-x-hidden bg-[#0a0b0d] font-sans text-zinc-100 antialiased">
    <div
        class="pointer-events-none fixed inset-0 z-0 bg-cover bg-fixed bg-center bg-no-repeat"
        style="background-color: #0a0b0d; background-image: linear-gradient(rgba(10, 11, 13, 0.48), rgba(10, 11, 13, 0.55)), url('{{ asset('images/body-bg.png') }}');"
        aria-hidden="true"
    ></div>

    <div class="relative z-10 flex min-h-screen flex-col">
        <div id="header-spacer" class="shrink-0" style="min-height: 12rem" aria-hidden="true"></div>

        <header
            id="site-header"
            class="fixed top-0 left-0 right-0 z-50 w-full border-b border-white/5 bg-[#0a0b0d]/80 backdrop-blur-md transition-transform duration-300 ease-out will-change-transform translate-y-0"
        >
            <div class="relative w-full">
                <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-[20px] lg:px-6">
                    <a href="{{ route('client.home') }}" class="inline-flex shrink-0 items-center">
                        <img
                            src="{{ asset('images/logo-athleticore.png') }}"
                            alt="Athleticore"
                            class="h-[150px] w-auto object-contain"
                            loading="eager"
                        >
                    </a>

                    <nav class="hidden items-center gap-6 text-[25px] font-medium text-zinc-300 lg:flex lg:gap-8">
                        <a href="{{ route('client.home') }}" class="transition hover:text-white">Accueil</a>
                        <a href="{{ route('client.dashboard') }}" class="transition hover:text-white">Tableau de bord</a>
                        <a href="{{ route('client.programs.index') }}" class="transition hover:text-white">Programmes</a>
                        <a href="{{ route('client.profile') }}" class="transition hover:text-white">Profil</a>
                    </nav>

                    <div class="flex items-center gap-2 sm:gap-3">
                        <button
                            id="mobileMenuBtn"
                            type="button"
                            class="rounded-lg p-2 text-zinc-400 transition hover:bg-white/5 hover:text-white lg:hidden"
                            aria-label="Ouvrir le menu"
                            aria-controls="mobileMenuPanel"
                            aria-expanded="false"
                        >
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>

                        <div id="searchDropdownWrap" class="relative">
                            <button
                                id="searchIconBtn"
                                type="button"
                                class="rounded-lg p-2 text-zinc-400 transition hover:bg-white/5 hover:text-white"
                                aria-label="Rechercher des programmes"
                                aria-haspopup="true"
                                aria-expanded="false"
                            >
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </button>

                            <div class="absolute right-0 top-full z-50 pt-2">
                                <div
                                    id="searchDropdown"
                                    class="hidden w-[22rem] overflow-hidden rounded-2xl border border-white/10 bg-[#0a0b0d] shadow-2xl"
                                    role="dialog"
                                    aria-labelledby="searchIconBtn"
                                >
                                    <div class="border-b border-white/10 px-4 py-3">
                                        <p class="text-sm font-semibold text-white">Rechercher un programme</p>
                                        <input
                                            id="searchProgramInput"
                                            type="text"
                                            placeholder="Tapez des lettres... ex: déb, fem, musc"
                                            class="mt-3 w-full rounded-xl border border-white/10 bg-white/5 px-3 py-2 text-sm text-white placeholder:text-zinc-500 focus:border-[#a3ff12]/50 focus:outline-none"
                                        >
                                    </div>
                                    <div id="searchResultsBody" class="max-h-80 overflow-auto px-4 py-3"></div>
                                </div>
                            </div>
                        </div>

                        <div id="cartDropdownWrap" class="relative">
                            <button
                                id="cartIconBtn"
                                type="button"
                                class="relative rounded-lg p-2 text-zinc-400 transition hover:bg-white/5 hover:text-white"
                                aria-label="Panier"
                                aria-haspopup="true"
                                aria-expanded="false"
                            >
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-2 9h14l-2-9M10 17h4"/>
                                </svg>
                                <span
                                    id="cartCountBadge"
                                    class="absolute right-1.5 top-1.5 hidden h-2 w-2 rounded-full bg-[#a3ff12] ring-2 ring-[#0a0b0d]"
                                ></span>
                            </button>

                            <div class="absolute right-0 top-full z-50 pt-2">
                                <div
                                    id="cartDropdown"
                                    class="hidden w-80 overflow-hidden rounded-2xl border border-white/10 bg-[#0a0b0d] shadow-2xl"
                                    role="dialog"
                                    aria-labelledby="cartIconBtn"
                                >
                                    <div class="flex items-center justify-between gap-4 border-b border-white/10 px-4 py-3">
                                        <p class="text-sm font-semibold text-white">Panier</p>
                                        <a href="{{ route('client.cart') }}" class="text-xs font-semibold text-zinc-400 hover:text-white">Voir</a>
                                    </div>

                                    <div id="cartDropdownBody" class="max-h-72 overflow-auto px-4 py-4"></div>

                                    <div class="border-t border-white/10 px-4 py-3">
                                        <div class="flex items-center justify-between">
                                            <p class="text-xs font-semibold text-zinc-400">Sous-total</p>
                                            <p id="cartSubtotalValue" class="text-sm font-extrabold text-white">0,00 DH</p>
                                        </div>

                                        <div class="mt-3 grid gap-2">
                                            <a href="{{ route('client.cart') }}" class="inline-flex justify-center rounded-xl bg-[#e63946] px-4 py-2 text-xs font-semibold text-white hover:bg-[#d62f3c]">
                                                Voir le panier
                                            </a>
                                            <a href="{{ route('client.checkout') }}" class="inline-flex justify-center rounded-xl border border-white/10 bg-white/5 px-4 py-2 text-xs font-semibold text-white hover:bg-white/10">
                                                Paiement
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @auth
                            <div class="flex items-center gap-2">
                                <div class="relative">
                                    <button
                                        id="profileDropdownBtn"
                                        type="button"
                                        class="h-9 w-9 overflow-hidden rounded-full ring-2 ring-white/10 transition hover:ring-[#a3ff12]/50"
                                        title="Profil"
                                        aria-haspopup="true"
                                        aria-expanded="false"
                                    >
                                        @if (auth()->user()->photo)
                                            <img
                                                src="{{ asset('storage/'.auth()->user()->photo) }}"
                                                alt="Photo de profil"
                                                class="h-full w-full object-cover"
                                                loading="lazy"
                                            >
                                        @else
                                            <span class="flex h-full w-full items-center justify-center bg-gradient-to-br from-zinc-600 to-zinc-800 text-xs font-semibold text-white">
                                                {{ strtoupper(substr(auth()->user()->name ?? '?', 0, 1)) }}
                                            </span>
                                        @endif
                                    </button>

                                    <div
                                        id="profileDropdown"
                                        class="hidden absolute right-0 top-12 w-72 overflow-hidden rounded-2xl border border-white/10 bg-[#0a0b0d] shadow-2xl"
                                        role="menu"
                                        aria-labelledby="profileDropdownBtn"
                                    >
                                        <div class="p-4">
                                            <div class="flex items-center gap-3">
                                                <div class="h-11 w-11 overflow-hidden rounded-full border border-white/10 bg-white/5">
                                                    @if (auth()->user()->photo)
                                                        <img
                                                            src="{{ asset('storage/'.auth()->user()->photo) }}"
                                                            alt="Photo de profil"
                                                            class="h-full w-full object-cover"
                                                            loading="lazy"
                                                        >
                                                    @else
                                                        <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-zinc-600 to-zinc-800 text-xs font-semibold text-white">
                                                            {{ strtoupper(substr(auth()->user()->name ?? '?', 0, 1)) }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="min-w-0 flex-1">
                                                    <p class="truncate text-sm font-semibold text-white">{{ auth()->user()->name }}</p>
                                                    <p class="truncate text-xs text-zinc-400">{{ auth()->user()->email }}</p>
                                                    <p class="mt-1 text-xs text-zinc-400">
                                                        Âge : <span class="font-semibold text-zinc-200">{{ auth()->user()->age ?? '—' }}</span>
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="mt-4">
                                                <a
                                                    href="{{ route('client.profile') }}"
                                                    class="block rounded-xl bg-white/5 px-3 py-2 text-center text-xs font-semibold text-white ring-1 ring-white/10 hover:bg-white/10"
                                                >
                                                    Mon compte
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="hidden rounded-xl px-3 py-2 text-sm font-semibold text-zinc-200 transition hover:bg-white/5 hover:text-white sm:block">
                                        Déconnexion
                                    </button>
                                    <button type="submit" class="sm:hidden rounded-xl p-2 text-zinc-200 transition hover:bg-white/5 hover:text-white" aria-label="Déconnexion" title="Déconnexion">
                                        <span class="text-lg leading-none">↩</span>
                                    </button>
                                </form>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="flex h-9 w-9 items-center justify-center rounded-full bg-zinc-800 text-xs font-semibold text-zinc-400 ring-2 ring-white/10 transition hover:text-[#a3ff12] hover:ring-[#a3ff12]/40" title="Connexion">?</a>
                        @endauth
                    </div>
                </div>

                <div id="mobileMenuPanel" class="absolute left-0 right-0 top-full z-40 hidden border-t border-white/5 bg-[#0a0b0d]/95 px-4 py-3 shadow-xl lg:hidden">
                    <nav class="grid gap-1 text-sm font-semibold text-zinc-200">
                        <a href="{{ route('client.home') }}" class="rounded-lg px-3 py-2 transition hover:bg-white/5 hover:text-white">Accueil</a>
                        <a href="{{ route('client.dashboard') }}" class="rounded-lg px-3 py-2 transition hover:bg-white/5 hover:text-white">Tableau de bord</a>
                        <a href="{{ route('client.programs.index') }}" class="rounded-lg px-3 py-2 transition hover:bg-white/5 hover:text-white">Programmes</a>
                        <a href="{{ route('client.profile') }}" class="rounded-lg px-3 py-2 transition hover:bg-white/5 hover:text-white">Profil</a>
                    </nav>
                </div>
            </div>
        </header>

        <script>
            (function () {
                var header = document.getElementById('site-header');
                var spacer = document.getElementById('header-spacer');
                var mobilePanel = document.getElementById('mobileMenuPanel');

                function updateSpacer() {
                    if (header && spacer) {
                        spacer.style.height = header.offsetHeight + 'px';
                        spacer.style.minHeight = '';
                    }
                }

                if (header && spacer) {
                    updateSpacer();
                    if (typeof ResizeObserver !== 'undefined') {
                        new ResizeObserver(updateSpacer).observe(header);
                    }
                    window.addEventListener('resize', updateSpacer);
                }

                if (!header) return;

                var lastY = window.scrollY || 0;
                var threshold = 8;
                var hideAfter = 80;
                var ticking = false;

                function isMobileMenuOpen() {
                    return mobilePanel && !mobilePanel.classList.contains('hidden');
                }

                function showHeader() {
                    header.classList.remove('-translate-y-full');
                    header.classList.add('translate-y-0');
                }

                function hideHeader() {
                    header.classList.add('-translate-y-full');
                    header.classList.remove('translate-y-0');
                }

                function onScroll() {
                    ticking = false;
                    var y = window.scrollY || 0;

                    if (isMobileMenuOpen()) {
                        lastY = y;
                        showHeader();
                        return;
                    }

                    if (y < threshold) {
                        showHeader();
                    } else if (y > lastY && y > hideAfter) {
                        hideHeader();
                    } else if (y < lastY) {
                        showHeader();
                    }

                    lastY = y;
                }

                window.addEventListener(
                    'scroll',
                    function () {
                        if (!ticking) {
                            window.requestAnimationFrame(onScroll);
                            ticking = true;
                        }
                    },
                    { passive: true }
                );
            })();
        </script>

        <main class="flex-1">
            @if (session('warning'))
                <div class="mx-auto max-w-3xl px-4 pt-6">
                    <div class="rounded-xl border border-amber-500/35 bg-amber-500/10 px-4 py-3 text-sm text-amber-100 shadow-sm">
                        {{ session('warning') }}
                    </div>
                </div>
            @endif
            @yield('content')
        </main>

        <footer class="mt-auto border-t border-zinc-200 bg-white text-zinc-800">
            <div class="mx-auto max-w-7xl px-4 py-12 lg:px-6">
                <div class="grid gap-10 md:grid-cols-3 md:gap-8">
                    <div>
                        <a href="{{ route('client.home') }}" class="inline-flex items-center">
                            <img
                                src="{{ asset('images/logo-athleticore.png') }}"
                                alt="Athleticore"
                                class="h-[150px] w-auto object-contain"
                                loading="lazy"
                            >
                        </a>
                    </div>
                    <nav class="flex flex-col gap-2 text-sm" aria-label="Liens pied de page">
                        <a href="{{ route('client.home') }}" class="hover:text-[#a3ff12]">Accueil</a>
                        <a href="{{ route('client.about') }}" class="hover:text-[#a3ff12]">À propos</a>
                        <a href="{{ route('client.contact') }}" class="hover:text-[#a3ff12]">Nous contacter</a>
                        <a href="{{ route('client.programs.index') }}" class="hover:text-[#a3ff12]">Programmes sportifs</a>
                        <a href="{{ route('client.dashboard') }}" class="hover:text-[#a3ff12]">Mon espace</a>
                        <a href="{{ route('login') }}" class="hover:text-[#a3ff12]">Connexion</a>
                    </nav>
                    <div class="text-sm leading-relaxed text-zinc-600">
                        <p>
                            <strong class="text-zinc-900">Athleticore</strong> est une plateforme dédiée aux programmes de sport en ligne,
                            pensée pour vous accompagner avec des contenus structurés, des vidéos et un suivi de progression.
                        </p>
                    </div>
                </div>
            </div>
            <div class="border-t border-zinc-200 bg-zinc-50/80">
                <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-2 px-4 py-4 text-xs text-zinc-500 sm:flex-row lg:px-6">
                    <p>Copyright © {{ date('Y') }} Athleticore</p>
                    <p class="hidden sm:block">Propulsé par Athleticore</p>
                </div>
            </div>
        </footer>
    </div>

    @auth
        <script>
            (function () {
                var btn = document.getElementById('profileDropdownBtn');
                var menu = document.getElementById('profileDropdown');
                if (!btn || !menu) return;

                function hide() {
                    menu.classList.add('hidden');
                    btn.setAttribute('aria-expanded', 'false');
                }

                function toggle() {
                    if (menu.classList.contains('hidden')) {
                        menu.classList.remove('hidden');
                        btn.setAttribute('aria-expanded', 'true');
                    } else {
                        hide();
                    }
                }

                btn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    toggle();
                });

                document.addEventListener('click', function () {
                    hide();
                });

                menu.addEventListener('click', function (e) {
                    e.stopPropagation();
                });
            })();
        </script>
    @endauth

    <script>
        (function () {
            var btn = document.getElementById('mobileMenuBtn');
            var panel = document.getElementById('mobileMenuPanel');
            if (!btn || !panel) return;

            function closeMenu() {
                panel.classList.add('hidden');
                btn.setAttribute('aria-expanded', 'false');
            }

            btn.addEventListener('click', function (e) {
                e.stopPropagation();
                var isHidden = panel.classList.contains('hidden');
                if (isHidden) {
                    panel.classList.remove('hidden');
                    btn.setAttribute('aria-expanded', 'true');
                } else {
                    closeMenu();
                }
            });

            document.addEventListener('click', function (e) {
                if (!panel.contains(e.target) && !btn.contains(e.target)) closeMenu();
            });

            panel.querySelectorAll('a').forEach(function (link) {
                link.addEventListener('click', closeMenu);
            });
        })();
    </script>

    @php
        $searchPrograms = \App\Models\Program::query()
            ->orderBy('title')
            ->get(['slug', 'title', 'price', 'image'])
            ->map(function ($p) {
                return [
                    'slug' => (string) $p->slug,
                    'title' => (string) $p->title,
                    'price' => (float) ($p->price ?? 0),
                    'image' => $p->image
                        ? (\Illuminate\Support\Str::startsWith($p->image, ['http://', 'https://']) ? $p->image : asset('storage/'.$p->image))
                        : '',
                ];
            })
            ->values();
    @endphp

    <script>
        (function () {
            var wrap = document.getElementById('searchDropdownWrap');
            var btn = document.getElementById('searchIconBtn');
            var dropdown = document.getElementById('searchDropdown');
            var input = document.getElementById('searchProgramInput');
            var body = document.getElementById('searchResultsBody');
            var productBaseUrl = "{{ url('/produit') }}";
            var programs = @json($searchPrograms);

            if (!wrap || !btn || !dropdown || !input || !body) return;

            function escapeHtml(str) {
                return String(str)
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#039;');
            }

            function formatDH(amount) {
                var n = Number(amount || 0);
                return (Math.round(n * 100) / 100).toFixed(2).replace('.', ',') + ' DH';
            }

            function show() {
                dropdown.classList.remove('hidden');
                btn.setAttribute('aria-expanded', 'true');
            }

            function hide() {
                dropdown.classList.add('hidden');
                btn.setAttribute('aria-expanded', 'false');
            }

            function renderResults() {
                var q = String(input.value || '').trim().toLowerCase();
                var filtered = programs.filter(function (p) {
                    var title = String(p.title || '').toLowerCase();
                    var slug = String(p.slug || '').toLowerCase();
                    return q === '' || title.indexOf(q) !== -1 || slug.indexOf(q) !== -1;
                });

                if (filtered.length === 0) {
                    body.innerHTML = '<p class="py-3 text-center text-xs text-zinc-400">Aucun programme trouvé.</p>';
                    return;
                }

                var html = '<div class="space-y-2">';
                filtered.slice(0, 12).forEach(function (p) {
                    var title = escapeHtml(p.title || 'Programme');
                    var price = formatDH(p.price || 0);
                    var image = escapeHtml(p.image || '');
                    var href = productBaseUrl + '/' + encodeURIComponent(String(p.slug || ''));

                    html +=
                        '<a href="' + href + '" class="flex items-center gap-3 rounded-xl border border-white/10 bg-white/5 p-2.5 transition hover:bg-white/10">' +
                        (image
                            ? '<img src="' + image + '" alt="" class="h-11 w-11 rounded-lg object-cover" />'
                            : '<div class="h-11 w-11 rounded-lg bg-white/5"></div>') +
                        '<div class="min-w-0 flex-1">' +
                        '<p class="truncate text-xs font-bold text-white">' + title + '</p>' +
                        '<p class="mt-0.5 text-[11px] font-semibold text-zinc-300">' + price + '</p>' +
                        '</div>' +
                        '</a>';
                });
                html += '</div>';
                body.innerHTML = html;
            }

            btn.addEventListener('click', function (e) {
                e.stopPropagation();
                if (dropdown.classList.contains('hidden')) {
                    show();
                    renderResults();
                    input.focus();
                } else {
                    hide();
                }
            });

            wrap.addEventListener('mouseenter', function () {
                show();
                renderResults();
            });
            wrap.addEventListener('mouseleave', function () {
                hide();
            });

            input.addEventListener('input', renderResults);
            dropdown.addEventListener('click', function (e) {
                e.stopPropagation();
            });

            document.addEventListener('click', function (e) {
                if (!wrap.contains(e.target)) hide();
            });
        })();
    </script>

    <script>
        (function () {
            var KEY = 'athleticore_cart_v1';

            function loadCart() {
                try {
                    var raw = window.localStorage.getItem(KEY);
                    if (!raw) return { items: {} };
                    var parsed = JSON.parse(raw);
                    if (!parsed || typeof parsed !== 'object' || !parsed.items) return { items: {} };
                    return parsed;
                } catch (e) {
                    return { items: {} };
                }
            }

            function saveCart(cart) {
                try {
                    window.localStorage.setItem(KEY, JSON.stringify(cart));
                } catch (e) {}
            }

            function escapeHtml(str) {
                return String(str)
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#039;');
            }

            function formatDH(amount) {
                var n = Number(amount || 0);
                return (Math.round(n * 100) / 100).toFixed(2).replace('.', ',') + ' DH';
            }

            function subtotal(cart) {
                var s = 0;
                Object.keys(cart.items || {}).forEach(function (slug) {
                    var it = cart.items[slug] || {};
                    s += Number(it.price || 0) * Number(it.qty || 0);
                });
                return s;
            }

            function addToCart(slug, title, price, image) {
                var cart = loadCart();
                if (!cart.items) cart.items = {};
                var s = String(slug || '');
                if (!s) return;
                if (!cart.items[s]) {
                    cart.items[s] = { title: title || 'Programme', price: Number(price || 0), qty: 1, image: image || '' };
                } else {
                    cart.items[s].qty = Number(cart.items[s].qty || 0) + 1;
                }
                saveCart(cart);
                renderCartUi();
            }

            function renderCartUi() {
                var cart = loadCart();
                var items = cart.items || {};
                var keys = Object.keys(items);
                var body = document.getElementById('cartDropdownBody');
                var subEl = document.getElementById('cartSubtotalValue');
                var badge = document.getElementById('cartCountBadge');

                if (body) {
                    if (keys.length === 0) {
                        body.innerHTML =
                            '<div class="flex flex-col items-center gap-3 py-6 text-center">' +
                            '<img src="{{ asset('images/panier-1.png') }}" alt="" class="mx-auto h-24 w-auto object-contain opacity-90" />' +
                            '<p class="text-xs text-zinc-400">Votre panier est vide.</p>' +
                            '</div>';
                    } else {
                        var html = '<div class="space-y-3">';
                        keys.forEach(function (slug) {
                            var it = items[slug] || {};
                            var title = escapeHtml(it.title || 'Programme');
                            var image = escapeHtml(it.image || '');
                            var price = formatDH(it.price || 0);
                            var qty = Number(it.qty || 1);
                            html +=
                                '<div class="flex items-start gap-3 rounded-xl border border-white/10 bg-white/5 p-2.5">' +
                                (image
                                    ? '<img src="' + image + '" alt="" class="h-12 w-12 shrink-0 rounded-lg object-cover" />'
                                    : '<div class="h-12 w-12 shrink-0 rounded-lg bg-white/5"></div>') +
                                '<div class="min-w-0 flex-1">' +
                                '<p class="truncate text-xs font-bold text-white">' + title + '</p>' +
                                '<p class="mt-0.5 text-[11px] font-semibold text-zinc-300">' + price + ' × ' + qty + '</p>' +
                                '<div class="mt-2 flex flex-wrap gap-2">' +
                                '<button type="button" data-action="dec" data-slug="' + escapeHtml(slug) + '" class="rounded-md border border-white/10 bg-white/5 px-2 py-1 text-[11px] font-bold text-white hover:bg-white/10">-</button>' +
                                '<button type="button" data-action="inc" data-slug="' + escapeHtml(slug) + '" class="rounded-md border border-white/10 bg-white/5 px-2 py-1 text-[11px] font-bold text-white hover:bg-white/10">+</button>' +
                                '<button type="button" data-action="remove" data-slug="' + escapeHtml(slug) + '" class="text-[11px] font-bold text-[#e63946] hover:underline">Retirer</button>' +
                                '</div></div></div>';
                        });
                        html += '</div>';
                        body.innerHTML = html;
                    }
                }

                if (subEl) subEl.textContent = formatDH(subtotal(cart));
                if (badge) {
                    if (keys.length > 0) badge.classList.remove('hidden');
                    else badge.classList.add('hidden');
                }
            }

            document.addEventListener('click', function (e) {
                var t = e.target;
                if (!t || !t.closest) return;
                var btn = t.closest('.add-to-cart');
                if (!btn) return;
                e.preventDefault();
                addToCart(
                    btn.getAttribute('data-slug'),
                    btn.getAttribute('data-title'),
                    btn.getAttribute('data-price'),
                    btn.getAttribute('data-image')
                );
            });

            var cartBody = document.getElementById('cartDropdownBody');
            if (cartBody) {
                cartBody.addEventListener('click', function (e) {
                    var t = e.target;
                    if (!t || !t.getAttribute) return;
                    var action = t.getAttribute('data-action');
                    var slug = t.getAttribute('data-slug');
                    if (!action || !slug) return;
                    e.preventDefault();
                    var cart = loadCart();
                    if (!cart.items || !cart.items[slug]) return;
                    if (action === 'remove') {
                        delete cart.items[slug];
                    } else if (action === 'inc') {
                        cart.items[slug].qty = Number(cart.items[slug].qty || 0) + 1;
                    } else if (action === 'dec') {
                        cart.items[slug].qty = Number(cart.items[slug].qty || 0) - 1;
                        if (cart.items[slug].qty <= 0) delete cart.items[slug];
                    }
                    saveCart(cart);
                    renderCartUi();
                });
            }

            var wrap = document.getElementById('cartDropdownWrap');
            var cbtn = document.getElementById('cartIconBtn');
            var cdrop = document.getElementById('cartDropdown');
            if (wrap && cbtn && cdrop) {
                wrap.addEventListener('mouseenter', function () {
                    cdrop.classList.remove('hidden');
                    cbtn.setAttribute('aria-expanded', 'true');
                    renderCartUi();
                });
                wrap.addEventListener('mouseleave', function () {
                    cdrop.classList.add('hidden');
                    cbtn.setAttribute('aria-expanded', 'false');
                });
            }

            renderCartUi();
            window.addEventListener('storage', function (e) {
                if (e.key === KEY) renderCartUi();
            });
        })();
    </script>
</body>
</html>
