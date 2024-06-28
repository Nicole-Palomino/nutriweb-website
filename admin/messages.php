<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_message = $conn->prepare("DELETE FROM `messages` WHERE id = ?");
   $delete_message->execute([$delete_id]);
   header('location:messages.php');
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NUTRIWEB | MENSAJES</title>

    <link rel="shortcut icon" href="../img/NutriWeb.ico" type="image/x-icon">
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body>
    <?php include '../components/admin_header.php' ?>

    <section class="messages">
        <div class="box-container">
            <?php
                $select_messages = $conn->prepare("SELECT * FROM `messages`");
                $select_messages->execute();
                if($select_messages->rowCount() > 0){
                    while($fetch_messages = $select_messages->fetch(PDO::FETCH_ASSOC)){
            ?>
            <div class="box">
                <p> NOMBRE : <span><?= $fetch_messages['name']; ?></span> </p>
                <p> NÚMERO : <span><?= $fetch_messages['number']; ?></span> </p>
                <p> CORREO : <span><?= $fetch_messages['email']; ?></span> </p>
                <p> MENSAJE : <span><?= $fetch_messages['message']; ?></span> </p>
                <a href="messages.php?delete=<?= $fetch_messages['id']; ?>" class="delete-btn" onclick="return confirm('¿Desea eliminar este mensaje?');">Eliminar</a>
            </div>
            <?php
                    }
                }else{
                    echo '<p class="empty">No tienes mensajes</p>';
                }
            ?>
        </div>
    </section>

    <script src="../js/admin_script.js"></script>
</body>
</html>