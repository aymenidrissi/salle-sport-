@extends('layouts.app')

@section('title', 'Panier — Athleticore')

@section('content')
    <div class="mx-auto max-w-6xl px-4 py-10 sm:py-12">
        <div class="text-center">
            <h1 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">Panier</h1>
        </div>

        <div class="mt-10 grid gap-8 lg:grid-cols-12">
            <section class="lg:col-span-8">
                <div class="overflow-hidden rounded-2xl border border-white/10 bg-white">
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[640px] text-left text-sm text-zinc-700">
                            <thead class="bg-zinc-50 text-xs font-bold uppercase tracking-wide text-zinc-500">
                                <tr>
                                    <th class="px-5 py-4">Produit</th>
                                    <th class="px-5 py-4">Prix</th>
                                    <th class="px-5 py-4">Quantité</th>
                                    <th class="px-5 py-4 text-right">Sous-total</th>
                                </tr>
                            </thead>
                            <tbody id="cartPageRows" class="divide-y divide-zinc-100 bg-white"></tbody>
                        </table>
                    </div>

                    <div class="flex flex-col gap-3 border-t border-zinc-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex flex-wrap items-center gap-2">
                            <button
                                id="cartResetBtn"
                                type="button"
                                class="inline-flex items-center justify-center rounded-md border border-zinc-200 bg-white px-4 py-2 text-xs font-bold text-zinc-700 transition hover:bg-zinc-50"
                            >
                                Reset
                            </button>
                            <button
                                id="cartUpdateBtn"
                                type="button"
                                class="inline-flex items-center justify-center rounded-md bg-[#e63946] px-4 py-2 text-xs font-bold text-white transition hover:bg-[#d62f3c]"
                            >
                                Mettre à jour
                            </button>
                        </div>

                        <a
                            href="{{ route('client.programs.index') }}"
                            class="inline-flex items-center justify-center rounded-md border border-zinc-200 bg-white px-4 py-2 text-xs font-bold text-zinc-700 transition hover:bg-zinc-50"
                        >
                            Continuer mes achats
                        </a>
                    </div>
                </div>

                <div class="mt-8 overflow-hidden rounded-2xl border border-white/10 bg-white">
                    <div class="border-b border-zinc-100 px-5 py-4">
                        <p class="text-sm font-extrabold text-zinc-900">Tu pourrais aussi aimer</p>
                        <p class="mt-1 text-xs text-zinc-500">Ajoute un autre programme en 1 clic.</p>
                    </div>
                    <div class="grid gap-4 p-5 sm:grid-cols-2">
                        @php
                            $recommended = \App\Models\Program::query()->orderBy('id')->take(2)->get();
                        @endphp
                        @foreach ($recommended as $p)
                            @php
                                $img = $p->image ? asset('storage/'.$p->image) : null;
                            @endphp
                            <div class="flex gap-4 rounded-xl border border-zinc-100 bg-white p-4">
                                <div class="h-20 w-20 overflow-hidden rounded-lg bg-zinc-100">
                                    @if ($img)
                                        <img src="{{ $img }}" alt="" class="h-full w-full object-cover" loading="lazy">
                                    @endif
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-sm font-extrabold text-zinc-900">{{ $p->title }}</p>
                                    <p class="mt-1 text-xs font-bold text-zinc-600">
                                        {{ number_format((float) ($p->price ?? 0), 2, ',', ' ') }} DH
                                    </p>
                                    <div class="mt-3 flex flex-wrap gap-2">
                                        <a
                                            href="{{ route('client.product.show', $p) }}"
                                            class="inline-flex items-center justify-center rounded-md border border-zinc-200 bg-white px-3 py-1.5 text-[11px] font-bold text-zinc-700 hover:bg-zinc-50"
                                        >
                                            Voir
                                        </a>
                                        <button
                                            type="button"
                                            class="add-to-cart inline-flex items-center justify-center rounded-md bg-[#e63946] px-3 py-1.5 text-[11px] font-bold text-white hover:bg-[#d62f3c]"
                                            data-slug="{{ $p->slug }}"
                                            data-title="{{ $p->title }}"
                                            data-price="{{ $p->price ?? 0 }}"
                                            data-image="{{ (string) ($img ?? '') }}"
                                        >
                                            Add to cart
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>

            <aside class="lg:col-span-4">
                <div class="sticky top-24 overflow-hidden rounded-2xl border border-white/10 bg-white">
                    <div class="border-b border-zinc-100 px-5 py-4">
                        <p class="text-sm font-extrabold text-zinc-900">Cart Totals</p>
                    </div>
                    <div class="space-y-4 px-5 py-5 text-sm text-zinc-700">
                        <div class="flex items-center justify-between">
                            <span class="font-semibold text-zinc-600">Subtotal</span>
                            <span id="cartPageSubtotal" class="font-extrabold text-zinc-900">0,00 DH</span>
                        </div>
                        <div class="h-px bg-zinc-100"></div>
                        <div class="flex items-center justify-between">
                            <span class="font-semibold text-zinc-600">Total</span>
                            <span id="cartPageTotal" class="font-extrabold text-zinc-900">0,00 DH</span>
                        </div>

                        <a
                            href="{{ route('client.checkout') }}"
                            class="mt-2 inline-flex w-full justify-center rounded-md bg-[#e63946] px-4 py-3 text-xs font-extrabold text-white hover:bg-[#d62f3c]"
                        >
                            Proceed to checkout
                        </a>
                        <p class="text-[11px] leading-relaxed text-zinc-500">
                            Paiement non branché pour le moment (panier côté navigateur).
                        </p>
                    </div>
                </div>
            </aside>
        </div>
    </div>

    <script>
        (function () {
            var KEY = 'athleticore_cart_v1';
            var rows = document.getElementById('cartPageRows');
            var subtotalEl = document.getElementById('cartPageSubtotal');
            var totalEl = document.getElementById('cartPageTotal');
            var resetBtn = document.getElementById('cartResetBtn');
            var updateBtn = document.getElementById('cartUpdateBtn');

            if (!rows || !subtotalEl || !totalEl || !resetBtn || !updateBtn) return;

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

            function setQty(slug, qty) {
                var cart = loadCart();
                if (!cart.items || !cart.items[slug]) return;
                var n = Number(qty || 0);
                if (isNaN(n) || n <= 0) {
                    delete cart.items[slug];
                } else {
                    cart.items[slug].qty = Math.floor(n);
                }
                saveCart(cart);
            }

            function render() {
                var cart = loadCart();
                var items = cart.items || {};
                var keys = Object.keys(items);

                if (keys.length === 0) {
                    rows.innerHTML =
                        '<tr>' +
                        '<td class="px-5 py-8 text-center text-zinc-500" colspan="4">' +
                        'Votre panier est vide. Ajoutez un programme depuis la page Programmes.' +
                        '</td>' +
                        '</tr>';
                    subtotalEl.textContent = '0,00 DH';
                    totalEl.textContent = '0,00 DH';
                    return;
                }

                var html = '';
                keys.forEach(function (slug) {
                    var it = items[slug] || {};
                    var title = escapeHtml(it.title || 'Programme');
                    var image = escapeHtml(it.image || '');
                    var price = Number(it.price || 0);
                    var qty = Number(it.qty || 1);
                    var rowSubtotal = price * qty;

                    html +=
                        '<tr>' +
                        '<td class="px-5 py-4">' +
                        '<div class="flex items-center gap-3">' +
                        (image
                            ? '<img src="' + image + '" alt="" class="h-12 w-12 rounded-md object-cover" />'
                            : '<div class="h-12 w-12 rounded-md bg-zinc-100"></div>') +
                        '<div class="min-w-0">' +
                        '<div class="truncate font-bold text-zinc-900">' + title + '</div>' +
                        '<button type="button" data-action="remove" data-slug="' + escapeHtml(slug) + '" class="mt-1 text-[11px] font-bold text-[#e63946] hover:underline">Supprimer</button>' +
                        '</div>' +
                        '</div>' +
                        '</td>' +
                        '<td class="px-5 py-4 font-bold text-zinc-900">' + formatDH(price) + '</td>' +
                        '<td class="px-5 py-4">' +
                        '<div class="inline-flex items-center overflow-hidden rounded-md border border-zinc-200">' +
                        '<button type="button" data-action="dec" data-slug="' + escapeHtml(slug) + '" class="px-3 py-2 text-xs font-extrabold text-zinc-700 hover:bg-zinc-50">-</button>' +
                        '<input data-qty-input="1" data-slug="' + escapeHtml(slug) + '" value="' + escapeHtml(qty) + '" class="w-14 border-x border-zinc-200 px-2 py-2 text-center text-xs font-bold text-zinc-800 outline-none" />' +
                        '<button type="button" data-action="inc" data-slug="' + escapeHtml(slug) + '" class="px-3 py-2 text-xs font-extrabold text-zinc-700 hover:bg-zinc-50">+</button>' +
                        '</div>' +
                        '</td>' +
                        '<td class="px-5 py-4 text-right font-extrabold text-zinc-900">' + formatDH(rowSubtotal) + '</td>' +
                        '</tr>';
                });

                rows.innerHTML = html;
                var s = subtotal(cart);
                subtotalEl.textContent = formatDH(s);
                totalEl.textContent = formatDH(s);
            }

            rows.addEventListener('click', function (e) {
                var t = e.target;
                if (!t) return;
                var action = t.getAttribute('data-action');
                var slug = t.getAttribute('data-slug');
                if (!action || !slug) return;

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
                render();
            });

            rows.addEventListener('change', function (e) {
                var t = e.target;
                if (!t) return;
                if (!t.getAttribute('data-qty-input')) return;
                var slug = t.getAttribute('data-slug');
                if (!slug) return;
                var n = parseInt(String(t.value || '1'), 10);
                if (isNaN(n) || n < 0) n = 0;
                setQty(slug, n);
                render();
            });

            resetBtn.addEventListener('click', function () {
                try {
                    window.localStorage.removeItem(KEY);
                } catch (e) {}
                render();
            });

            updateBtn.addEventListener('click', function () {
                render();
            });

            render();
        })();
    </script>
@endsection

