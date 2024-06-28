<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:index.php');
};

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NUTRIWEB | PERFIL</title>

    <link rel="shortcut icon" href="img/NutriWeb.ico" type="image/x-icon">
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'components/user_header.php' ?>

    <section class="user-details">
        <div class="user">
            <?php

            ?>
            <img src="https://i.postimg.cc/ZnKDpQ77/user-icon.png" alt="">
            <p><i class="fas fa-user"></i> <span><span><?= $fetch_profile['name']; ?></span></span></p>
            <p><i class="fas fa-phone"></i> <span><?= $fetch_profile['number'] ?></span></p>
            <p><i class="fas fa-envelope"></i> <span><?= $fetch_profile['email'] ?></span></p>
            <a href="update_profile.php" class="btn">Actualizar datos</a>
            <p class="address"><i class="fas fa-map-market-alt"></i><span><?php if ($fetch_profile['address'] == '') {
                echo 'Introduzca su dirección';
            } else {echo $fetch_profile['address']; }?></span></p>
            <a href="update_address.php" class="btn">Actualizar dirección</a>
        </div>
    </section>

    <?php include 'components/footer.php'; ?>

    <script src="js/main.js"></script>
</body>
</html>