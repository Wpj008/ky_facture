<?php
 session_start();

require_once "../functions/customers.php"; 
require_once "../functions/factures.php";

require_once "../functions/users.php";

 checkLogin();

if(isset($_GET['id']) && !empty($_GET['id'])){
$id = $_GET['id'];

}else{
        echo "Aucun identifiant de client fourni.";

}


$customer = getCustomerById($id);
$factures = getFacturesByCustomer($id);
?>


<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Studio Lumière — Factura</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="../assets/css/style.css" rel="stylesheet">
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
      <nav class="cluster-2 mb-4 text-secondary text-small"><a href="customer.php" class="text-secondary">Clients</a><i class="bi bi-chevron-right text-xs"></i><span class="fw-medium" style="color:var(--color-text)"><?= $customer['lastname_customer'] ?> <?= $customer['firstname_customer'] ?></span></span></nav>

      <div class="page-header">
        <div class="cluster">
          <span class="avatar avatar--lg">SL</span>
          <div>
            <div class="cluster-2"><h1 class="mb-0"><?= $customer['lastname_customer'] ?> <?= $customer['firstname_customer'] ?></h1><span class="badge-ds badge-success">Actif</span></div>
            <p class="mb-0"><?= $customer['ville_customer'] ?>, <?= $customer['code_postal'] ?></p>
          </div>
        </div>
        <div class="cluster-2">
          <button class="btn btn-secondary"><i class="bi bi-pencil"></i> Modifier</button>
          <a href="facture_create.php" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Nouvelle facture</a>
        </div>
      </div>

      <div class="row g-3 section">
        <div class="col-6 col-lg-3"><div class="kpi"><span class="kpi__label">Catégorie</span><div class="kpi__value text-mono" style="font-size:var(--fs-h2)"><?= $customer['type_customer'] ?></div></div></div>
        <div class="col-6 col-lg-3"><div class="kpi"><span class="kpi__label">Factures</span><div class="kpi__value text-mono" style="font-size:var(--fs-h2)">14</div></div></div>
        <div class="col-6 col-lg-3"><div class="kpi"><span class="kpi__label">En attente</span><div class="kpi__value text-mono" style="font-size:var(--fs-h2)">2 400 €</div></div></div>
        <div class="col-6 col-lg-3"><div class="kpi"><span class="kpi__label">Délai paiement moy.</span><div class="kpi__value text-mono" style="font-size:var(--fs-h2)">12 j</div></div></div>
      </div>

      <div class="row g-3">
        <!-- Coordonnées -->
        <div class="col-lg-4">
          <div class="card-ds">
            <div class="card-ds__head"><h3 style="font-size:var(--fs-h4)">Coordonnées</h3></div>
            <ul class="list-unstyled mb-0 stack-3">
              <li class="cluster-2"><i class="bi bi-envelope text-secondary"></i> <?= $customer['email_customer'] ?></li>
              <li class="cluster-2"><i class="bi bi-telephone text-secondary"></i> <?= $customer['phone_customer'] ?></li>
              <li class="cluster-2"><i class="bi bi-geo-alt text-secondary"></i> <?= $customer['adresse_customer'] ?>, <?= $customer['code_postal'] ?> <?= $customer['ville_customer'] ?></li>
              <li class="cluster-2"><i class="bi bi-building text-secondary"></i> Entreprise: <?= $customer['entreprise'] ?></li>
            </ul>
            <hr class="divider">
            <div class="card-ds__head mb-3"><h4 class="mb-0" style="font-size:var(--fs-h5)">Contact principal</h4></div>
            <div class="cell-entity"><span class="avatar avatar--sm">CL</span><div><div class="fw-medium"><?= $customer['firstname_customer'] ?> <?= $customer['lastname_customer'] ?></div><small class="text-secondary">Directrice</small></div></div>
          </div>
        </div>

        <!-- Historique factures -->
        <div class="col-lg-8">
          <div class="table-wrap">
            <div class="table-toolbar"><div class="grow"><h3 class="mb-0" style="font-size:var(--fs-h4)">Historique des factures</h3></div></div>
            <table class="table-ds">
              <thead><tr><th>Facture</th><th>Date</th><th>Montant</th><th>Statut</th></tr></thead>
              <tbody>
                <?php foreach($factures as $facture): ?>
                  <tr data-href="facture-detail.php">
                    <td class="cell-strong"><?= $facture['numero_facture'] ?></td>
                    <td class="cell-muted"><?= $facture['date_creation_facture'] ?></td>
                    <td class="text-mono"><?= $facture['total_ttc'] ?> €</td>
                    <td><span class="badge-ds badge-<?= $facture['id_status_facture'] == 1 ? 'warning' : 'success' ?>"><?= $facture['name_status_facture'] ?></span></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
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
