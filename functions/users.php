<?php
require_once "../functions/database.php";
require_once "../functions/logs.php";

function register($firstName, $lastName, $email, $role){

        $password = "123456";

        $hash = password_hash($password,PASSWORD_DEFAULT);

    try{

    $queryInsert = getPDO()->prepare("INSERT INTO users(firstname_user, lastname_user, email_user, password, role_id) VALUES(:first_name, :last_name,:email,:password,:role)");
    $queryInsert->bindParam(":first_name", $firstName);
    $queryInsert->bindParam(":last_name", $lastName);
    $queryInsert->bindParam(":email", $email);
    $queryInsert->bindParam(":password", $hash);
    $queryInsert->bindParam(":role", $role);

    $queryInsert->execute();

    InsertHistorique(
        $_SESSION['user_id'],
        "CREATE",
        "L'admin ". $_SESSION['first_name']." ".$_SESSION['last_name'] ." a créé le compte de l'employé «". $firstName." "." $lastName »"
    );


   header("Location: /facturation/pages/dashboard.php");


}catch(PDOException $e){

    echo "ERREUR LORS DE L'INSCRIPTION" .$e->getMessage();
}

}




function connexion($email, $password){

    $querySelect = getPDO()->prepare(" SELECT * FROM users WHERE email_user = :email");

    $querySelect->bindParam(":email", $email);
    $querySelect->execute();

    $result = $querySelect->fetch(PDO::FETCH_ASSOC);

    if(!$result){
        echo "Aucun utilisateur trouvé avec cet e-mail.";
        return;
    }

    // Vérification du mot de passe
    if(!password_verify($password, $result['password'])){
        echo "Mot de passe incorrect.";
        return;
    }

    if(password_verify("123456", $result["password"])){

    session_start();
    $_SESSION["user_id"]    = $result["id_user"];

    header("Location: ../pages/update_password.php");
    exit();

    }else{

    session_start();
       

    $_SESSION["first_name"] = $result["firstname_user"];
    $_SESSION["last_name"]  = $result["lastname_user"];
    $_SESSION["email"]      = $result["email_user"];
    $_SESSION["role"]       = $result["role_id"];
    $_SESSION["user_id"]    = $result["id_user"];
    $_SESSION['is_logged_in'] = true;

     InsertHistorique(
        $_SESSION['user_id'],
        "LOGIN",
        $_SESSION['first_name']." ".$_SESSION['last_name']." s'est connecté à l'application."
    );
        header("Location: ../pages/dashboard.php");
        exit();
    }

}


//function  de verification de la connexion user
function checkLogin(){
    // Vérifier si l'utilisateur est connecté
    if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
         header('Location: ../index.php');  // Rediriger vers la page de connexion
      exit;  // Arrêter l'exécution des scripts suivants
    }
}


function getRole(){


$querySelect = getPDO()->prepare("SELECT * FROM roles");
$querySelect->execute();    

$result = $querySelect->fetchAll(PDO::FETCH_ASSOC);

return $result;



}


function getAllUsers(){

    $querySelect = getPDO()->prepare("SELECT * FROM users INNER JOIN roles ON users.role_id = roles.id_role");
    $querySelect->execute();    

    $result = $querySelect->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}


function getUserById($id_user){

    $querySelect = getPDO()->prepare("SELECT * FROM users INNER JOIN roles ON users.role_id = roles.id_role  WHERE users.id_user = :id");
    $querySelect->bindParam(":id", $id_user);
    $querySelect->execute();    

    $result = $querySelect->fetch(PDO::FETCH_ASSOC);

    return $result;
}

?>