<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['send'])){

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_SPECIAL_CHARS);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_SPECIAL_CHARS);
    $msg = $_POST['msg'];
    $msg = filter_var($msg, FILTER_SANITIZE_SPECIAL_CHARS);

    $select_message = $conn->prepare("SELECT * FROM `messages` WHERE name = ? AND email = ? AND number = ? AND message = ?");
    $select_message->execute([$name, $email, $number, $msg]);

    if($select_message->rowCount() > 0){
        $message[] = 'Mensaje enviado!';
    }else{

        $insert_message = $conn->prepare("INSERT INTO `messages`(user_id, name, email, number, message) VALUES(?,?,?,?,?)");
        $insert_message->execute([$user_id, $name, $email, $number, $msg]);

        $message[] = 'Mensaje enviado correctamente!';
    }

}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NUTRIWEB | CONTACTO</title>

    <link rel="shortcut icon" href="img/NutriWeb.ico" type="image/x-icon">
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'components/user_header.php'; ?>

    <div class="heading">
        <h3>Contáctanos</h3>
        <p><a href="home.php">Inicio</a> <span> / Contacto</span></p>
    </div>

    <section class="contact">
        <div class="row">
            <div class="image">
                <img src="img/contact-img.svg" alt="">
            </div>

            <form action="" method="post">
                <h3>Cuéntanos!</h3>
                <input type="text" name="name" maxlength="50" class="box" placeholder="Ingrese su nombre" required>
                <input type="number" name="number" min="0" max="9999999999" class="box" placeholder="Ingrese su número telefónico" required maxlength="10">
                <input type="email" name="email" maxlength="50" class="box" placeholder="Ingrese su correo" required>
                <textarea name="msg" class="box" required placeholder="Ingrese su mensaje" maxlength="500" cols="30" rows="10"></textarea>
                <input type="submit" name="send" value="Enviar mensaje" class="btn">
            </form>
        </div>
    </section>

    <?php include 'components/footer.php'; ?>

    <script src="js/main.js"></script>
</body>
</html>