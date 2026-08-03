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







if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update_customer'])){


    if (isset($_POST["id"],$_POST["type_customer"],$_POST["lastname_customer"],$_POST["firstname_customer"],$_POST["entreprise"],$_POST["adresse_customer"],$_POST["ville_customer"],$_POST["code_postal"], $_POST["phone_customer"],$_POST["email_customer"])){
           
        
        if(!empty($_POST["type_customer"]) && !empty($_POST["lastname_customer"]) && !empty($_POST["firstname_customer"]) && !empty($_POST["adresse_customer"]) && !empty($_POST["ville_customer"]) && !empty($_POST["code_postal"]) && !empty($_POST["phone_customer"]) && !empty($_POST["email_customer"])){
       
       
        $id_customer = htmlspecialchars($_POST["id"]);

        $type_customer = htmlspecialchars($_POST["type_customer"]);
        $lastname_customer = htmlspecialchars($_POST["lastname_customer"]);
        $firstname_customer = htmlspecialchars($_POST["firstname_customer"]);
        $entreprise = htmlspecialchars($_POST["entreprise"]);
        $adresse_customer = htmlspecialchars($_POST["adresse_customer"]);
        $ville_customer = htmlspecialchars($_POST["ville_customer"]);
        $code_postal = htmlspecialchars($_POST["code_postal"]);
        $phone_customer = htmlspecialchars($_POST["phone_customer"]);
        $email_customer = htmlspecialchars($_POST["email_customer"]);

       
            updateCustomer($id_customer,$type_customer,$lastname_customer,$firstname_customer,$entreprise,$adresse_customer,$ville_customer,$code_postal,$phone_customer,$email_customer );

            header("Location: ../pages/customer.php");
            exit();
       
    } else{
        $error = "La modification a échoué.";
    }
  
}
    else{
        $error = "Veuillez remplir tous les champs obligatoires.";
    }
}

?>
