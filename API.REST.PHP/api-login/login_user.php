<?php
    require_once('../includes/User.clas.php');

    if($_SERVER['REQUEST_METHOD'] == 'GET' 
        && isset($_GET['user']) && isset($_GET['passw'])){
            User::get_user($_GET['user'], $_GET['passw']);
        }

?>