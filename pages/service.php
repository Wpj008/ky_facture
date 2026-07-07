<?php 
 session_start();

require_once "../functions/services.php";
require_once "../functions/users.php";

 checkLogin();

$services = getAllServices();

?>



<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Services — Factura</title>
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
      <div class="page-header">
        <div><h1>Services &amp; prestations</h1><p>Votre catalogue réutilisable dans les devis et factures.</p></div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newServiceModal"><i class="bi bi-plus-lg"></i> Nouveau service</button>
      </div>

      <div class="row g-3 stagger">


      <?php foreach ($services as $service): ?>


      <div class="col-md-6 col-xl-4">
        <div class="card-ds card-ds--hover h-100">
            <div class="card-ds__head">
                <span class="kpi__icon"><i class="bi bi-code-slash"></i></span>
                <div class="dropdown">
                    <button class="icon-button btn-sm" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-pencil"></i> Modifier</a></li><li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash"></i> Supprimer</a></li>
                    </ul>
                </div>
              </div>
            <h3 style="font-size:var(--fs-h4)"><?= $service['name_service'] ?></h3>
          <p class="text-secondary"><?= $service['description_service'] ?></p>
        <div class="cluster-2 justify-content-between"><span class="text-mono fw-semibold" style="font-size:var(--fs-h4)"><?= (int) $service['tarif_unitaire'] ?> €</span><span class="badge-ds badge-neutral no-dot"><?= $service['type_tarif'] ?></span></div>
    </div>
    </div>

    <?php endforeach; ?>


       </div>
    </main>
  </div>
</div>

<div class="modal fade" id="newServiceModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Nouveau service</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">

      <form action="../traitements/traitement_service.php" method="POST">

        <div class="form-group"><label class="form-label">Intitulé <span class="req">*</span></label><input class="form-control-ds" placeholder="Ex. Développement web" name="intitule" required></div>
        <div class="form-group"><label class="form-label">Description</label><textarea class="form-control-ds" placeholder="Décrivez la prestation…" name="description" rounded-end></textarea></div>
        <div class="row">
          <div class="col-6 form-group"><label class="form-label">Tarif (€)</label><input class="form-control-ds" type="number" placeholder="650" name="tarif" required></div>
          <div class="col-6 form-group"><label class="form-label">Unité</label>
          <select class="form-select-ds" name="unite" required>
            <option value="forfait">forfait</option>
            <option value="jour">par jour</option>
            <option value="heure">par heure</option>
            <option value="mois">par mois</option>
          </select></div>
        </div>

        <div class="modal-footer">
        <button type="submit" name="submit" class="btn btn-primary" data-bs-dismiss="modal" >Enregistrer</button>

        </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-ghost" data-bs-dismiss="modal">Annuler</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/app.js"></script>
</body>
</html>
