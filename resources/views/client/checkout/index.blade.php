@extends('layouts.app')

@section('title', 'Paiement — Athleticore')

@section('content')
    @php
        $billingFirst = old('billing_first_name');
        $billingLast = old('billing_last_name');
        if ($billingFirst === null && auth()->check()) {
            $parts = preg_split('/\s+/', trim((string) auth()->user()->name), 2);
            $billingFirst = $parts[0] ?? '';
            $billingLast = $parts[1] ?? '';
        }
        $billingFirst = $billingFirst ?? '';
        $billingLast = $billingLast ?? '';
    @endphp
    <div class="bg-zinc-50 py-10 text-zinc-900 sm:py-12">
        <div class="mx-auto max-w-6xl px-4">
            <h1 class="text-center text-3xl font-extrabold tracking-tight text-zinc-900 sm:text-4xl">Paiement</h1>

            @guest
                <div class="mt-8 space-y-3">
                    <div class="rounded-md border border-[#e63946]/40 bg-white px-4 py-3 text-sm text-zinc-700">
                        <span class="font-semibold text-[#e63946]">Déjà client ?</span>
                        <a href="{{ route('login') }}" class="ml-1 font-semibold text-[#e63946] underline decoration-[#e63946]/40 underline-offset-2 hover:text-[#d62f3c]">
                            Cliquez ici pour vous connecter
                        </a>
                    </div>
                </div>
            @endguest

            <form id="checkoutForm" class="mt-10 grid gap-10 lg:grid-cols-12" action="#" method="post" novalidate>
                @csrf

                <div class="space-y-10 lg:col-span-7">
                    <section class="rounded-lg border border-zinc-200 bg-white p-6 shadow-sm">
                        <h2 class="border-b border-zinc-100 pb-4 text-lg font-extrabold text-zinc-900">Coordonnées de facturation</h2>

                        <div class="mt-6 grid gap-4 sm:grid-cols-2">
                            <div>
                                <label for="billing_first_name" class="mb-1 block text-sm font-medium text-zinc-700">Prénom <span class="text-[#e63946]">*</span></label>
                                <input
                                    id="billing_first_name"
                                    name="billing_first_name"
                                    type="text"
                                    autocomplete="given-name"
                                    value="{{ $billingFirst }}"
                                    class="w-full rounded-md border border-zinc-300 px-3 py-2 text-sm text-zinc-900 shadow-sm focus:border-[#e63946] focus:outline-none focus:ring-1 focus:ring-[#e63946]"
                                    required
                                >
                            </div>
                            <div>
                                <label for="billing_last_name" class="mb-1 block text-sm font-medium text-zinc-700">Nom <span class="text-[#e63946]">*</span></label>
                                <input
                                    id="billing_last_name"
                                    name="billing_last_name"
                                    type="text"
                                    autocomplete="family-name"
                                    value="{{ $billingLast }}"
                                    class="w-full rounded-md border border-zinc-300 px-3 py-2 text-sm text-zinc-900 shadow-sm focus:border-[#e63946] focus:outline-none focus:ring-1 focus:ring-[#e63946]"
                                    required
                                >
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="billing_company" class="mb-1 block text-sm font-medium text-zinc-700">Société (facultatif)</label>
                            <input id="billing_company" name="billing_company" type="text" autocomplete="organization" class="w-full rounded-md border border-zinc-300 px-3 py-2 text-sm text-zinc-900 shadow-sm focus:border-[#e63946] focus:outline-none focus:ring-1 focus:ring-[#e63946]">
                        </div>

                        <div class="mt-4">
                            <label for="billing_country" class="mb-1 block text-sm font-medium text-zinc-700">Pays / Région <span class="text-[#e63946]">*</span></label>
                            <select id="billing_country" name="billing_country" class="w-full rounded-md border border-zinc-300 px-3 py-2 text-sm text-zinc-900 shadow-sm focus:border-[#e63946] focus:outline-none focus:ring-1 focus:ring-[#e63946]" required>
                                <option value="MA" selected>Maroc</option>
                                <option value="FR">France</option>
                                <option value="BE">Belgique</option>
                                <option value="CH">Suisse</option>
                            </select>
                        </div>

                        <div class="mt-4">
                            <label for="billing_address_1" class="mb-1 block text-sm font-medium text-zinc-700">Adresse <span class="text-[#e63946]">*</span></label>
                            <input id="billing_address_1" name="billing_address_1" type="text" placeholder="Numéro et nom de rue" autocomplete="address-line1" class="w-full rounded-md border border-zinc-300 px-3 py-2 text-sm text-zinc-900 shadow-sm focus:border-[#e63946] focus:outline-none focus:ring-1 focus:ring-[#e63946]" required>
                            <input id="billing_address_2" name="billing_address_2" type="text" placeholder="Appartement, bâtiment, etc. (facultatif)" autocomplete="address-line2" class="mt-2 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm text-zinc-900 shadow-sm focus:border-[#e63946] focus:outline-none focus:ring-1 focus:ring-[#e63946]">
                        </div>

                        <div class="mt-4 grid gap-4 sm:grid-cols-2">
                            <div>
                                <label for="billing_postcode" class="mb-1 block text-sm font-medium text-zinc-700">Code postal <span class="text-[#e63946]">*</span></label>
                                <input id="billing_postcode" name="billing_postcode" type="text" autocomplete="postal-code" class="w-full rounded-md border border-zinc-300 px-3 py-2 text-sm text-zinc-900 shadow-sm focus:border-[#e63946] focus:outline-none focus:ring-1 focus:ring-[#e63946]" required>
                            </div>
                            <div>
                                <label for="billing_city" class="mb-1 block text-sm font-medium text-zinc-700">Ville <span class="text-[#e63946]">*</span></label>
                                <input id="billing_city" name="billing_city" type="text" autocomplete="address-level2" class="w-full rounded-md border border-zinc-300 px-3 py-2 text-sm text-zinc-900 shadow-sm focus:border-[#e63946] focus:outline-none focus:ring-1 focus:ring-[#e63946]" required>
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="billing_phone" class="mb-1 block text-sm font-medium text-zinc-700">Téléphone <span class="text-[#e63946]">*</span></label>
                            <input id="billing_phone" name="billing_phone" type="tel" autocomplete="tel" class="w-full rounded-md border border-zinc-300 px-3 py-2 text-sm text-zinc-900 shadow-sm focus:border-[#e63946] focus:outline-none focus:ring-1 focus:ring-[#e63946]" required>
                        </div>

                        <div class="mt-4">
                            <label for="billing_email" class="mb-1 block text-sm font-medium text-zinc-700">Adresse e-mail <span class="text-[#e63946]">*</span></label>
                            <input id="billing_email" name="billing_email" type="email" autocomplete="email" value="{{ old('billing_email', auth()->user()->email ?? '') }}" class="w-full rounded-md border border-zinc-300 px-3 py-2 text-sm text-zinc-900 shadow-sm focus:border-[#e63946] focus:outline-none focus:ring-1 focus:ring-[#e63946]" required>
                        </div>

                        <label class="mt-5 flex cursor-pointer items-center gap-2 text-sm text-zinc-700">
                            <input type="checkbox" name="create_account" value="1" class="h-4 w-4 rounded border-zinc-300 text-[#e63946] focus:ring-[#e63946]">
                            Créer un compte ?
                        </label>
                    </section>

                    <section class="rounded-lg border border-zinc-200 bg-white p-6 shadow-sm">
                        <h2 class="border-b border-zinc-100 pb-4 text-lg font-extrabold text-zinc-900">Informations complémentaires</h2>
                        <div class="mt-4">
                            <label for="order_comments" class="mb-1 block text-sm font-medium text-zinc-700">Notes de commande (facultatif)</label>
                            <textarea id="order_comments" name="order_comments" rows="4" placeholder="Notes sur votre commande, par ex. consignes de livraison." class="w-full rounded-md border border-zinc-300 px-3 py-2 text-sm text-zinc-900 shadow-sm focus:border-[#e63946] focus:outline-none focus:ring-1 focus:ring-[#e63946]"></textarea>
                        </div>
                    </section>
                </div>

                <aside class="lg:col-span-5">
                    <div class="sticky top-24 rounded-lg border border-zinc-200 bg-white shadow-sm">
                        <div class="border-b border-zinc-100 px-5 py-4">
                            <h2 class="text-base font-extrabold text-zinc-900">Votre commande</h2>
                        </div>

                        <div id="checkoutOrderEmpty" class="hidden px-5 py-8 text-center text-sm text-zinc-500">
                            <p>Votre panier est vide.</p>
                            <a href="{{ route('client.cart') }}" class="mt-3 inline-block font-semibold text-[#e63946] underline">Retour au panier</a>
                        </div>

                        <div id="checkoutOrderContent" class="hidden">
                            <div class="overflow-x-auto">
                                <table class="w-full min-w-[280px] text-left text-sm">
                                    <thead class="border-b border-zinc-100 bg-zinc-50 text-xs font-bold uppercase tracking-wide text-zinc-500">
                                        <tr>
                                            <th class="px-5 py-3">Produit</th>
                                            <th class="px-5 py-3 text-right">Sous-total</th>
                                        </tr>
                                    </thead>
                                    <tbody id="checkoutOrderLines" class="divide-y divide-zinc-100"></tbody>
                                    <tfoot class="border-t border-zinc-200 text-sm">
                                        <tr>
                                            <td class="px-5 py-3 font-semibold text-zinc-600">Sous-total</td>
                                            <td id="checkoutSubtotal" class="px-5 py-3 text-right font-bold text-zinc-900">0,00 DH</td>
                                        </tr>
                                        <tr>
                                            <td class="px-5 py-3 font-semibold text-zinc-600">Total</td>
                                            <td id="checkoutTotal" class="px-5 py-3 text-right text-base font-extrabold text-zinc-900">0,00 DH</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="space-y-4 border-t border-zinc-100 px-5 py-5">
                                <p class="text-sm font-semibold text-zinc-900">Moyen de paiement</p>

                                <label class="flex cursor-pointer items-start gap-3 rounded-md border border-zinc-200 p-3 has-[:checked]:border-[#e63946] has-[:checked]:bg-[#e63946]/5">
                                    <input type="radio" name="payment_method" value="card" class="mt-1 h-4 w-4 border-zinc-300 text-[#e63946] focus:ring-[#e63946]" checked>
                                    <span class="text-sm">
                                        <span class="font-bold text-zinc-900">Carte bancaire</span>
                                        <span class="ml-2 text-xs font-semibold text-zinc-500">Monetico / serveur sécurisé</span>
                                        <span class="mt-2 block rounded-md bg-zinc-100 px-3 py-2 text-xs leading-relaxed text-zinc-600">
                                            En choisissant ce moyen de paiement, vous serez redirigé vers le serveur sécurisé de la banque (démo : non connecté).
                                        </span>
                                    </span>
                                </label>

                                <label class="flex cursor-pointer items-start gap-3 rounded-md border border-zinc-200 p-3 has-[:checked]:border-[#e63946] has-[:checked]:bg-[#e63946]/5">
                                    <input type="radio" name="payment_method" value="paypal" class="mt-1 h-4 w-4 border-zinc-300 text-[#e63946] focus:ring-[#e63946]">
                                    <span class="text-sm font-bold text-zinc-900">PayPal</span>
                                </label>

                                <p class="text-[11px] leading-relaxed text-zinc-500">
                                    Vos données personnelles seront utilisées pour traiter votre commande et pour d’autres usages décrits dans notre politique de confidentialité.
                                </p>

                                <label class="flex cursor-pointer items-start gap-2 text-sm text-zinc-700">
                                    <input type="checkbox" id="terms" name="terms" value="1" class="mt-0.5 h-4 w-4 rounded border-zinc-300 text-[#e63946] focus:ring-[#e63946]" required>
                                    <span>J’ai lu et j’accepte les <a href="{{ route('client.about') }}" class="font-semibold text-[#e63946] underline">conditions générales</a> du site <span class="text-[#e63946]">*</span></span>
                                </label>

                                <button id="checkoutSubmitBtn" type="submit" class="w-full rounded-md bg-[#e63946] px-4 py-3 text-sm font-extrabold text-white shadow-sm transition hover:bg-[#d62f3c]">
                                    Payer par carte bancaire
                                </button>
                            </div>
                        </div>
                    </div>
                </aside>
            </form>
        </div>
    </div>

    <script>
        (function () {
            var KEY = 'athleticore_cart_v1';
            var emptyEl = document.getElementById('checkoutOrderEmpty');
            var contentEl = document.getElementById('checkoutOrderContent');
            var linesEl = document.getElementById('checkoutOrderLines');
            var subtotalEl = document.getElementById('checkoutSubtotal');
            var totalEl = document.getElementById('checkoutTotal');
            var form = document.getElementById('checkoutForm');
            var submitBtn = document.getElementById('checkoutSubmitBtn');
            var paymentRadios = document.querySelectorAll('input[name="payment_method"]');

            if (!emptyEl || !contentEl || !linesEl || !subtotalEl || !totalEl) return;

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

            function render() {
                var cart = loadCart();
                var keys = Object.keys(cart.items || {});

                if (keys.length === 0) {
                    emptyEl.classList.remove('hidden');
                    contentEl.classList.add('hidden');
                    return;
                }

                emptyEl.classList.add('hidden');
                contentEl.classList.remove('hidden');

                var html = '';
                keys.forEach(function (slug) {
                    var it = cart.items[slug] || {};
                    var title = escapeHtml(it.title || 'Programme');
                    var qty = Number(it.qty || 1);
                    var price = Number(it.price || 0);
                    var line = price * qty;
                    html +=
                        '<tr>' +
                        '<td class="px-5 py-3 text-zinc-800">' + title + ' <span class="text-zinc-500">× ' + escapeHtml(qty) + '</span></td>' +
                        '<td class="px-5 py-3 text-right font-semibold text-zinc-900">' + formatDH(line) + '</td>' +
                        '</tr>';
                });

                linesEl.innerHTML = html;
                var s = subtotal(cart);
                subtotalEl.textContent = formatDH(s);
                totalEl.textContent = formatDH(s);
            }

            function syncSubmitLabel() {
                if (!submitBtn || !paymentRadios.length) return;
                var method = 'card';
                paymentRadios.forEach(function (r) {
                    if (r.checked) method = r.value;
                });
                if (method === 'paypal') {
                    submitBtn.textContent = 'Payer avec PayPal';
                } else {
                    submitBtn.textContent = 'Payer par carte bancaire';
                }
            }

            paymentRadios.forEach(function (r) {
                r.addEventListener('change', syncSubmitLabel);
            });

            if (form) {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    var cart = loadCart();
                    if (Object.keys(cart.items || {}).length === 0) {
                        alert('Votre panier est vide.');
                        return;
                    }
                    var terms = document.getElementById('terms');
                    if (terms && !terms.checked) {
                        alert('Veuillez accepter les conditions générales.');
                        return;
                    }
                    alert('Paiement démo : aucune transaction réelle. Votre commande est enregistrée uniquement dans le navigateur (localStorage).');
                });
            }

            render();
            syncSubmitLabel();
        })();
    </script>
@endsection
