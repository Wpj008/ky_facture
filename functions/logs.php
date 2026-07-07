<?php
require_once "../functions/database.php";

function InsertHistorique($user_id, $action, $description){

    try{

        $pdo = getPDO();

        $queryInsert = $pdo->prepare(" INSERT INTO historiques ( user_id, action_historique, description_historique, date_action) VALUES ( :user, :action, :description, NOW())");

        $queryInsert->bindParam("user", $user_id);
        $queryInsert->bindParam("action", $action);
        $queryInsert->bindParam("description", $description);

        $queryInsert->execute();

    }

    catch(PDOException $e){

        die($e->getMessage());

    }

}



function getLogs(){


    try{

        $querySelect = getPDO()->prepare("SELECT * FROM historiques INNER JOIN users ON users.id_user = historiques.user_id  ORDER BY id_historique DESC LIMIT 5");

        $querySelect->execute();

        $result = $querySelect->fetchAll();

        return $result;


    }   catch(PDOException $e){

    die($e->getMessage());

}


}


?>