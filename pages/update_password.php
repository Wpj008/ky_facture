<?php
session_start();


if (!isset($_SESSION["user_id"])) {
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Modification du mot de passe — Factura</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
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



            <div class="main">


            <main class="page">

            <div class="page-header">

            <div>

            <h1>Modification obligatoire du mot de passe</h1>

            <p>
            Pour des raisons de sécurité, vous devez modifier votre mot de passe
            avant d'accéder à l'application.
            </p>

            </div>

            </div>

            <div class="row justify-content-center">

            <div class="col-lg-6">

            <div class="card-ds">

            <div class="card-ds__head">

            <h3 style="font-size:var(--fs-h4)">
            <i class="bi bi-shield-lock"></i>
            Nouveau mot de passe
            </h3>

            </div>

            <form action="../traitements/traitement_profil.php" method="POST" id="passwordForm">

            <div class="form-group">

            <label class="form-label">Mot de passe actuel</label>

            <div class="input-icon">

            <i class="bi bi-lock"></i>

            <input type="password" class="form-control-ds" name="current_password" value="123456" readonly>

            </div>

            </div>

            <div class="form-group mt-3">

            <label class="form-label"> Nouveau mot de passe </label>

            <div class="input-icon">

            <i class="bi bi-lock"></i>

            <input type="password" id="new_password" name="new_password" class="form-control-ds" required>

            </div>

            <small class="text-secondary">

            Le mot de passe doit contenir :

            <ul class="mt-2 mb-0">

            <li>8 caractères minimum</li>
            <li>Une majuscule</li>
            <li>Une minuscule</li>
            <li>Un chiffre</li>
            <li>Un caractère spécial</li>

            </ul>

            </small>

            </div>

            <div class="form-group mt-3">

            <label class="form-label">
            Confirmation
            </label>

            <div class="input-icon">

            <i class="bi bi-lock-fill"></i>

            <input type="password" id="confirm_password" name="confirm_password" class="form-control-ds" required>

            </div>

            </div>

            <div class="cluster-2 justify-content-end mt-4">

            <button type="submit" name="update_password" class="btn btn-primary">

            <i class="bi bi-check-circle"></i>

            Mettre à jour le mot de passe

            </button>

            </div>

            </form>

            </div>

            </div>

            </div>

            </main>

            </div>

            </div>

<script>

const form = document.getElementById("passwordForm");

const password = document.getElementById("new_password");

const confirmPassword = document.getElementById("confirm_password");

const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&.#_\-])[A-Za-z\d@$!%*?&.#_\-]{8,}$/;

form.addEventListener("submit", function(e){

    if(!regex.test(password.value)){

        alert("Le mot de passe doit contenir au minimum 8 caractères avec une majuscule, une minuscule, un chiffre et un caractère spécial.");

        e.preventDefault();

        return;

    }

    if(password.value === "123456"){

        alert("Vous devez choisir un nouveau mot de passe.");

        e.preventDefault();

        return;

    }

    if(password.value !== confirmPassword.value){

        alert("Les mots de passe ne correspondent pas.");

        e.preventDefault();

    }

});

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/app.js"></script>

</body>

</html>