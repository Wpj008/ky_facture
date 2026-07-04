<?php
session_start();

require_once "../functions/profil.php";
require_once "../functions/users.php";

 checkLogin();

$id = $_SESSION["user_id"];

$profil = getUserById($id);

?>



<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mon profil — Factura</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="../assets/css/style.css" rel="stylesheet">
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
      <div class="page-header"><div><h1>Mon profil</h1><p>Gérez vos informations personnelles et votre sécurité.</p></div></div>

      <div class="row g-3">
        <!-- Carte profil -->
        <div class="col-lg-4">
          <div class="card-ds text-center">
            <span class="avatar avatar--lg mx-auto" style="width:88px;height:88px;font-size:var(--fs-h2)"><i class="bi bi-person-fill"></i></span>
            <h3 class="mt-3 mb-1"><?= $profil['firstname_user'] . ' ' . $profil['lastname_user'] ?></h3>
            <p class="text-secondary mb-3"><?= $profil['name_role'] ?></p>
            <span class="badge-ds badge-primary mx-auto">Compte vérifié</span>
            <hr class="divider">
            <div class="stack-3 text-start">
              <div class="cluster-2"><i class="bi bi-envelope text-secondary"></i> <?= $profil['email_user'] ?></div>
              <div class="cluster-2"><i class="bi bi-building-fill text-secondary"></i></i>KY-Facture</div>
              <div class="cluster-2"><i class="bi bi-person-badge-fill text-secondary"></i><?= $profil['name_role'] ?> </div>
            </div>
          </div>
        </div>

        <!-- Formulaires -->
        <div class="col-lg-8">
          <div class="card-ds mb-3">
            <div class="card-ds__head"><h3 style="font-size:var(--fs-h4)">Informations personnelles</h3></div>
            
            <form action="../traitements/traitement_profil.php" method="POST">
            <div class="row">

              <div class="col-md-6 form-group"><label class="form-label">Prénom</label><input name="firstname" accordion class="form-control-ds" value="<?= $profil['firstname_user'] ?>"></div>
              <div class="col-md-6 form-group"><label class="form-label">Nom</label><input name="lastname" class="form-control-ds" value="<?= $profil['lastname_user'] ?>"></div>
              <div class="col-md-6 form-group"><label class="form-label">Email</label><div class="input-icon"><i class="bi bi-envelope"></i><input name="email" class="form-control-ds" value="<?= $profil['email_user'] ?>"></div></div>
       
             
            </div>
            <div class="cluster-2 justify-content-end"><button type="submit" name="update_profile" class="btn btn-primary">Enregistrer</button></div>
            </form>
          </div>

          <div class="card-ds">

          <form action="../traitements/traitement_profil.php" method="POST">
            <div class="card-ds__head"><h3 style="font-size:var(--fs-h4)">Sécurité</h3></div>
            <div class="row">
              <div class="col-md-6 form-group"><label class="form-label">Mot de passe actuel</label><div class="input-icon"><i class="bi bi-lock"></i><input name="current_password" type="password" class="form-control-ds" value=""></div></div>
              <div class="col-md-6"></div><div class="col-md-6 form-group"><label class="form-label">Nouveau mot de passe</label><div class="input-icon"><i class="bi bi-lock"></i><input type="password" class="form-control-ds" id="new_password" name="new_password" placeholder="••••••••" required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&.#_\-])[A-Za-z\d@$!%*?&.#_\-]{8,}$"></div>

                 <small class="text-secondary">
                              8 caractères minimum avec une majuscule, une minuscule, un chiffre et un caractère spécial.
                 </small>
                </div>
              <div class="col-md-6 form-group"><label class="form-label">Confirmer</label><div class="input-icon"><i class="bi bi-lock"></i><input name="confirm_password" type="password" class="form-control-ds" placeholder="••••••••"></div></div>
            </div>
            <div class="alert-ds alert-info"><i class="bi bi-shield-check"></i><div class="alert-ds__body"><strong>Authentification à deux facteurs</strong><p>Renforcez la sécurité de votre compte. <a href="#" class="fw-semibold">Activer</a></p></div></div>
            <div class="cluster-2 justify-content-end mt-4"><button type="submit" name="update_password" class="btn btn-primary" >Mettre à jour</button></div>
          
          </form>
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
