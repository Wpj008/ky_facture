<?php
session_start();

require_once "../functions/users.php";

checkLogin();

if(isset($_GET['id']) && !empty($_GET['id'])){

    $user_id = $_GET['id'];

}else{

    die("Aucun employé trouvé.");

}

$employee = getUserDeleteInfos($user_id);

/*
echo "<pre>";
var_dump($employee);
echo "</pre>";
die();
*/
?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Supprimer un employé</title>

    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/delete.css">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body>

<style>

.sidebar-backdrop{
    position:fixed;
    inset:0;
    z-index:1200!important;
    background:var(--color-overlay);
    opacity:0;
    visibility:hidden;
    transition:opacity var(--duration-base) var(--ease-standard),visibility var(--duration-base);
}

.sidebar{
    position:fixed;
    top:0;
    left:0;
    bottom:0;
    width:var(--sidebar-width);
    z-index:1300!important;
    display:flex;
    flex-direction:column;
    padding:var(--space-6) var(--space-5);
    background:var(--color-primary);
    color:var(--color-on-primary);
    border-top-right-radius:var(--radius-xl);
    border-bottom-right-radius:var(--radius-xl);
}

</style>

<?php require_once "../partials/sidebar.php"; ?>

<main class="content">

    <div class="page-header">

        <div>

            <h1>Supprimer un employé</h1>

            <p>Confirmez la suppression de cet employé.</p>

        </div>

        <a href="employee.php" class="btn-annuler">

            <i class="bi bi-arrow-left"></i>

            Retour

        </a>

    </div>

    <div class="card delete-card">

        <div class="delete-icon">

            <i class="bi bi-trash3-fill"></i>

        </div>

        <h2>Supprimer cet employé ?</h2>

        <p class="delete-text">

            Cette opération est définitive.
            Toutes les informations liées à cet employé ne pourront plus être récupérées.

        </p>

        <div class="resume">

            <div class="resume-item">
                <span>Nom</span>
                <strong><?= $employee['firstname_user']; ?> <?= $employee['lastname_user']; ?></strong>
            </div>

            <div class="resume-item">
                <span>Email</span>
                <strong><?= $employee['email_user']; ?></strong>
            </div>

            <div class="resume-item">
                <span>Rôle</span>
                <strong><?= $employee['name_role']; ?></strong>
            </div>

            <div class="resume-item">
                <span>Date d'embauche</span>
                <strong><?= date('d/m/Y',strtotime($employee['created_at_user'])); ?></strong>
            </div>

            <div class="resume-item">
                <span>Nombre de devis créés</span>
                <strong><?= $employee['nb_devis']; ?></strong>
            </div>

            <div class="resume-item">
                <span>Nombre de factures créées</span>
                <strong><?= $employee['nb_factures']; ?></strong>
            </div>

            <div class="resume-item">
                <span>Montant total facturé</span>
                <strong><?= number_format($employee['total_factures'],2,',',' '); ?> €</strong>
            </div>

            <div class="resume-item">
                <span>Historiques enregistrés</span>
                <strong><?= $employee['nb_historiques']; ?></strong>
            </div>

            <div class="resume-item">
                <span>Dernière activité</span>
                <strong>
                    <?= $employee['last_activity']
                        ? date('d/m/Y H:i',strtotime($employee['last_activity']))
                        : "Aucune"; ?>
                </strong>
            </div>

        </div>

        <div class="warning">

            <i class="bi bi-exclamation-triangle-fill"></i>

            <span>

                La suppression de cet employé supprimera définitivement son compte.
                Les devis, factures, paiements et historiques déjà créés resteront disponibles uniquement si votre base de données conserve leurs références.

            </span>

        </div>

        <form action="../traitements/traitement_profil.php" method="POST">

            <input type="hidden" name="id_user" value="<?= $employee['id_user']; ?>">

            <div class="actions">

                <a href="employer.php" class="btn-annuler">

                    Annuler

                </a>

                <button type="submit" name="delete_employer" class="btn-delete">

                    <i class="bi bi-trash-fill"></i>

                    Supprimer définitivement

                </button>

            </div>

        </form>

    </div>

</main>

<script src="../assets/js/app.js"></script>

</body>
</html>