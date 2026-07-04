<?php
 session_start();

require_once "../functions/factures.php";

require_once "../functions/users.php";

 checkLogin();

$factures = getAllFactures();


?>



<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Factures — Factura</title>
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
        <div><h1>Factures</h1><p>142 factures émises · suivez les encaissements.</p></div>
        <a href="facture_create.php" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Nouvelle facture</a>
      </div>

      <div class="row g-3 section">
        <div class="col-6 col-lg-3"><div class="kpi"><span class="kpi__label">Total facturé</span><div class="kpi__value text-mono" style="font-size:var(--fs-h2)">84 320 €</div></div></div>
        <div class="col-6 col-lg-3"><div class="kpi"><span class="kpi__label">Encaissé</span><div class="kpi__value text-mono state-success" style="font-size:var(--fs-h2)">61 200 €</div></div></div>
        <div class="col-6 col-lg-3"><div class="kpi"><span class="kpi__label">En attente</span><div class="kpi__value text-mono state-warning" style="font-size:var(--fs-h2)">18 000 €</div></div></div>
        <div class="col-6 col-lg-3"><div class="kpi"><span class="kpi__label">En retard</span><div class="kpi__value text-mono state-error" style="font-size:var(--fs-h2)">5 120 €</div></div></div>
      </div>

      <div class="table-wrap" data-paginate="#facturesTable" data-per-page="8">
        <div class="table-toolbar">
          <div class="navbar-app__search grow" style="max-width:320px"><i class="bi bi-search"></i><input type="search" data-table-search="#facturesTable" placeholder="Rechercher une facture…"></div>
          <div class="cluster-2" data-filter-group="#facturesTable">
            <button class="page-btn active" data-filter-value="all">Toutes</button>
            <button class="page-btn" data-filter-value="payee">Payées</button>
            <button class="page-btn" data-filter-value="attente">En attente</button>
            <button class="page-btn" data-filter-value="retard">En retard</button>
          </div>
          <button class="btn btn-secondary btn-sm"><i class="bi bi-download"></i> Exporter</button>
        </div>
        <table class="table-ds" id="facturesTable">
          <thead><tr><th>Facture</th><th>Client</th><th>Échéance</th><th>Montant</th><th>Statut</th><th>Action</th></tr></thead>
          <tbody>

          <?php foreach ($factures as $facture): ?>
          <tr data-href="facture-detail.php" data-status="attente">
            <td class="cell-strong"><?= $facture['numero_facture']; ?></td>
            <td><div class="cell-entity">
                <span class="avatar avatar--sm"><i class="bi bi-person-fill"></i></span> <?= $facture['firstname_customer'] . ' ' . $facture['lastname_customer']; ?></div>
            </td><td class="cell-muted"><?= $facture['date_echeance_facture']; ?></td><td class="text-mono"> <?= $facture['total_ttc']; ?> €</td>
            <td><span class="badge-ds badge-facture-<?= $facture['id_status_facture']; ?>"> <?= $facture['name_status_facture']; ?></span></td>
            <td class="cell-actions"><a class="icon-button btn-lm" href="detail_facture.php?id=<?= $facture['id_facture']; ?>"><i class="bi bi-eye"></i></a></td>
        </tr>

        <?php endforeach ?>
          </tbody>

        </table>
        <div class="empty-state" data-empty-for="facturesTable" style="display:none"><span class="empty-state__icon"><i class="bi bi-search"></i></span><h3>Aucun résultat</h3><p>Aucune facture ne correspond à votre recherche.</p></div>
        <div class="pagination-ds"><span class="pagination-ds__info" data-page-info></span><div class="pagination-ds__pages" data-page-buttons></div></div>
      </div>
    </main>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/app.js"></script>
</body>
</html>
