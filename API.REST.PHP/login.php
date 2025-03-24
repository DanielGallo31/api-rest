<?php
// login.php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === 'Damian28' && $password === '12345') {
        $_SESSION['logged_in'] = true;  
        $_SESSION['username'] = $username;
        header('Location: crud.php'); 
        exit();
    } else {
        $error = "Credenciales incorrectas.";
    }
}
/* 
require_once 'includes/User.class.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = new User;
    $json = json_decode($user->get_user($username,$password),true);

    if (count($json)>0) {
        $_SESSION['logged_in'] = true;  
        $_SESSION['username'] = $username;
        header('Location: crud.php'); 
        exit();
    } else {
        $error = "Credenciales incorrectas.";
    }
}
*/
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./login_style.css">
    <title>Login</title>
</head>
<body>
    <div class="login-screen">
        
        <form method="POST">
        <div>
            <?php if (isset($error)):?>
                <div class="alert bg-danger">
                    Try again
                </div>
            <?php endif;?>
        </div>
            <div>
                <input type="text" name="username" placeholder="User" required>
            </div>
            <div>    
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <div>
                <button class="btn-black btn-md" type="submit">Log in</button>
            </div>
        </form>
    </div>

  
</body>
</html>
