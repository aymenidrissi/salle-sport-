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

        // Coordonnées pour le virement bancaire (à configurer dans .env).
        // - BANK_ACCOUNT_NUMBER : numéro de compte / IBAN (selon votre besoin)
        // - BANK_NAME : nom de la banque
        $bankAccountNumber = env('BANK_ACCOUNT_NUMBER', '00000000000000000000');
        $bankName = env('BANK_NAME', 'Banque (à configurer)');
    @endphp
    <div class="bg-zinc-50 py-10 text-zinc-900 sm:py-12">
        <div class="mx-auto max-w-6xl px-4">
            <h1 class="text-center text-3xl font-extrabold tracking-tight text-zinc-900 sm:text-4xl">Paiement</h1>

            @if (session('order_placed'))
                <div class="mx-auto mt-6 max-w-2xl rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-center text-sm font-medium text-emerald-900">
                    Commande enregistrée. Merci — vous pouvez retrouver vos achats dans votre espace lorsque le paiement en ligne sera connecté.
                </div>
            @endif

            @if ($errors->any())
                <div class="mx-auto mt-6 max-w-2xl rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                    <ul class="list-inside list-disc space-y-1">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

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

            <form id="checkoutForm" class="mt-10 grid gap-10 lg:grid-cols-12" action="{{ route('client.checkout.store') }}" method="post" novalidate>
                @csrf
                <input type="hidden" name="cart_json" id="cart_json" value="">

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
                                <div>
                                    <p class="text-sm font-semibold text-zinc-900">Conditions générales</p>
                                    <p class="mt-1 text-xs text-zinc-500">Ouvrez le texte pour le lire, puis cochez la case pour confirmer avant de payer.</p>
                                    <button
                                        type="button"
                                        id="openCguDialog"
                                        class="mt-3 text-left text-sm font-semibold text-[#e63946] underline decoration-[#e63946]/40 underline-offset-2 hover:text-[#d62f3c]"
                                    >
                                        Lire les conditions générales
                                    </button>
                                </div>

                                <dialog
                                    id="cguDialog"
                                    class="w-[min(100vw-2rem,42rem)] max-h-[90vh] rounded-xl border border-zinc-200 bg-white p-0 text-zinc-900 shadow-2xl backdrop:bg-black/50 open:flex open:flex-col"
                                    aria-labelledby="cguDialogTitle"
                                >
                                    <div class="flex items-center justify-between border-b border-zinc-100 px-4 py-3 sm:px-5">
                                        <h3 id="cguDialogTitle" class="text-base font-extrabold text-zinc-900">Conditions générales</h3>
                                        <button
                                            type="button"
                                            id="closeCguDialog"
                                            class="rounded-md p-2 text-sm font-medium text-zinc-500 transition hover:bg-zinc-100 hover:text-zinc-800"
                                            aria-label="Fermer"
                                        >
                                            <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="min-h-0 flex-1 px-4 py-3 sm:px-5">
                                        <label for="cguTextarea" class="sr-only">Texte des conditions générales à lire</label>
                                        <textarea
                                            id="cguTextarea"
                                            readonly
                                            rows="16"
                                            class="h-[min(55vh,28rem)] w-full resize-none rounded-md border border-zinc-200 bg-zinc-50/90 px-3 py-3 text-sm leading-relaxed text-zinc-800 shadow-inner focus:border-[#e63946] focus:outline-none focus:ring-1 focus:ring-[#e63946]"
                                        >Athleticore

La naissance des programmes de sport

Athleticore est né d’une idée simple : rendre l’entraînement accessible, structuré et sérieux, comme en salle — mais à distance. Notre équipe s’appuie sur une expérience terrain et une approche pédagogique pour vous guider pas à pas.

Nos contenus s’inspirent des standards d’un centre comme Complexe Fitness : exigence, clarté des séances, et suivi des progrès sans promesses irréalistes.

Chaque programme relie musculation, récupération et repères nutritionnels pour que vous sachiez pourquoi vous faites chaque exercice, et comment avancer en sécurité.

Suivre un programme sportif en ligne

Sur Athleticore, vous accédez à des séances détaillées, des vidéos et un parcours cohérent selon votre niveau. L’objectif est de rendre l’entraînement de sport en ligne aussi lisible qu’en présentiel : consignes, alternatives, et progression mesurable.

