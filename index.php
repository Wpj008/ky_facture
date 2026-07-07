<?php

?>




<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion — KY-Facture</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="assets/favicon/site.webmanifest">
</head>
<body>
  <main class="auth">
    <!-- Colonne formulaire -->
    <section class="auth__form-side">
      <div class="auth__form animate-fade-up">

        <img src="assets/img/Logo-11.png" alt="KY-Facture" class="logo-facture" style="width:150px; margin:0 auto 15px; display:block;">
    
     

        <div class="mt-5 mb-4">
          <h1>Connexion</h1>
          <p class="text-secondary mb-0">Connectez-vous pour accéder à votre espace de facturation.</p>
        </div>

        <form method="POST" action="traitements/traitement_login.php" >
          <div class="form-group">
            <label class="form-label">Adresse email</label>
            <div class="input-icon">
              <i class="bi bi-envelope"></i>
              <input type="email" name="email" class="form-control-ds" placeholder="vous@entreprise.fr" value="" required>
            </div>
          </div>
          <div class="form-group">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <label class="form-label mb-0">Mot de passe</label>
              <a href="#" class="text-small fw-medium">Mot de passe oublié ?</a>
            </div>
            <div class="input-icon">
              <i class="bi bi-lock"></i>
              <input type="password" name="password" class="form-control-ds" placeholder="••••••••" value="" required>
            </div>
          </div>
          <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" id="remember">
            <label class="form-check-label text-secondary" for="remember">Rester connecté sur cet appareil</label>
          </div>

          <button type="submit" name="submit"  class="btn btn-primary btn-lg btn-block"> Se connecter </button>

      

        </form>

      </div>
    </section>

    <!-- Colonne visuelle (vitrine produit) -->
    <aside class="auth__brand-side">
  <div class="auth__brand-content">

    <span class="badge-ds badge-primary no-dot mb-4" style="background:rgba(255,255,255,.14);color:#fff">
      <i class="bi bi-receipt-cutoff"></i> KY-Facture </span>

    <h2 class="auth__brand-title">
      Centralisez vos devis, factures et paiements.
    </h2>

    <p class="auth__brand-text">
      Gérez vos clients, créez vos devis et factures, enregistrez vos paiements et suivez votre activité depuis une interface simple et intuitive.
    </p>

    <div class="auth__preview card-ds">

      <div class="card-ds__head">
        <div class="kpi__label">Aperçu de votre activité</div>
        <span class="badge-ds badge-success">Ce mois</span>
      </div>

<div class="stack-3 mt-4">

<div class="d-flex justify-content-between align-items-center">
    <span style="color:#374151;">Factures émises</span>
    <strong style="color:#111827;">18</strong>
</div>

<div class="d-flex justify-content-between align-items-center">
    <span style="color:#374151;">Devis créés</span>
    <strong style="color:#111827;">7</strong>
</div>

<div class="d-flex justify-content-between align-items-center">
    <span style="color:#374151;">Paiements reçus</span>
    <strong style="color:#111827;">15</strong>
</div>


</div>

    </div>

    <div class="auth__logos">
      <span><i class="bi bi-file-earmark-text"></i> Devis & Factures</span>
      <span><i class="bi bi-credit-card"></i> Paiements</span>
      <span><i class="bi bi-file-earmark-pdf"></i> Export PDF</span>
    </div>

  </div>
</aside>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/app.js"></script>
</body>
</html>
