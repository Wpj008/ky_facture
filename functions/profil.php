<?php
require_once "../functions/database.php";
require_once "../functions/logs.php";



function selectUser($id_user){// function pour selectionner les données d'un utilisateur (pour l'affichage dans le profile)

    try{

        $querySelect = getPDO()->prepare("SELECT * FROM users INNER JOIN roles ON roles.id_role = users.role_id WHERE id_user = $id_user ");

        $querySelect->execute();

        $user = $querySelect->fetch();

        return $user;


    }catch(PDOException $e){

    echo "<p style='color:red;'> Erreur de recuperation </p>".$e->getMessage();

    }
}


    function UpdateUserProfile($id, $firstname, $lastname, $email){

    $query = getPDO()->prepare(" UPDATE users SET firstname_user = :firstname, lastname_user = :lastname, email_user = :email, updated_at_user = NOW() WHERE id_user = :id ");

    $query->bindParam(":firstname",$firstname);
    $query->bindParam(":lastname",$lastname);
    $query->bindParam(":email",$email);
    $query->bindParam(":id",$id);

     $query->execute();
        
    InsertHistorique(
        $_SESSION['user_id'],
        "UPDATE",
        $_SESSION['first_name']." ".$_SESSION['last_name'] ." a modifié des informations de son profil."
    );

   

}



function UpdatePassword($id,$password){

    $query = getPDO()->prepare(" UPDATE users SET password = :password, updated_at_user = NOW() WHERE id_user = :id");

    $query->bindParam(":password",$password);

    $query->bindParam(":id",$id);

     $query->execute();

     InsertHistorique(
        $_SESSION['user_id'],
        "UPDATE",
        $_SESSION['first_name']." ".$_SESSION['last_name'] ." a modifié son mot de passe."
    );


}