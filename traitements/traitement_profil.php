<?php
session_start();

require_once "../functions/users.php";
require_once "../functions/profil.php";

$id = $_SESSION['user_id'];



if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update_profile'])){

        if(isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email'])){

            if(!empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['email'])){

        $firstname = htmlspecialchars($_POST['firstname']);
        $lastname  = htmlspecialchars($_POST['lastname']);
        $email     = htmlspecialchars($_POST['email']);

        UpdateUserProfile( $id, $firstname, $lastname, $email);

            }else{
                die("Veuillez remplir tous les champs.");
            }

        header("Location: ../pages/profil.php");
        exit();
        }
}



if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update_password'])){

        if(isset($_POST['current_password']) && isset($_POST['new_password']) && isset($_POST['confirm_password'])){

            if(!empty($_POST['current_password']) && !empty($_POST['new_password']) && !empty($_POST['confirm_password'])){


            $currentPassword = $_POST['current_password'];
            $newPassword     = $_POST['new_password'];
            $confirmPassword = $_POST['confirm_password'];

            $user = getUserById($id);

            if(!password_verify($currentPassword, $user['password'])){
       
                die("Le mot de passe actuel est incorrect.");
            }

            if($newPassword !== $confirmPassword){
                die("Les nouveaux mots de passe ne correspondent pas.");
            }

            $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);

            UpdatePassword($id, $passwordHash);

            header("Location: ../index.php");
            exit();


            }else{
                die("Veuillez remplir tous les champs.");
            }

        } 
}


?>

