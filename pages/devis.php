<?php
 session_start();

 require_once "../functions/users.php";

require_once "../functions/devis.php";

 checkLogin();

 $devis = getAllDevis();


?>




<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Devis — Factura</title>
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
        <div><h1>Devis</h1><p>37 devis · suivez vos propositions commerciales.</p></div>
        <a href="devis_create.php" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Nouveau devis</a>
      </div>

      <div class="row g-3 section">
        <div class="col-6 col-lg-3"><div class="kpi"><span class="kpi__label">Total devis</span><div class="kpi__value text-mono" style="font-size:var(--fs-h2)">37</div></div></div>
        <div class="col-6 col-lg-3"><div class="kpi"><span class="kpi__label">En attente</span><div class="kpi__value text-mono" style="font-size:var(--fs-h2)">7</div></div></div>
        <div class="col-6 col-lg-3"><div class="kpi"><span class="kpi__label">Acceptés</span><div class="kpi__value text-mono" style="font-size:var(--fs-h2)">24</div></div></div>
        <div class="col-6 col-lg-3"><div class="kpi"><span class="kpi__label">Taux d'accept.</span><div class="kpi__value text-mono" style="font-size:var(--fs-h2)">68%</div></div></div>
      </div>

      <div class="table-wrap" data-paginate="#devisTable" data-per-page="8">
        <div class="table-toolbar">
          <div class="navbar-app__search grow" style="max-width:320px"><i class="bi bi-search"></i><input type="search" data-table-search="#devisTable" placeholder="Rechercher un devis…"></div>
          <div class="cluster-2" data-filter-group="#devisTable">
            <button class="page-btn active" data-filter-value="all">Tous</button>
            <button class="page-btn" data-filter-value="attente">En attente</button>
            <button class="page-btn" data-filter-value="accepte">Acceptés</button>
            <button class="page-btn" data-filter-value="refuse">Refusés</button>
          </div>
        </div>
        <table class="table-ds" id="devisTable">
          <thead><tr><th>Devis</th><th>Client</th><th>Date</th><th>Montant</th><th>Statut</th><th>Action</th></tr></thead>

          <tbody>

          <?php foreach($devis as $dev):?>
            <tr data-status="attente">
                <td class="cell-strong"><?= $dev['numero_devis'] ?></td>
                <td><div class="cell-entity"><span class="avatar avatar--sm"><i class="bi bi-person-fill"></i></span><?= $dev['firstname_customer']. ' '. $dev['lastname_customer'] ?></div></td>
                <td class="cell-muted"><?= $dev['date_creation_devis'] ?></td>
                <td class="text-mono"><?= $dev['total_ttc'] ?> €</td>
                <td><span class="badge-ds badge-devis-<?= $dev['id_status_devis']; ?>"> <?= $dev['name_status_devis']; ?></span></td>
                <td class="cell-actions"><a class="icon-button btn-lm" href="detail_devis.php?id=<?= $dev['id_devis']; ?>"><i class="bi bi-eye"></i></a></td>
                <?php endforeach ?>
          </tbody>
   
        </table>
        <div class="empty-state" data-empty-for="devisTable" style="display:none"><span class="empty-state__icon"><i class="bi bi-search"></i></span><h3>Aucun résultat</h3><p>Aucun devis ne correspond à votre recherche.</p></div>
        <div class="pagination-ds"><span class="pagination-ds__info" data-page-info></span><div class="pagination-ds__pages" data-page-buttons></div></div>
      </div>
    </main>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/app.js"></script>
</body>
</html>
