<?php
require_once 'includes/Client.class.php';

session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');  
    exit();
}

$sended="";
$user = new Client;
$people = get_people_data ($user);
$elemToOpts = array("id"=>"","name"=>"","city"=>"","email"=>"","telephone"=>"");
$views = array("general"=>true,"options"=>false);

/**
 * Allows hidde and visable some interface elements.
 *
 * The method allows to change between views
 * changes all views in false and set in true the view you need
 * on. 
 *
 * @param tipo $pView (String).
 * @return tipo none.
 * @throws Excepción none.
 * @author Felipe.
 * @since v1 - Sun 23 2025.
 */
function change_view($pView){
    global $views;
    $views=array_map(function($item) {
        return false;
    }, $views);
    $views[$pView]=true;
}

/**
 * Allows get all person data.
 *
 * It's goint to be necesarry clean the api result, because the answer isn't into return
 * Api metod have a "echo" out inside. So we need to capture that echo an trnaform the data
 * then we could use it.
 *
 * @param tipo $pUser (User).
 * @return tipo JSON(User).
 * @throws Excepción none.
 * @author Felipe.
 * @since v1 - Sun 23 2025.
 */
function get_people_data($pUser){
    ob_start(); 
    $pUser->get_all_clients();
    $dataCaptured = ob_get_clean(); 
    return json_decode($dataCaptured,true);
}

/**
 * Allows if some of data is empty
 *
 *
 * @param tipo $userName (String),$userCity(String),$userPhoneNumber(String),$userEmail(String),$form(String)
 * @return tipo JSON(User).
 * @throws Excepción none.
 * @author Felipe.
 * @since v1 - Sun 23 2025.
 */
function validate ($userName,$userCity,$userPhoneNumber,$userEmail,$form){
    return !empty($userName) && !empty($userCity) && !empty($userPhoneNumber) && !empty($userEmail);
}

if(isset($_POST['form'])){
    /**
     * This section is to create a new person 
     */
    if(validate(...$_POST)){
        $userName = htmlentities($_POST['userName']);
        $userCity = htmlentities($_POST['userCity']);
        $userPhoneNumber = filter_var($_POST['userPhoneNumber'],FILTER_VALIDATE_INT);
        $userEmail =  filter_var($_POST['userEmail'],FILTER_VALIDATE_EMAIL);
        $user->create_client($userEmail,$userName,$userCity,$userPhoneNumber);
        $people = get_people_data ($user);
        $sended = "succes";
    }else{
        $sended = "error";
    }
}else if(isset($_POST['opts'])){
    /**
     * This sectio is to change between views and show more form options
     */
    $e_id=$_POST['edit_id'];
    $result = array_filter($people, function($p) use ($e_id) {
        return $p["id"] == $e_id;
    });
    $elemToOpts = [...$result][0];
    change_view("options");
}else if(isset($_POST['edit'])){
    /**
     * This section allows editing an element
     */
    $userName = htmlentities($_POST['userName']);
    $userCity = htmlentities($_POST['userCity']);
    $userPhoneNumber = filter_var($_POST['userPhoneNumber'],FILTER_VALIDATE_INT);
    $userEmail =  filter_var($_POST['userEmail'],FILTER_VALIDATE_EMAIL);
    $opts_id=$_POST['opts_id'];
    $user->update_client($opts_id,$userEmail,$userName,$userCity,$userPhoneNumber);
    $people = get_people_data ($user);
    $sended = "succes";
}else if(isset($_POST['delete'])){
    /**
     * This section allows deleting an element
     */
    $opts_id=$_POST['opts_id'];
    $user->delete_client_by_id($opts_id);
    $people = get_people_data ($user);
    $sended = "succes";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./crud_style.css">
    <title>Document</title>
</head>
<body>
    <!-- body -->
    <div>
        <!-- nav -->
        <div class="my-nav">
            <div>
                <h1>Bienvenido, <?php echo $_SESSION['username']; ?></h1>
            </div>
            <div>
                <a href="logout.php">Cerrar sesión</a>
            </div>
        </div>
        <!-- nav -->
        <!-- screen -->
        <div class="screen">
            <!-- table -->
            <div class="data-table">
                <table class="people-table">
                    <thead >
                    </thead>
                    <tbody>
                        <tr class="people-head">
                            <th>#</th>
                            <th>Name</th>
                            <th>City</th>
                            <th>Email</th>
                            <th>Telephone</th>
                            <th></th>
                        </tr>
                        <?php if (isset($people)): ?>
                            <?php foreach($people as $person):?>
                                <tr>
                                    <td><div><?php echo "{$person['id']}" ?></div></td>
                                    <td><div><?php echo "{$person['name']}" ?></div></td>
                                    <td><div><?php echo "{$person['city']}" ?></div></td>
                                    <td><div><?php echo "{$person['email']}" ?></div></td>
                                    <td><div><?php echo "{$person['telephone']}" ?></div></td>
                                    <form action="./" method="post" >
                                        <input type="hidden" name="edit_id" value=<?php echo $person["id"]; ?>>
                                        <td> <button class="btn-black btn-sm" type="submit" name="opts">&#8594;</button></td>
                                    </form>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No hay datos disponibles.</p>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <!-- table -->
            <!-- formn -->
            <div class="forms">
                
                <form action="./" method="post" >
                    <?php if($sended == "error"): ?>
                        <div class="alert bg-danger">
                            Incomplete data
                        </div>
                    <?php elseif($sended == "succes"):?>
                        <div class="alert bg-succes">
                            ¡Success!
                        </div>
                    <?php endif;?>
                    <div>
                        <label for="userName">Name</label>
                        <input type="text" name="userName" id="userName" value=<?php echo $elemToOpts['name']; ?>>
                    </div>
                    <div>
                        <label for="userCity">City</label>
                        <input type="text" name="userCity" id="userCity" value=<?php echo $elemToOpts["city"]; ?>>
                    </div>
                    <div>
                        <label for="userEmail">Email</label>
                        <input type="email" name="userEmail" id="userEmail" value=<?php echo $elemToOpts["email"]; ?>>
                    </div>
                    <div>
                        <label for="userPhoneNumber">Phone</label>
                        <input type="text" name="userPhoneNumber" id="userPhoneNumber" value=<?php echo $elemToOpts["telephone"]; ?>>
                    </div>
                    <div>
                    <?php if($views['general']): ?>
                        <button class="btn-black" type="submit" name="form" >Send</button>
                        <?php elseif($views['options']):?>
                            <input type="hidden" name="opts_id" value=<?php echo $elemToOpts["id"]; ?>>
                            <button class="btn-black" type="submit" name="edit">Edit</button>
                            <button class="btn-black" type="submit" name="delete">Delete</button>
                            <button class="btn-black" type="submit">Cancel</button>
                    <?php endif;?>
                    </div>
                </form>
            </div>
            <!-- table -->
        </div>
        <!-- screen -->
    </div>
    <!-- body -->
</body>
</html>