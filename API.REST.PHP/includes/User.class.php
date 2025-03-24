<?php
require_once('Database.class.php');
    class User{
        public static function get_user($user,$passw){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT * FROM users where user=:user and passw=:passw');
            $stmt->bindParam(':user',$user);
            $stmt->bindParam(':passw',$passw);
            if($stmt->execute()){
                $result = $stmt->fetchAll();
                header('HTTP/1.1 201 OK');
                return json_encode($result);
            } else {
                header('HTTP/1.1 404 No se ha podido consultar usuario');
            }
        }
    }
?>