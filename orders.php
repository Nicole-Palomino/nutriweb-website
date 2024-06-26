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
    <title>NUTRIWEB | ÓRDENES</title>

    <link rel="shortcut icon" href="img/NutriWeb.ico" type="image/x-icon">
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'components/user_header.php'; ?>

    <div class="heading">
        <h3>Órdenes</h3>
        <p><a href="index.php">Inicio</a> <span> / Órdenes</span></p>
    </div>

    <section class="orders">
        <h1 class="title">Tus órdenes</h1>

        <div class="box-container">
            <?php
                if($user_id == ''){
                    echo '<p class="empty">Inicie sesión para ver sus pedidos</p>';
                }else{
                    $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
                    $select_orders->execute([$user_id]);
                    if($select_orders->rowCount() > 0){
                        while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
            ?>
            <div class="box">
                <p>Fecha : <span><?= $fetch_orders['placed_on']; ?></span></p>
                <p>Nombre : <span><?= $fetch_orders['name']; ?></span></p>
                <p>Correo : <span><?= $fetch_orders['email']; ?></span></p>
                <p>Número : <span><?= $fetch_orders['number']; ?></span></p>
                <p>Dirección : <span><?= $fetch_orders['address']; ?></span></p>
                <p>Método de pago : <span><?= $fetch_orders['method']; ?></span></p>
                <p>Tus productos : <span><?= $fetch_orders['total_products']; ?></span></p>
                <p>Precio total : <span>S/<?= $fetch_orders['total_price']; ?>/-</span></p>
                <p>Estado del pago : <span style="color:<?php if($fetch_orders['payment_status'] == 'pendiente'){ echo 'red'; }else{ echo 'green'; }; ?>"><?= $fetch_orders['payment_status']; ?></span> </p>
            </div>
            <?php
                }
                }else{
                    echo '<p class="empty">Aún no tienes pedidos</p>';
                }
                }
            ?>
        </div>
    </section>

    <?php include 'components/footer.php'; ?>

    <script src="js/main.js"></script>
</body>
</html>