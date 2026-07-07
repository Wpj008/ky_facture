<?php 
 session_start();

require_once "../functions/paiements.php";

require_once "../functions/users.php";

 checkLogin();

$paiements = getAllPaiements();

?>



<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Paiements — Factura</title>
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

<?php require_once "../partials/sidebar.php" ?>
  <div class="sidebar-backdrop"></div>

  <div class="main">
    <header class="navbar-app">
      <button class="icon-button sidebar-toggle" data-sidebar-toggle aria-label="Menu"><i class="bi bi-list"></i></button>
      <div class="navbar-app__search"><i class="bi bi-search"></i><input type="search" placeholder="Rechercher…"></div>
      <div class="navbar-app__actions"><button class="icon-button" aria-label="Notifications"><i class="bi bi-bell"></i><span class="dot"></span></button><span class="avatar avatar--sm"><i class="bi bi-person-fill"></i></span></div>
    </header>

    <main class="page">
      <div class="page-header">
        <div><h1>Paiements</h1><p>Suivi des encaissements et transactions.</p></div>
        <a href="facture.php" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Enregistrer un paiement</a>
      </div>

      <div class="row g-3 section">
        <div class="col-12 col-lg-4"><div class="kpi"><div class="kpi__top"><span class="kpi__label">Encaissé ce mois</span><span class="kpi__icon kpi__icon--success"><i class="bi bi-cash-stack"></i></span></div><div class="kpi__value text-mono">61 200 €</div><div><span class="kpi__delta kpi__delta--up"><i class="bi bi-arrow-up-short"></i>8 %</span> <span>vs mois dernier</span></div></div></div>
        <div class="col-6 col-lg-4"><div class="kpi"><div class="kpi__top"><span class="kpi__label">En attente</span><span class="kpi__icon kpi__icon--warning"><i class="bi bi-hourglass-split"></i></span></div><div class="kpi__value text-mono">18 000 €</div><div><span class="text-secondary">9 factures</span></div></div></div>
        <div class="col-6 col-lg-4"><div class="kpi"><div class="kpi__top"><span class="kpi__label">Délai moyen</span><span class="kpi__icon kpi__icon--info"><i class="bi bi-speedometer2"></i></span></div><div class="kpi__value text-mono">14 j</div><div><span class="text-secondary">de règlement</span></div></div></div>
      </div>

      <div class="table-wrap" data-paginate="#paiementsTable" data-per-page="8">
        <div class="table-toolbar">
          <div class="navbar-app__search grow" style="max-width:320px"><i class="bi bi-search"></i><input type="search" data-table-search="#paiementsTable" placeholder="Rechercher un paiement…"></div>
          <div class="cluster-2" data-filter-group="#paiementsTable">
            <button class="page-btn active" data-filter-value="all">Tous</button>
            <button class="page-btn" data-filter-value="virement">Virement</button>
            <button class="page-btn" data-filter-value="carte">Carte</button>
          </div>
        </div>
        <table class="table-ds" id="paiementsTable">
          <thead><tr><th>Référence</th><th>Client</th><th>Facture</th><th>Méthode</th><th>Date</th><th>Montant</th></tr></thead>
 
          <tbody>

          <?php foreach ($paiements as $paiement): ?>
            <tr data-status="Virement">
                <td class="cell-strong"><?= $paiement['reference_paiement'] ?></td>
                <td><div class="cell-entity"><span class="avatar avatar--sm"><i class="bi bi-person-fill"></i></span> <?= $paiement['firstname_customer'] ?> <?= $paiement['lastname_customer'] ?></div></td>
                <td class="cell-muted"><?= $paiement['reference_facture'] ?></td>
                <td><span class="badge-ds badge-paiement-<?= $paiement['id_mode_paiement']; ?> no-dot"><i class="bi bi-bank"></i><?= $paiement['name_mode_paiement']; ?></span></td>
                <td class="cell-muted"><?= $paiement['date_paiement'] ?></td>
                <td class="text-mono fw-semibold state-success">+<?= number_format($paiement['montant_paiement'], 2, ',', ' ') ?> €</td>
            </tr>
 
            <?php endforeach; ?>
      
        </table>
        <div class="empty-state" data-empty-for="paiementsTable" style="display:none"><span class="empty-state__icon"><i class="bi bi-search"></i></span><h3>Aucun résultat</h3><p>Aucun paiement ne correspond à votre recherche.</p></div>
        <div class="pagination-ds"><span class="pagination-ds__info" data-page-info></span><div class="pagination-ds__pages" data-page-buttons></div></div>
      </div>
    </main>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/app.js"></script>
</body>
</html>
