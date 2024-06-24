<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('location:admin_login.php');
}

if(isset($_POST['submit'])){

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_SPECIAL_CHARS);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    if(!empty($name) && !empty($email)){
        $select_name = $conn->prepare("SELECT * FROM `admin` WHERE name = ? and email = ?");
        $select_name->execute([$name, $email]);
        if($select_name->rowCount() > 0){
            $message[] = 'Nombre o Correo ya existen!';
        }else{
            $update_name = $conn->prepare("UPDATE `admin` SET name = ?, email = ? WHERE id = ?");
            $update_name->execute([$name, $admin_id, $email]);
        }
    }

    $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
    $select_old_pass = $conn->prepare("SELECT password FROM `admin` WHERE id = ?");
    $select_old_pass->execute([$admin_id]);
    $fetch_prev_pass = $select_old_pass->fetch(PDO::FETCH_ASSOC);
    $prev_pass = $fetch_prev_pass['password'];
    $old_pass = sha1($_POST['old_pass']);
    $old_pass = filter_var($old_pass, FILTER_SANITIZE_SPECIAL_CHARS);
    $new_pass = sha1($_POST['new_pass']);
    $new_pass = filter_var($new_pass, FILTER_SANITIZE_SPECIAL_CHARS);
    $confirm_pass = sha1($_POST['confirm_pass']);
    $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_SPECIAL_CHARS);

    if($old_pass != $empty_pass){
        if($old_pass != $prev_pass){
            $message[] = 'Contraseña antigua no coincide!';
        }elseif($new_pass != $confirm_pass){
            $message[] = 'Nueva contraseña no coincide!';
        }else{
            if($new_pass != $empty_pass){
                $update_pass = $conn->prepare("UPDATE `admin` SET password = ? WHERE id = ?");
                $update_pass->execute([$confirm_pass, $admin_id]);
                $message[] = 'Contraseña actualiza con éxito!';
            }else{
                $message[] = 'Por favor ingrese nueva contraseña!';
            }
        }
    }

}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NUTRIWEB | ACTUALIZAR DATOS</title>

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
            <h3>Actualizar datos</h3>
            <input type="text" name="name" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')" placeholder="<?= $fetch_profile['name']; ?>">
            <input type="email" name="email" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')" placeholder="<?= $fetch_profile['email']; ?>">
            <input type="password" name="old_pass" maxlength="20" placeholder="Ingrese contraseña antigua" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="new_pass" maxlength="20" placeholder="Ingrese nueva contraseña" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="confirm_pass" maxlength="20" placeholder="Confirmar la nueva contraseña" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="submit" value="Actualizar" name="submit" class="btn">
        </form>
    </section>

    <script src="../js/admin_script.js"></script>
</body>
</html>