<?php
 session_start();

 require_once "../functions/users.php";

 checkLogin();

 $roles = getRole();

$users = getAllUsers(); 

?>




<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Clients — Factura</title>
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
      <div class="navbar-app__actions">
        <button class="icon-button" aria-label="Notifications"><i class="bi bi-bell"></i><span class="dot"></span></button>
        <span class="avatar avatar--sm"><i class="bi bi-person-fill"></i></span>
      </div>
    </header>

    <main class="page">
      <div class="page-header">
        <div><h1>Employés</h1><p>58 employés actifs · gérez vos contacts et leur historique.</p></div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newClientModal"><i class="bi bi-plus-lg"></i> Nouvel employé</button>
      </div>

      <div class="table-wrap" data-paginate="#clientsTable" data-per-page="8">
        <div class="table-toolbar">
          <div class="navbar-app__search grow" style="max-width:320px"><i class="bi bi-search"></i><input type="search" data-table-search="#clientsTable" placeholder="Rechercher un client…"></div>
          <div class="cluster-2" data-filter-group="#clientsTable">
            <button class="page-btn active" data-filter-value="all">Tous</button>
            <button class="page-btn" data-filter-value="actif">Actifs</button>
            <button class="page-btn" data-filter-value="inactif">Inactifs</button>
          </div>
          <button class="btn btn-secondary btn-sm"><i class="bi bi-funnel"></i> Filtres</button>
        </div>
        <table class="table-ds" id="clientsTable">
          <thead><tr><th>Employé</th><th>Email</th><th>Factures</th><th>Fonction</th><th>Statut</th><th></th></tr></thead>

          <tbody>
          <?php foreach($users as $user): ?>
         
            <tr data-href="client-detail.php" data-status="actif">
                <td><div class="cell-entity"><span class="avatar avatar--sm"><i class="bi bi-person-fill"></i></span><div><div class="cell-strong"><?= $user['lastname_user'] ?> <?= $user['firstname_user'] ?></div><small class="text-secondary"></small></div></div></td>
                <td class="cell-muted"><?= $user['email_user'] ?></td>
                <td>-</td><td class="text-mono"><?= $user['name_role'] ?></td>
                <td><span class="badge-ds badge-success">Actif</span></td>
                <td class="cell-actions"><a href="detail_employer.php?id=<?= $user['id_user'] ?>" class="icon-button btn-lm"><i class="bi bi-eye"></i></a></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
         
        </table>
        <div class="empty-state" data-empty-for="clientsTable" style="display:none">
          <span class="empty-state__icon"><i class="bi bi-search"></i></span>
          <h3>Aucun résultat</h3><p>Aucun client ne correspond à votre recherche.</p>
        </div>
        <div class="pagination-ds">
          <span class="pagination-ds__info" data-page-info></span>
          <div class="pagination-ds__pages" data-page-buttons></div>
        </div>
      </div>
    </main>
  </div>
</div>

<!-- Modale nouveau client -->


<div class="modal fade" id="newClientModal" tabindex="-1" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">

        <div class="modal-header">
            <h5 class="modal-title">Nouvel employé</h5>
            <button class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>

        <div class="modal-body">

            <div class="row">

            <form action="../traitements/traitement_register.php" method="POST">

<div class="row">

    <div class="col-md-6 form-group">
        <label class="form-label">
            Prénom <span class="req">*</span>
        </label>

        <input
            type="text"
            class="form-control-ds"
            name="firstname"
            placeholder="Jean"
            required>
    </div>

    <div class="col-md-6 form-group">
        <label class="form-label">
            Nom <span class="req">*</span>
        </label>

        <input
            type="text"
            class="form-control-ds"
            name="lastname"
            placeholder="Dupont"
            required>
    </div>

    <div class="col-md-12 form-group">
        <label class="form-label">
            Email <span class="req">*</span>
        </label>

        <input
            type="email"
            class="form-control-ds"
            name="email"
            placeholder="contact@email.fr"
            required>
    </div>

    <div class="col-md-12 form-group">

        <label class="form-label">
            Rôle <span class="req">*</span>
        </label>

        <select
            class="form-control-ds"
            name="fonction"
            required>

            <option value="">Sélectionnez un rôle</option>

            <?php foreach($roles as $role): ?>

                <option value="<?= $role['id_role'] ?>">
                    <?= $role['name_role'] ?>
                </option>

            <?php endforeach; ?>

        </select>

    </div>

</div>

<div class="modal-footer">

    <button
        type="button"
        class="btn btn-ghost"
        data-bs-dismiss="modal">

        Annuler

    </button>

    <button
        type="submit"
        name="submit"
        class="btn btn-primary">

        Créer le compte

    </button>

</div>

</form>
            

    </div>
</div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/app.js"></script>
</body>
</html>
