<?php
session_start();

require_once "../functions/customers.php"; 

require_once "../functions/users.php";

 checkLogin();




if(isset($_GET['id']) && !empty($_GET['id'])){
$id = $_GET['id'];

}else{
        echo "Aucun identifiant de client fourni.";

}

$customer = getCustomerById($id);




 ?>




<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Modifier un client | KY-Facture</title>

    <!-- Bootstrap -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"  rel="stylesheet">
     
    <link href="../assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/updating.css">
    <link rel="stylesheet" href="../assets/css/update_profile.css">
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="../assets/favicon/site.webmanifest">

    <style>

        body{
            background:#f5f7fb;
            font-family:Segoe UI,Tahoma,Geneva,Verdana,sans-serif;
        }

        .main-content{
            padding:40px;
        }

        .container-form{
            max-width:1100px;
            margin:auto;
        }

        .page-header{
            margin-bottom:35px;
        }

        .page-header h2{
            font-weight:700;
        }

        .page-header p{
            color:#6c757d;
            margin-bottom:0;
        }

        .card-form{
            background:#fff;
            border-radius:16px;
            padding:30px;
            border:1px solid #e9ecef;
            box-shadow:0 5px 18px rgba(0,0,0,.05);
            margin-bottom:25px;
        }

        .card-form h4{
            margin-bottom:25px;
            padding-bottom:15px;
            border-bottom:1px solid #ececec;
            font-size:1.15rem;
            font-weight:600;
        }

        .form-label{
            font-weight:600;
        }

        .form-control,
        .form-select{
            height:48px;
            border-radius:10px;
        }

        textarea.form-control{
            min-height:120px;
        }

        .form-actions{
            display:flex;
            justify-content:flex-end;
            gap:15px;
            margin-top:30px;
            flex-wrap:wrap;
        }

        .form-actions .btn{
            min-width:180px;
        }

        @media(max-width:768px){

            .main-content{
                padding:20px;
            }

            .form-actions{
                flex-direction:column;
            }

            .form-actions .btn{
                width:100%;
            }

        }

    </style>

</head>

<body>

<main class="main-content">

<div class="app-shell">

<?php require_once "../partials/sidebar.php" ?>

<div class="container-form">

<div class="page-header">

<h2>

<i class="bi bi-people-fill"></i>

Modifier le profil 

</h2>

<p>

Modification des informations du client.

</p>

</div>

        <form method="POST" action="../traitements/traitement_profil.php?" class="profile-form">

        <!-- Informations générales -->

        <div class="card-form">

        <h4>

        Informations générales

        </h4>

        <div class="row g-4">

         <div class="col-md-4">

             <label class="form-label"> Type de client </label>

            <select class="form-select" name="type_customer">

            <option
                value="Particulier"
                <?= $customer["type_customer"] == "Particulier" ? "selected" : "" ?>>
                Particulier
            </option>

            <option
                value="Entreprise"
                <?= $customer["type_customer"] == "Entreprise" ? "selected" : "" ?>>
                Entreprise
            </option>

            </select>

        </div>

        <div class="col-md-4">

        <label class="form-label">

        Nom

        </label>

        <input type="hidden" name="id" value="<?= $customer['id_customer']; ?>">
        <input type="text" class="form-control" name="lastname_customer" value="<?= $customer['lastname_customer']; ?>">

        </div>

        <div class="col-md-4">

        <label class="form-label">

        Prénom

        </label>

        <input type="text" class="form-control" name="firstname_customer" value="<?= $customer['firstname_customer']; ?>">

        </div>

        <div class="col-md-12">

        <label class="form-label">

        Entreprise

        </label>

        <input type="text" class="form-control" name="entreprise" value="<?= $customer['entreprise']; ?>">

        </div>

        </div>

        </div>

        <!-- Coordonnées -->

        <div class="card-form">

        <h4>

        Coordonnées

        </h4>

        <div class="row g-4">

        <div class="col-md-6">

        <label class="form-label">

        Adresse

        </label>

        <input type="text" class="form-control" name="adresse_customer" value="<?= $customer['adresse_customer']; ?>">

        </div>

        <div class="col-md-3">

        <label class="form-label">

        Ville

        </label>

        <input type="text" class="form-control" name="ville_customer" value="<?= $customer['ville_customer']; ?>">

        </div>

        <div class="col-md-3">

        <label class="form-label">

        Code postal

        </label>

        <input type="text" class="form-control" name="code_postal" value="<?= $customer['code_postal']; ?>">

        </div>

        <div class="col-md-6">

        <label class="form-label">

        Téléphone

        </label>

        <input type="text" class="form-control" name="phone_customer" value="<?= $customer['phone_customer']; ?>">

        </div>

        <div class="col-md-6">

        <label class="form-label">

        Adresse email

        </label>

        <input type="email" class="form-control" name="email_customer" value="<?= $customer['email_customer']; ?>">

        </div>

        </div>

        </div>

     

        <!-- Boutons -->

        <div class="form-actions">

        <a href="customer.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Retour</a>

    
        <button name="update_customer" type="submit" class="btn btn-success"><i class="bi bi-floppy"></i> Enregistrer les modifications </button>

        </div>

        </form>

        </div>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>