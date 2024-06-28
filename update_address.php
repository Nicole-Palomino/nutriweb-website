<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:index.php');
};

if(isset($_POST['submit'])){

   $address = $_POST['flat'] .', '.$_POST['building'].', '.$_POST['area'].', '.$_POST['town'] .', '. $_POST['city'] .', '. $_POST['state'];
   $address = filter_var($address, FILTER_SANITIZE_SPECIAL_CHARS);

   $update_address = $conn->prepare("UPDATE `users` set address = ? WHERE id = ?");
   $update_address->execute([$address, $user_id]);

   $message[] = 'Dirección guardada!';

}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NUTRIWEB | ACTUALIZAR DIRECCIÓN</title>

    <link rel="shortcut icon" href="img/NutriWeb.ico" type="img/x-icon">
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'components/user_header.php' ?>

    <section class="form-container">
        <form action="" method="post">
        <h3>Tu dirección</h3>
            <input type="text" class="box" placeholder="Número de calle o -" required maxlength="50" name="flat">
            <input type="text" class="box" placeholder="Número de edificio o -" required maxlength="50" name="building">
            <input type="text" class="box" placeholder="Nombre de la zona o -" required maxlength="50" name="area">
            <input type="text" class="box" placeholder="Ciudad o -" required maxlength="50" name="town">
            <input type="text" class="box" placeholder="Distrito o -" required maxlength="50" name="city">
            <input type="text" class="box" placeholder="Referencia o -" required maxlength="50" name="state">
            <input type="submit" value="Guardar dirección" name="submit" class="btn">
        </form>
    </section>

    <?php include 'components/footer.php' ?>

    <script src="js/main.js"></script>
</body>
</html>