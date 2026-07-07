<?php 
 session_start();

require_once "../functions/users.php";
require_once "../functions/factures.php";
require_once "../functions/devis.php";
require_once "../functions/paiements.php";

 checkLogin();

 $factures = getAllFacturesDashboard();
 $devis = getAllDevisDashboard();
 $paiements = getAllPaiementsDashboard();
$logs = getLogs();



?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tableau de bord — Factura</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="../assets/css/style.css" rel="stylesheet">
  <link href="../assets/css/etat.css" rel="stylesheet">
  <link rel="apple-touch-icon" sizes="180x180" href="../assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="../assets/favicon/site.webmanifest">
</head>
<body>


<style>

.sidebar-backdrop {
  position: fixed;
  inset: 0;
  z-index: 1200 !important;
  background: var(--color-overlay);
  opacity: 0;
  visibility: hidden;
  transition: opacity var(--duration-base) var(--ease-standard), visibility var(--duration-base);
}


.sidebar {
  position: fixed;
  top: 0; left: 0; bottom: 0;
  width: var(--sidebar-width);
  z-index:1300 !important;
  display: flex;
  flex-direction: column;
  padding: var(--space-6) var(--space-5);
  background: var(--color-primary);
  color: var(--color-on-primary);
  border-top-right-radius: var(--radius-xl);
  border-bottom-right-radius: var(--radius-xl);
  transition: transform var(--duration-slow) var(--ease-out);
}
</style>
<div class="app-shell">

  <!-- SIDEBAR -->
    <?php require_once "../partials/sidebar.php" ?>
  <div class="sidebar-backdrop"></div>

  <!-- MAIN -->
  <div class="main">
    <header class="navbar-app">
      <button class="icon-button sidebar-toggle" data-sidebar-toggle aria-label="Menu"><i class="bi bi-list"></i></button>
      <div class="navbar-app__search">
        <i class="bi bi-search"></i>
        <input type="search" placeholder="Rechercher un client, une facture…">
      </div>
      <div class="navbar-app__actions">
        <a href="facture_create.php" class="btn btn-primary btn-sm d-none d-md-inline-flex"><i class="bi bi-plus-lg"></i> Nouvelle facture</a>
        <!-- Notifications -->
        <div class="dropdown">
          <button class="icon-button" data-bs-toggle="dropdown" aria-label="Notifications"><i class="bi bi-bell"></i><span class="dot"></span></button>
          <ul class="dropdown-menu dropdown-menu-end" style="--bs-dropdown-min-width:320px">
            <li class="dropdown-header">Notifications</li>
            <li><div class="notif-item"><span class="notif-item__icon kpi__icon--success"><i class="bi bi-check2"></i></span><div><div class="fw-medium">Paiement reçu</div><small class="text-secondary">Studio Lumière · 2 400 €</small></div></div></li>
            <li><div class="notif-item"><span class="notif-item__icon kpi__icon--warning"><i class="bi bi-hourglass"></i></span><div><div class="fw-medium">Devis en attente</div><small class="text-secondary">Nexa SARL · depuis 5 j</small></div></div></li>
            <li><div class="notif-item"><span class="notif-item__icon kpi__icon--error"><i class="bi bi-exclamation"></i></span><div><div class="fw-medium">Facture en retard</div><small class="text-secondary">Boréal Finance · 5 120 €</small></div></div></li>
          </ul>
        </div>
        <!-- Profil -->
        <div class="dropdown">
          <button class="icon-button" data-bs-toggle="dropdown" style="width:auto;gap:8px;padding:0 8px"><span class="avatar avatar--sm"><i class="bi bi-person-fill"></i></span> <i class="bi bi-chevron-down text-xs"></i></button>
          <ul class="dropdown-menu dropdown-menu-end">
            <li class="dropdown-header"><?= $_SESSION["first_name"] ?></li>
            <li><a class="dropdown-item" href="profil.php"><i class="bi bi-person"></i> Mon profil</a></li>
            <li><a class="dropdown-item" href="#"><i class="bi bi-gear"></i> Paramètres</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger" href="../partials/logout.php"><i class="bi bi-box-arrow-right"></i> Se déconnecter</a></li>
          </ul>
        </div>
      </div>
    </header>

    <main class="page">
      <div class="page-header">
        <div>
          <h1>Bonjour <?= $_SESSION["first_name"] ?></h1>
          <p>Voici un aperçu de votre activité pour juin 2026.</p>
        </div>
        <div class="cluster-2">
          <button class="btn btn-secondary btn-sm"><i class="bi bi-calendar3"></i> 30 derniers jours</button>
          <button class="btn btn-secondary btn-sm"><i class="bi bi-download"></i> Exporter</button>
        </div>
      </div>

      <!-- KPIs -->
      <div class="row g-3 section stagger">
        <div class="col-12 col-sm-6 col-xl-3">
          <div class="kpi"><div class="kpi__top"><span class="kpi__label">Chiffre d'affaires</span><span class="kpi__icon"><i class="bi bi-graph-up-arrow"></i></span></div><div class="kpi__value text-mono">84 320 €</div><div><span class="kpi__delta kpi__delta--up"><i class="bi bi-arrow-up-short"></i>12,4 %</span> <span>vs mois dernier</span></div></div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
          <div class="kpi"><div class="kpi__top"><span class="kpi__label">Paiements reçus</span><span class="kpi__icon kpi__icon--success"><i class="bi bi-cash-stack"></i></span></div><div class="kpi__value text-mono">61 200 €</div><div><span class="kpi__delta kpi__delta--up"><i class="bi bi-arrow-up-short"></i>8 %</span> <span>ce mois</span></div></div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
          <div class="kpi"><div class="kpi__top"><span class="kpi__label">En attente</span><span class="kpi__icon kpi__icon--warning"><i class="bi bi-hourglass-split"></i></span></div><div class="kpi__value text-mono">18 000 €</div><div><span class="text-secondary">9 factures ouvertes</span></div></div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
          <div class="kpi"><div class="kpi__top"><span class="kpi__label">En retard</span><span class="kpi__icon kpi__icon--error"><i class="bi bi-exclamation-octagon"></i></span></div><div class="kpi__value text-mono">5 120 €</div><div><span class="kpi__delta kpi__delta--down"><i class="bi bi-arrow-down-short"></i>2</span> <span>factures</span></div></div>
        </div>
      </div>

      <!-- Seconde rangée de mini KPIs -->
      <div class="row g-3 section">
        <div class="col-6 col-md-3"><div class="kpi"><span class="kpi__label">Factures émises</span><div class="kpi__value text-mono" style="font-size:var(--fs-h2)">142</div></div></div>
        <div class="col-6 col-md-3"><div class="kpi"><span class="kpi__label">Devis</span><div class="kpi__value text-mono" style="font-size:var(--fs-h2)">37</div></div></div>
        <div class="col-6 col-md-3"><div class="kpi"><span class="kpi__label">Clients actifs</span><div class="kpi__value text-mono" style="font-size:var(--fs-h2)">58</div></div></div>
        <div class="col-6 col-md-3"><div class="kpi"><span class="kpi__label">Solde disponible</span><div class="kpi__value text-mono" style="font-size:var(--fs-h2)">23 410 €</div></div></div>
      </div>

      <!-- Graphiques -->
      <div class="row g-3 section">
        <div class="col-lg-8">
          <div class="card-ds h-100">
            <div class="card-ds__head">
              <div class="card-ds__title"><h3>Chiffre d'affaires</h3><small class="text-secondary">6 derniers mois</small></div>
              <div class="chart-legend">
                <span><span class="dot" style="background:var(--color-primary)"></span> CA</span>
                <span><span class="dot" style="background:var(--color-accent)"></span> Revenus nets</span>
              </div>
            </div>
            <div class="chart">
              <div class="chart__col"><div class="chart__bar" style="height:45%"></div><span class="chart__label">Jan</span></div>
              <div class="chart__col"><div class="chart__bar" style="height:62%"></div><span class="chart__label">Fév</span></div>
              <div class="chart__col"><div class="chart__bar" style="height:53%"></div><span class="chart__label">Mar</span></div>
              <div class="chart__col"><div class="chart__bar" style="height:78%"></div><span class="chart__label">Avr</span></div>
              <div class="chart__col"><div class="chart__bar" style="height:69%"></div><span class="chart__label">Mai</span></div>
              <div class="chart__col"><div class="chart__bar" style="height:92%"></div><span class="chart__label">Juin</span></div>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="card-ds h-100 d-flex flex-column">
            <div class="card-ds__head"><h3>Répartition</h3></div>
            <div class="d-flex flex-column align-items-center justify-content-center flex-grow-1">
              <div class="donut"><div class="donut__hole"><div><div class="fw-bold" style="font-size:var(--fs-h2)">62%</div><small class="text-secondary">encaissé</small></div></div></div>
              <div class="chart-legend mt-4 justify-content-center">
                <span><span class="dot" style="background:var(--color-primary)"></span> Payé</span>
                <span><span class="dot" style="background:var(--color-accent)"></span> En attente</span>
                <span><span class="dot" style="background:var(--color-border)"></span> Retard</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Dernières factures + Paiements récents -->
      <div class="row g-3 section">
        <div class="col-xl-7">
          <div class="table-wrap">
            <div class="table-toolbar">
              <div class="grow"><h3 class="mb-0" style="font-size:var(--fs-h4)">Dernières factures</h3></div>
              <a href="facture.php" class="btn btn-ghost btn-sm">Tout voir <i class="bi bi-arrow-right"></i></a>
            </div>
            <table class="table-ds">
              <thead><tr><th>Facture</th><th>Client</th><th>Montant</th><th>Statut</th></tr></thead>
              <tbody>

              <?php foreach($factures as $facture):?>


              <tr data-href="detail_facture.php">
                <td class="cell-strong"><?= $facture['numero_facture'] ?></td>
                <td><div class="cell-entity"><span class="avatar avatar--sm"><i class="bi bi-person-fill"></i></span><?= $facture['firstname_customer'] ?> <?= $facture['lastname_customer'] ?></div></td>
                <td class="text-mono"><?= $facture['total_ttc'] ?> €</td>
                <td><span class="badge-ds badge-facture-<?= $facture['id_status_facture'] ?>"><?= $facture['name_status_facture'] ?></span></td>
            </tr>

                <?php endforeach?>

            </tbody>
            </table>
          </div>
        </div>
        <div class="col-xl-5">
          <div class="card-ds h-100">
            <div class="card-ds__head"><h3 style="font-size:var(--fs-h4)">Paiements récents</h3><a href="paiement.php" class="btn btn-ghost btn-sm">Tout voir </a></div>
            <ul class="list-unstyled mb-0 stack-3">

            <?php foreach($paiements as $paiement):?>
              <li class="d-flex align-items-center gap-3"><span class="kpi__icon kpi__icon--success" style="width:38px;height:38px"><i class="bi bi-arrow-down-left"></i></span><div class="grow"><div class="fw-medium"><?= $paiement['firstname_customer'] ?> <?= $paiement['lastname_customer'] ?></div><small class="badge-ds badge-paiement-<?= $paiement['id_mode_paiement'] ?>"><?= $paiement['name_mode_paiement'] ?> </small> <small class="text-secondery"> · <?= date('d/m/Y', strtotime($paiement['date_paiement'])) ?></small></div><span class="fw-semibold text-mono">+<?= $paiement['montant_paiement'] ?> €</span></li>



              <?php endforeach?>
      
            </ul>
          </div>
        </div>
      </div>



      <div class="row g-3 section">
        <div class="col-xl-7">
          <div class="table-wrap">
            <div class="table-toolbar">
              <div class="grow"><h3 class="mb-0" style="font-size:var(--fs-h4)">Derniers devis</h3></div>
              <a href="devis.php" class="btn btn-ghost btn-sm">Tout voir <i class="bi bi-arrow-right"></i></a>
            </div>
            <table class="table-ds">
              <thead><tr><th>Devis</th><th>Client</th><th>Montant</th><th>Statut</th></tr></thead>
              <tbody>
              <?php foreach($devis as $dev):?>


                    <tr data-href="detail_devis.php">
                    <td class="cell-strong"><?= $dev['numero_devis'] ?></td>
                    <td><div class="cell-entity"><span class="avatar avatar--sm"><i class="bi bi-person-fill"></i></span><?= $dev['firstname_customer'] ?> <?= $dev['lastname_customer'] ?></div></td>
                    <td class="text-mono"><?= $dev['total_ttc'] ?> €</td>
                    <td><span class="badge-ds badge-devis-<?= $dev['id_status_devis'] ?>"><?= $dev['name_status_devis'] ?></span></td>
                    </tr>

                    <?php endforeach?>
               
                </tbody>
            </table>
          </div>
        </div>
        <div class="col-xl-5">
          <div class="card-ds h-100">
            <div class="card-ds__head"><h3 style="font-size:var(--fs-h4)">Activités récentes</h3><a href="logs.php" class="btn btn-ghost btn-sm">Tout voir</a></div>
          <ul class="list-unstyled mb-0 stack-3">
            <?php foreach($logs as $log): ?>
          <li class="d-flex align-items-start gap-3"><span class="avatar avatar--sm"><i class="bi bi-person-fill"></i></span><div><span class="fw-medium"> <?= $log['description_historique'] ?> <div><small class="text-muted-2"><?= date('d-m-Y - H:i:s', strtotime($log['date_action'])) ?></small></div></div></li>

            <?php endforeach?>

          </ul>
     
          </div>
        </div>
      </div>


    </main>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/app.js"></script>
</body>
</html>
