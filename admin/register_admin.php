<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('location:admin_login.php');
};

if(isset($_POST['submit'])){

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_SPECIAL_CHARS);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_SPECIAL_CHARS);
    $cpass = sha1($_POST['cpass']);
    $cpass = filter_var($cpass, FILTER_SANITIZE_SPECIAL_CHARS);

    $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE name = ?");
    $select_admin->execute([$name]);
    
    if($select_admin->rowCount() > 0){
        $message[] = 'Usuario ya existe!';
    }else{
        if($pass != $cpass){
            $message[] = 'Las contraseñas no coinciden!';
        }else{
            $insert_admin = $conn->prepare("INSERT INTO `admin`(name, email, password) VALUES(?,?,?)");
            $insert_admin->execute([$name, $cpass]);
            $message[] = 'Se registro nuevo administrador!';
        }
    }

}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NUTRIWEB | REGISTRAR</title>

    <link rel="shortcut icon" href="../img/NutriWeb.ico" type="image/x-icon">
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body>
    <?php include '../components/admin_header.php' ?>

    <section class="form-container">
        <form action="" method="POST">
            <h3>Registrar</h3>
            <input type="text" name="name" maxlength="20" required placeholder="Ingresa nombre" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="email" name="name" maxlength="150" required placeholder="Ingresa correo electrónico" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="pass" maxlength="20" required placeholder="Ingresa contraseña" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="cpass" maxlength="20" required placeholder="Confirmar contraseña" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="submit" value="Registrar" name="submit" class="btn">
        </form>
    </section>


    <script src="../js/admin_script.js"></script>
</body>
</html>