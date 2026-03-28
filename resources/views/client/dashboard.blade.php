@extends('layouts.app')

@section('title', 'Tableau de bord — Athleticore')

@section('content')
    @php
        $user = auth()->user();
        $isAdmin = (bool) ($user?->isAdmin());

        // Noms/valeurs issus de la base (fallback si non trouvés)
        $progDebutant = \App\Models\Program::query()->where('slug', 'debutant-femme')->first();
        $progConfirme = \App\Models\Program::query()->where('slug', 'programme-amincissement-et-developpement-musculaire-femme')->first();
        $progNutrition = \App\Models\Program::query()->where('slug', 'programme-nutrition-sportive')->first();

        $name = $user?->name ?? 'Sophie Martin';
        $avatarInitial = strtoupper(substr($user?->name ?? 'Sophie Martin', 0, 1));
    @endphp

    <style>
      :root{
        --bg:#f8f9fa;
        --card:#ffffff;
        --text:#0f172a;
        --muted:#64748b;
        --border:rgba(15,23,42,0.10);
        --shadow: 0 10px 30px rgba(15,23,42,0.06);
        --accent1:#2c7da0;
        --accent2:#1e3a5f;
        --good:#12b981;
        --warn:#f59e0b;
        --barBg: #e5e7eb;
        --barFill: var(--accent1);
        --radius:16px;
      }
      *{ box-sizing:border-box; }
      .dash-wrap{
        width:100%;
        max-width:1200px;
        margin:0 auto;
        padding:24px 16px 48px;
        background:#f8f9fa;
        border-radius:24px;
      }
      /* Header */
      .dash-header{
        display:flex;
        align-items:flex-start;
        justify-content:space-between;
        gap:16px;
        margin-bottom:18px;
      }
      .dash-title h1{
        margin:0;
        font-size:34px;
        line-height:1.1;
        letter-spacing:-0.02em;
        color:var(--text);
      }
      .dash-title p{
        margin:8px 0 0;
        color:var(--muted);
        font-size:14px;
      }
      .dash-user{ display:flex; align-items:center; gap:12px; }
      .avatar{
        width:46px; height:46px;
        border-radius:50%;
        display:grid; place-items:center;
        background: linear-gradient(135deg, rgba(44,125,160,0.18), rgba(30,58,95,0.10));
        border:1px solid var(--border);
        overflow:hidden;
      }
      .avatar img{ width:100%; height:100%; object-fit:cover; display:block; }
      .dash-user strong{ display:block; font-size:14px; font-weight:900; color:var(--text); }
      .dash-user span{ display:block; font-size:12px; color:var(--muted); font-weight:800; }

      /* Grid */
      .dash-grid{
        display:grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap:14px;
        margin-top:14px;
      }
      @media (max-width: 1024px){
        .dash-grid{ grid-template-columns: repeat(2, minmax(0, 1fr)); }
      }
      @media (max-width: 640px){
        .dash-header{ flex-direction:column; align-items:flex-start; }
        .dash-grid{ grid-template-columns: 1fr; }
      }

      /* Card */
      .widget{
        background:var(--card);
        border:1px solid var(--border);
        border-radius:var(--radius);
        box-shadow:var(--shadow);
        padding:16px;
        position:relative;
        overflow:hidden;
      }
      .widget::before{
        content:"";
        position:absolute;
        inset:0;
        background: radial-gradient(800px 150px at 30% -20%, rgba(44,125,160,0.18), transparent 50%);
        pointer-events:none;
      }
      .widget > *{ position:relative; }
      .widget-head{
        display:flex; align-items:flex-start; justify-content:space-between; gap:12px;
        margin-bottom:10px;
      }
      .widget-title{
        display:flex; align-items:center; gap:10px;
        margin:0;
        font-size:14px;
        color:var(--accent2);
        text-transform:none;
        font-weight:900;
      }
      .pill{
        display:inline-flex; align-items:center; gap:6px;
        padding:6px 10px;
        border-radius:999px;
        border:1px solid var(--border);
        background:rgba(15,23,42,0.02);
        font-size:12px;
        color:var(--muted);
        font-weight:900;
      }
      .icon-badge{
        width:38px; height:38px;
        border-radius:12px;
        background: linear-gradient(135deg, rgba(44,125,160,0.16), rgba(30,58,95,0.08));
        border:1px solid rgba(44,125,160,0.22);
        display:grid; place-items:center;
        flex:0 0 auto;
      }
      .icon-badge svg{ width:18px; height:18px; fill:none; stroke:var(--accent2); stroke-width:1.8; }

      .progress-list{ display:flex; flex-direction:column; gap:12px; margin-top:6px; }
      .progress-item{
        display:flex; flex-direction:column; gap:8px;
        padding:10px;
        border-radius:14px;
        border:1px solid rgba(15,23,42,0.08);
        background:rgba(248,249,250,0.6);
      }
      .progress-top{ display:flex; align-items:flex-start; justify-content:space-between; gap:10px; }
      .progress-name{ font-weight:1000; font-size:13px; color:#0b2540; margin:0; }
      .progress-meta{ font-size:12px; color:var(--muted); font-weight:900; }
      .bar{
        width:100%;
        height:10px;
        border-radius:999px;
        background:var(--barBg);
        overflow:hidden;
      }
      .bar > span{
        display:block;
        height:100%;
        width:var(--w, 50%);
        background: linear-gradient(90deg, var(--accent1), var(--accent2));
        border-radius:999px;
      }

      /* Buttons */
      .actions{ display:flex; gap:10px; flex-wrap:wrap; margin-top:12px; }
      a.btn, button.btn{
        display:inline-flex; align-items:center; justify-content:center;
        gap:10px;
        border-radius:12px;
        padding:10px 12px;
        font-weight:900;
        font-size:13px;
        border:1px solid rgba(30,58,95,0.18);
        text-decoration:none;
        background:#fff;
        color:var(--accent2);
        transition:transform .08s ease, background .2s ease;
      }
      a.btn:hover, button.btn:hover{ transform: translateY(-1px); background: rgba(44,125,160,0.06); }
      a.btn.primary, button.btn.primary{
        background: linear-gradient(135deg, var(--accent1), var(--accent2));
        color:#fff;
        border-color: rgba(30,58,95,0.20);
      }

      ul.clean{ margin:10px 0 0; padding-left:18px; color:var(--muted); line-height:1.6; font-size:13px; }

      .schedule{ margin-top:8px; display:flex; flex-direction:column; gap:10px; }
      .schedule-item{
        display:flex; align-items:center; justify-content:space-between; gap:12px;
        padding:10px;
        border-radius:14px;
        border:1px solid rgba(15,23,42,0.08);
        background:rgba(248,249,250,0.6);
      }
      .schedule-day{ font-weight:1000; color:#0b2540; font-size:13px; }
      .schedule-state{
        font-size:12px;
        font-weight:1000;
        padding:6px 10px;
        border-radius:999px;
        border:1px solid rgba(15,23,42,0.10);
        color:var(--muted);
        background:#fff;
        white-space:nowrap;
      }
      .done{ color:#0f7a50; border-color: rgba(18,185,129,0.22); background: rgba(18,185,129,0.08); }
      .todo{ color:#8a5a00; border-color: rgba(245,158,11,0.22); background: rgba(245,158,11,0.10); }

      .chip-list{ display:flex; flex-direction:column; gap:10px; margin-top:6px; }
      .chip{
        display:flex; gap:12px; align-items:flex-start;
        padding:10px;
        border:1px solid rgba(15,23,42,0.08);
        background:rgba(248,249,250,0.6);
        border-radius:14px;
      }
      .chip-title{ font-weight:1000; color:#0b2540; font-size:13px; margin:0; }
      .chip-desc{ margin:4px 0 0; color:var(--muted); font-size:12px; line-height:1.4; font-weight:800; }
      .emoji{
        width:36px; height:36px; border-radius:12px;
        border:1px solid rgba(15,23,42,0.08);
        background:#fff;
        display:grid; place-items:center;
        font-size:18px;
        flex:0 0 auto;
      }

      /* Footer section */
      .dash-bottom{
        margin-top:18px;
        background:#fff;
        border:1px solid var(--border);
        border-radius:var(--radius);
        padding:16px;
        box-shadow:var(--shadow);
      }
      .dash-bottom h3{
        margin:0 0 10px;
        font-size:15px;
        color:var(--accent2);
        font-weight:1000;
      }
      .rec-row{ display:flex; gap:14px; align-items:flex-start; justify-content:space-between; flex-wrap:wrap; }
      .rec-card{ display:flex; gap:12px; align-items:center; }
      .rec-thumb{
        width:52px; height:52px; border-radius:16px;
        border:1px solid rgba(15,23,42,0.10);
        background: linear-gradient(135deg, rgba(44,125,160,0.16), rgba(30,58,95,0.08));
        display:grid; place-items:center;
      }
      .rec-thumb svg{ width:22px; height:22px; stroke:var(--accent2); fill:none; stroke-width:1.8; }
      .rec-info strong{ display:block; font-size:14px; font-weight:1000; color:#0b2540; }
      .rec-info span{ display:block; margin-top:2px; font-size:12px; color:var(--muted); font-weight:900; }
      .faq-link{ margin-left:auto; }

      /* Admin only widget */
      .admin-only{ display:none; }
      .admin-only[data-admin="true"]{ display:block; }

      .note{
        margin-top:10px;
        font-size:12px;
        color:var(--muted);
        line-height:1.45;
        font-weight:800;
      }
    </style>

    <section class="dash-wrap">
      <!-- En-tête -->
      <header class="dash-header">
        <div class="dash-title">
          <h1>Tableau de bord</h1>
          <p>Vue d’ensemble de votre activité</p>
        </div>

        <div class="dash-user">
          <!-- À connecter : Avatar utilisateur -->
          <div class="avatar" aria-hidden="true">
            @if ($user?->photo)
              <img src="{{ asset('storage/'.$user->photo) }}" alt="Avatar">
            @else
              <span style="font-weight:1000;color:var(--accent2);">{{ $avatarInitial }}</span>
            @endif
          </div>
          <div>
            <strong>{{ $name }}</strong>
            <span>Client • suivi & nutrition</span>
            <!-- À connecter : rôle admin/coach -->
          </div>
        </div>
      </header>

      <!-- Grille de widgets -->
      <div class="dash-grid">

        <!-- Widget 1 – Mes programmes actifs -->
        <article class="widget">
          <div class="widget-head">
            <h2 class="widget-title">
              <span class="icon-badge" aria-hidden="true">
                <svg viewBox="0 0 24 24">
                  <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"></path>
                </svg>
              </span>
              Mes programmes actifs
            </h2>
            <span class="pill">
              <!-- À connecter : nombre programmes actifs -->
              2 programmes
            </span>
          </div>

          <div class="progress-list">
            <div class="progress-item">
              <div class="progress-top">
                <p class="progress-name">{{ $progDebutant?->title ?? 'Programme femme débutant' }}</p>
                <div class="progress-meta">65% complété</div>
              </div>
              <div class="bar" role="progressbar" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">
                <span style="--w:65%"></span>
              </div>
            </div>

            <div class="progress-item">
              <div class="progress-top">
                <p class="progress-name">{{ $progNutrition?->title ?? 'Programme nutrition sportive' }}</p>
                <div class="progress-meta">30% complété</div>
              </div>
              <div class="bar" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">
                <span style="--w:30%"></span>
              </div>
            </div>
          </div>

          <div class="actions">
            <a class="btn primary" href="{{ route('client.programs.index') }}">
              Voir tous mes programmes
              <span aria-hidden="true">→</span>
            </a>
          </div>

          <div class="note">
            Parcourez vos programmes et suivez votre avancement depuis la liste des programmes.
          </div>
        </article>

        <!-- Widget 2 – Séance du jour -->
        <article class="widget">
          <div class="widget-head">
            <h2 class="widget-title">
              <span class="icon-badge" aria-hidden="true">
                <svg viewBox="0 0 24 24">
                  <path d="M3 10v4"></path>
                  <path d="M7 8v8"></path>
                  <path d="M17 8v8"></path>
                  <path d="M21 10v4"></path>
                  <path d="M7 12h10"></path>
                </svg>
              </span>
              Séance du jour
            </h2>
            <span class="pill">Entraînement</span>
          </div>

          <div class="widget-sub" style="margin-top:0;font-weight:1000;color:#0b2540;">
            Séance : {{ $progDebutant?->title ?? 'Programme femme débutant' }} - Semaine 3
          </div>

          <ul class="clean">
            <li>Squat</li>
            <li>Rowing buste penché</li>
            <li>Gainage</li>
          </ul>

          <div class="actions">
            <a
              class="btn primary"
              href="{{ $progDebutant ? route('client.programs.show', $progDebutant) : route('client.programs.index') }}"
            >
              Commencer la séance
              <span aria-hidden="true">▶</span>
            </a>
          </div>

          <div class="note">
            Ouvre la fiche du programme pour accéder au contenu et aux séances.
          </div>
        </article>

        <!-- Widget 3 – Progression globale -->
        <article class="widget">
          <div class="widget-head">
            <h2 class="widget-title">
              <span class="icon-badge" aria-hidden="true">
                <svg viewBox="0 0 24 24">
                  <path d="M3 3v18h18"></path>
                  <path d="M7 14l3-3 4 4 5-7"></path>
                </svg>
              </span>
              Progression globale
            </h2>
            <span class="pill">Indicateurs</span>
          </div>

          <div class="schedule" style="margin-top:6px;">
            <div class="schedule-item">
              <div>
                <div style="font-size:12px; color:var(--muted); font-weight:900;">Masse grasse</div>
                <div style="font-weight:1000; color:#0b2540;">-2,5 kg</div>
              </div>
              <div class="schedule-state done">Objectif : -5 kg</div>
            </div>
            <div class="schedule-item">
              <div>
                <div style="font-size:12px; color:var(--muted); font-weight:900;">Force (membres inférieurs)</div>
                <div style="font-weight:1000; color:#0b2540;">+15%</div>
              </div>
              <div class="schedule-state todo">Tendance ↑</div>
            </div>
          </div>

          <div class="actions">
            <a class="btn" href="#0">
              Détails de ma progression
              <span aria-hidden="true">→</span>
            </a>
          </div>

          <div class="note">
            <!-- À connecter : GET /api/user/progress/summary -->
            Calcule à partir des données utilisateur (poids, mensurations) + progression.
          </div>
        </article>

        <!-- Widget 4 – Planning de la semaine -->
        <article class="widget">
          <div class="widget-head">
            <h2 class="widget-title">
              <span class="icon-badge" aria-hidden="true">
                <svg viewBox="0 0 24 24">
                  <path d="M8 2v4"></path>
                  <path d="M16 2v4"></path>
                  <path d="M3 8h18"></path>
                  <path d="M5 4h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z"></path>
                </svg>
              </span>
              Planning de la semaine
            </h2>
            <span class="pill">Semaine 3</span>
          </div>

          <div class="schedule">
            <div class="schedule-item">
              <div>
                <div class="schedule-day">Lundi</div>
                <div class="widget-sub" style="margin:4px 0 0;">Séance jambes</div>
              </div>
              <div class="schedule-state done">Terminée</div>
            </div>
            <div class="schedule-item">
              <div>
                <div class="schedule-day">Mercredi</div>
                <div class="widget-sub" style="margin:4px 0 0;">Séance haut du corps</div>
              </div>
              <div class="schedule-state todo">À venir</div>
            </div>
            <div class="schedule-item">
              <div>
                <div class="schedule-day">Vendredi</div>
                <div class="widget-sub" style="margin:4px 0 0;">Séance full body</div>
              </div>
              <div class="schedule-state todo">À venir</div>
            </div>
          </div>

          <div class="actions">
            <a class="btn" href="#0">Voir le planning</a>
          </div>

          <div class="note">
            <!-- À connecter : GET /api/user/schedule?week=current -->
            Vous pouvez fusionner les données programme + progression.
          </div>
        </article>

        <!-- Widget 5 – Dernières ressources consultées -->
        <article class="widget">
          <div class="widget-head">
            <h2 class="widget-title">
              <span class="icon-badge" aria-hidden="true">
                <svg viewBox="0 0 24 24">
                  <path d="M4 19a2 2 0 0 0 2 2h14"></path>
                  <path d="M6 2h14v20H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2z"></path>
                </svg>
              </span>
              Dernières ressources consultées
            </h2>
            <span class="pill">Ressources</span>
          </div>

          <div class="chip-list">
            <div class="chip">
              <div class="emoji" aria-hidden="true">🎥</div>
              <div>
                <p class="chip-title">Échauffement articulaire - Programme débutant</p>
                <p class="chip-desc">Vidéo • dernière lecture : il y a 2 jours</p>
              </div>
            </div>
            <div class="chip">
              <div class="emoji" aria-hidden="true">🍽️</div>
              <div>
                <p class="chip-title">Pancakes protéinés banane</p>
                <p class="chip-desc">Recette • dernière lecture : hier</p>
              </div>
            </div>
            <div class="chip">
              <div class="emoji" aria-hidden="true">🧠</div>
              <div>
                <p class="chip-title">Adapter son alimentation au cycle menstruel</p>
                <p class="chip-desc">Article • dernière lecture : il y a 5 jours</p>
              </div>
            </div>
          </div>

          <div class="actions">
            <a class="btn" href="#0">Explorer plus</a>
          </div>

          <div class="note">
            <!-- À connecter : GET /api/user/recent-resources -->
            Historique : vidéos, articles, recettes.
          </div>
        </article>

        <!-- Widget 6 – Messages / notifications -->
        <article id="notificationsWidget" class="widget">
          <div class="widget-head">
            <h2 class="widget-title">
              <span class="icon-badge" aria-hidden="true">
                <svg viewBox="0 0 24 24">
                  <path d="M18 8a6 6 0 1 0-12 0c0 7-3 7-3 7h18s-3 0-3-7"></path>
                  <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                </svg>
              </span>
              Messages / notifications
            </h2>
            <span class="pill">Pour vous</span>
          </div>

          <div class="chip-list">
            <div class="chip">
              <div class="emoji" aria-hidden="true">🔔</div>
              <div>
                <p class="chip-title">Nouvelle recette disponible : Bowl protéiné</p>
                <p class="chip-desc">Ajouté aujourd’hui • facile à préparer</p>
              </div>
            </div>
            <div class="chip">
              <div class="emoji" aria-hidden="true">✅</div>
              <div>
                <p class="chip-title">Bravo ! Vous avez complété la semaine 2</p>
                <p class="chip-desc">Continuez : la régularité fait la différence</p>
              </div>
            </div>
            <div class="chip">
              <div class="emoji" aria-hidden="true">💡</div>
              <div>
                <p class="chip-title">Conseil : hydratez-vous avant votre séance</p>
                <p class="chip-desc">Objectif : 2 à 3L / jour (adaptable)</p>
              </div>
            </div>
          </div>

          <div class="actions">
            <a class="btn" href="#0">Gérer les notifications</a>
          </div>

          <div class="note">
            <!-- À connecter : GET /api/user/notifications -->
            Ajoutez vos endpoints et modèle de notifications.
          </div>
        </article>

        <!-- Widget 7 – Vue coach (admin uniquement) -->
        <article class="widget admin-only" data-admin="{{ $isAdmin ? 'true' : 'false' }}">
          <div class="widget-head">
            <h2 class="widget-title">
              <span class="icon-badge" aria-hidden="true">
                <svg viewBox="0 0 24 24">
                  <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                  <path d="M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8z"></path>
                  <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                  <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
              </span>
              Vue coach
            </h2>
            <span class="pill">Admin</span>
          </div>

          <div class="schedule">
            <div class="schedule-item">
              <div>
                <div class="schedule-day">Clients actifs</div>
                <div class="widget-sub" style="margin:4px 0 0;">142</div>
              </div>
              <div class="schedule-state done">↑</div>
            </div>
            <div class="schedule-item">
              <div>
                <div class="schedule-day">Taux complétion moyen</div>
                <div class="widget-sub" style="margin:4px 0 0;">72%</div>
              </div>
              <div class="schedule-state todo">Stable</div>
            </div>
            <div class="schedule-item">
              <div>
                <div class="schedule-day">Programme le plus vendu</div>
                <div class="widget-sub" style="margin:4px 0 0;">{{ $progDebutant?->title ?? 'Programme femme débutant' }}</div>
              </div>
              <div class="schedule-state done">Top</div>
            </div>
            <div class="schedule-item">
              <div>
                <div class="schedule-day">Support en attente</div>
                <div class="widget-sub" style="margin:4px 0 0;">3 demandes</div>
              </div>
              <div class="schedule-state todo">À traiter</div>
            </div>
          </div>

          <div class="actions">
            <a class="btn primary" href="#0">Aller au back-office</a>
          </div>

          <div class="note">
            <!-- À connecter : GET /api/admin/coach/overview (si rôle admin) -->
            Masquer côté backend selon le rôle.
          </div>
        </article>
      </div>

      <!-- Section complémentaire -->
      <section class="dash-bottom">
        <div class="rec-row">
          <div>
            <h3>Recommandé pour vous</h3>
            <div class="rec-card">
              <div class="rec-thumb" aria-hidden="true">
                <svg viewBox="0 0 24 24">
                  <path d="M12 2l1.5 6L20 10l-6.5 2L12 18l-1.5-6L4 10l6.5-2L12 2z"></path>
                </svg>
              </div>
              <div class="rec-info">
                <strong>{{ $progConfirme?->title ?? 'Programme femme confirmé' }}</strong>
                <span>{{ number_format((float) ($progConfirme?->price ?? 890), 2, ',', ' ') }} DH</span>
              </div>
            </div>
          </div>

          <div class="actions faq-link">
            <a class="btn primary" href="#0">Découvrir</a>
            <a class="btn" href="#0">FAQ / Aide</a>
          </div>
        </div>

        <div class="note">
          <!-- À connecter : GET /api/user/recommendations -->
          Recommandations basées sur progression et préférences.
        </div>
      </section>
    </section>
@endsection
