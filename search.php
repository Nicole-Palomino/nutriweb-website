<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'components/add_cart.php';

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NUTRIWEB | BÚSQUEDA</title>

    <link rel="shortcut icon" href="img/NutriWeb.ico" type="image/x-icon">
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'components/user_header.php'; ?>

    <section class="search-form">
        <form method="post" action="">
            <input type="text" name="search_box" placeholder="Buscar ..." class="box">
            <button type="submit" name="search_btn" class="fas fa-search"></button>
        </form>
    </section>

    <section class="products" style="min-height: 100vh; padding-top:0;">
        <div class="box-container">
            <?php
                if(isset($_POST['search_box']) OR isset($_POST['search_btn'])){
                $search_box = $_POST['search_box'];
                $select_products = $conn->prepare("SELECT * FROM `products` WHERE name LIKE '%{$search_box}%'");
                $select_products->execute();
                if($select_products->rowCount() > 0){
                    while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
            ?>

            <form action="" class="box" method="post">

            </form>
            <?php
                    }
                }else{
                    echo '<p class="empty">Aún no se han añadido productos!</p>';
                }
            }
            ?>
        </div>
    </section>
</body>
</html>