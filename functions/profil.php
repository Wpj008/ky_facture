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


function updateCustomer($id_customer, $type_customer, $lastname_customer, $firstname_customer, $entreprise, $adresse_customer, $ville_customer, $code_postal, $phone_customer, $email_customer){
   
   
   try{
    
    $request = getPDO()->prepare("UPDATE customers SET type_customer = :type_customer, lastname_customer = :lastname_customer, firstname_customer = :firstname_customer, entreprise = :entreprise, adresse_customer = :adresse_customer, ville_customer = :ville_customer, code_postal = :code_postal, phone_customer = :phone_customer, email_customer = :email_customer WHERE id_customer = :id_customer");

    $request->bindParam(":type_customer", $type_customer);
    $request->bindParam(":lastname_customer", $lastname_customer);
    $request->bindParam(":firstname_customer", $firstname_customer);
    $request->bindParam(":entreprise", $entreprise);
    $request->bindParam(":adresse_customer", $adresse_customer);
    $request->bindParam(":ville_customer", $ville_customer);
    $request->bindParam(":code_postal", $code_postal);
    $request->bindParam(":phone_customer", $phone_customer);
    $request->bindParam(":email_customer", $email_customer);
    $request->bindParam(":id_customer", $id_customer, PDO::PARAM_INT);

    return $request->execute();


} catch (PDOException $e) {

    echo "Erreur lors de la mise à jour du client : " . $e->getMessage();
    return false;
}

}

?>