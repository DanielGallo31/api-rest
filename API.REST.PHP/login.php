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
/* require_once 'includes/User.class.php';
session_start();
$user = new User;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    ob_start(); 
    $user->get_user($username,$password);
    $json = ob_get_clean(); 
    $array = json_decode($json, true);
    if (count($array)>0) {
        $_SESSION['logged_in'] = true;  
        $_SESSION['username'] = $username;  
        header('Location: crud.php');  
        exit();
    } else {
        $error = "Credenciales incorrectas.";
    }
} */
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
                <input type="text" name="username" placeholder="Usuario" required>
            </div>
            <div>    
                <input type="password" name="password" placeholder="Contraseña" required>
            </div>
            <div>
                <button class="btn-black btn-md" type="submit">Iniciar sesión</button>
            </div>
        </form>
    </div>

  
</body>
</html>