Vous progressez à votre rythme, avec des repères concrets (charge, volume, régularité) pour ancrer des habitudes durables.

Merci de votre confiance — on avance ensemble 💛</textarea>
                                    </div>
                                    <div class="border-t border-zinc-100 px-4 py-3 sm:px-5">
                                        <button
                                            type="button"
                                            id="closeCguDialogFooter"
                                            class="w-full rounded-md bg-zinc-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-zinc-800"
                                        >
                                            Fermer
                                        </button>
                                    </div>
                                </dialog>

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

                                <label class="flex cursor-pointer items-start gap-3 rounded-md border border-zinc-200 p-3 has-[:checked]:border-[#e63946] has-[:checked]:bg-[#e63946]/5">
                                    <input type="radio" name="payment_method" value="bank_transfer" class="mt-1 h-4 w-4 border-zinc-300 text-[#e63946] focus:ring-[#e63946]">
                                    <span class="text-sm">
                                        <span class="font-bold text-zinc-900">Virement bancaire</span>
                                        <span class="mt-2 block rounded-md bg-zinc-100 px-3 py-2 text-xs leading-relaxed text-zinc-600">
                                            Numéro de compte : <span class="font-semibold text-zinc-800">{{ $bankAccountNumber }}</span>
                                            <br>
                                            Banque : <span class="font-semibold text-zinc-800">{{ $bankName }}</span>
                                        </span>
                                    </span>
                                </label>

                                <p class="text-[11px] leading-relaxed text-zinc-500">
                                    Vos données personnelles seront utilisées pour traiter votre commande et pour d’autres usages décrits dans notre politique de confidentialité.
                                </p>

                                <label class="flex cursor-pointer items-start gap-2 text-sm text-zinc-700">
                                    <input type="checkbox" id="terms" name="terms" value="1" class="mt-0.5 h-4 w-4 shrink-0 rounded border-zinc-300 text-[#e63946] focus:ring-[#e63946]" required>
                                    <span>J’ai lu les conditions générales et j’accepte <span class="text-[#e63946]">*</span></span>
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

    @if (session('order_placed'))
        <script>
            (function () {
                try {
                    window.localStorage.removeItem('athleticore_cart_v1');
                } catch (e) {}
            })();
        </script>
    @endif

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
                } else if (method === 'bank_transfer') {
                    submitBtn.textContent = 'Payer par virement bancaire';
                } else {
                    submitBtn.textContent = 'Payer par carte bancaire';
                }
            }

            paymentRadios.forEach(function (r) {
                r.addEventListener('change', syncSubmitLabel);
            });

            if (form) {
                form.addEventListener('submit', function (e) {
                    var cart = loadCart();
                    if (Object.keys(cart.items || {}).length === 0) {
                        e.preventDefault();
                        alert('Votre panier est vide.');
                        return;
                    }
                    var terms = document.getElementById('terms');
                    if (terms && !terms.checked) {
                        e.preventDefault();
                        alert('Veuillez accepter les conditions générales.');
                        return;
                    }
                    var cartJson = document.getElementById('cart_json');
                    if (cartJson) {
                        cartJson.value = JSON.stringify(cart.items || {});
                    }
                });
            }

            render();
            syncSubmitLabel();

            var cguDialog = document.getElementById('cguDialog');
            var openCgu = document.getElementById('openCguDialog');
            var closeCgu = document.getElementById('closeCguDialog');
            var closeCguFooter = document.getElementById('closeCguDialogFooter');
            if (cguDialog && openCgu) {
                openCgu.addEventListener('click', function () {
                    if (typeof cguDialog.showModal === 'function') {
                        cguDialog.showModal();
                    }
                });
            }
            function closeCguModal() {
                if (cguDialog && typeof cguDialog.close === 'function') {
                    cguDialog.close();
                }
            }
            if (closeCgu) closeCgu.addEventListener('click', closeCguModal);
            if (closeCguFooter) closeCguFooter.addEventListener('click', closeCguModal);
            if (cguDialog) {
                cguDialog.addEventListener('click', function (e) {
                    if (e.target === cguDialog) closeCguModal();
                });
            }
        })();
    </script>
@endsection
