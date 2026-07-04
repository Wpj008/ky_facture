<?php

require_once "../functions/users.php";

$id = $_SESSION["user_id"];

$profil = getUserById($id);

?>


<?php if(isset($_SESSION['role']) && $_SESSION['role'] == 1):?>
<aside class="sidebar" id="sidebar">
    <a href="dashboard.php" class="sidebar__brand">
      <img src="../assets/img/Logo-11.png" alt="KY-Facture" class="logo-facture" style="width:150px; margin-bottom:15px;">
    </a>
    <nav class="sidebar__nav">
      <span class="sidebar__section-label">Pilotage</span>
      <a href="dashboard.php" class="nav-item active"><i class="bi bi-grid-1x2"></i> Tableau de bord</a>
      <a href="customer.php" class="nav-item"><i class="bi bi-people"></i> Clients</a>
      <a href="service.php" class="nav-item"><i class="bi bi-box-seam"></i> Services</a>
      <span class="sidebar__section-label">Facturation</span>
      <a href="devis.php" class="nav-item"><i class="bi bi-file-earmark-text"></i> Devis</a>
      <a href="facture.php" class="nav-item"><i class="bi bi-receipt"></i> Factures</a>
      <a href="paiement.php" class="nav-item"><i class="bi bi-credit-card"></i> Paiements</a>
      <a href="employer.php" class="nav-item"><i class="bi bi-person-gear"></i> Employés</a>
      <span class="sidebar__section-label">Système</span>
      <a href="#" class="nav-item"><i class="bi bi-gear"></i> Paramètres</a>
      <a href="profil.php" class="nav-item"><i class="bi bi-person-workspace"></i> Profil</a>

      <a href="../partials/logout.php" class="nav-item"><i class="bi bi-box-arrow-right"></i> Déconnexion</a>
    </nav>
    <div class="sidebar__footer">
      <div class="sidebar__user">
        <span class="avatar" style="background:rgba(255,255,255,.16);color:#fff"><i class="bi bi-person-fill"></i></span>
        <div class="stack-1"><span class="fw-semibold"><?= $profil['firstname_user'] . ' ' . $profil['lastname_user'] ?></span><small><?= $profil['name_role'] ?></small>
    
       
    
    </div>
      </div>
    </div>
  </aside>

  <?php endif ?>

  <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 2):?>

    <aside class="sidebar" id="sidebar">
    <a href="dashboard.php" class="sidebar__brand">
    <img src="../assets/img/Logo-11.png" alt="KY-Facture" class="logo-facture" style="width:150px; margin-bottom:15px;">
    </a>
    <nav class="sidebar__nav">
      <span class="sidebar__section-label">Pilotage</span>
      <a href="dashboard.php" class="nav-item active"><i class="bi bi-grid-1x2"></i> Tableau de bord</a>
      <a href="customer.php" class="nav-item"><i class="bi bi-people"></i> Clients</a>
     
      <span class="sidebar__section-label">Facturation</span>
      <a href="devis.php" class="nav-item"><i class="bi bi-file-earmark-text"></i> Devis</a>
      <a href="facture.php" class="nav-item"><i class="bi bi-receipt"></i> Factures</a>
      <a href="paiement.php" class="nav-item"><i class="bi bi-credit-card"></i> Paiements</a>
   
      <span class="sidebar__section-label">Système</span>
      <a href="profil.php" class="nav-item"><i class="bi bi-person-workspace"></i> Profil</a>

      <a href="../partials/logout.php" class="nav-item"><i class="bi bi-box-arrow-right"></i> Déconnexion</a>
    </nav>
    <div class="sidebar__footer">
      <div class="sidebar__user">
        <span class="avatar" style="background:rgba(255,255,255,.16);color:#fff"><i class="bi bi-person-fill"></i></span>
        <div class="stack-1"><span class="fw-semibold"><?= $profil['firstname_user'] . ' ' . $profil['lastname_user'] ?></span><small><?= $profil['name_role'] ?></small>
    
       
    
    </div>
      </div>
    </div>
  </aside>



    <?php endif ?>