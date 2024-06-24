<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:home.php');
};

if(isset($_POST['delete'])){
   $cart_id = $_POST['cart_id'];
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
   $delete_cart_item->execute([$cart_id]);
   $message[] = 'Artículo eliminado!';
}

if(isset($_POST['delete_all'])){
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart_item->execute([$user_id]);
   // header('location:cart.php');
   $message[] = 'Todo eliminado del carrito!';
}

if(isset($_POST['update_qty'])){
   $cart_id = $_POST['cart_id'];
   $qty = $_POST['qty'];
   $qty = filter_var($qty, FILTER_SANITIZE_STRING);
   $update_qty = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE id = ?");
   $update_qty->execute([$qty, $cart_id]);
   $message[] = 'Cantidad actualizada';
}

$grand_total = 0;

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NUTRIWEB | CARRITO DE COMPRAS</title>

    <link rel="shortcut icon" href="img/NutriWeb.ico" type="image/x-icon">
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'components/user_header.php'; ?>

    <div class="heading">
        <h3>CARRITO DE COMPRAS</h3>
        <p><a href="home.php">home</a> <span> / cart</span></p>
    </div>

    <section class="products">
        <h1 class="title"> TU CARRITO DE COMPRAS</h1>
        <div class="box-container">
            <?php
                $grand_total = 0;
                $select_cart = $conn -> prepare("SELECT * FROM `cart` WHERE user_id = ?");
                $select_cart -> execute([$user_id]);
                if ($select_cart -> rowCount() > 0) {
                    while($fetch_cart = $select_cart -> fetch(PDO::FETCH_ASSOC)){
            ?>
            <form action="" class="box" method="post">
                <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
                <a href="quick_view.php?pid=<?= $fetch_cart['pid']; ?>" class="fas fa-eye"></a>
                <button type="submit" class="fas fa-tiems" name="delete" onclick="return confirm('¿Desea eliminar este platillo?')"></button>
                <img src="uploaded_img/<?= $fetch_cart['image']; ?>" alt="">
                <div class="name"><?= $fetch_cart['name']; ?></div>
                <div class="flex">
                    <div class="price"><span>S/</span><?= $fetch_cart['price']; ?></div>
                    <input type="number" name="qty" class="qty" max="99" value="<?= $fetch_cart['quantity']; ?>" maxlength="2">
                    <button type="submit" class="fas fa-edit" name="update_qty"></button>
                </div>
                <div class="subtotal"> Sub Total: <span>S/<?= $subtotal = ($fetch_cart['price'] * $fetch_cart['quantity']); ?>/-</span></div>
            </form>
            <?php
                        $grand_total += $subtotal;
                    }
                } else {
                    echo '<p class="empty">Tu carrito esta vacío</p>';
                }
            ?>
        </div>

        <div class="cart-total">
            <p>Total: <span>S/<?= $grand_total; ?></span></p>
            <a href="checkout.php" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>">Proceder a la compra</a>
        </div>

        <div class="more-btn">
            <form action="" method="post">
                <button type="submit" class="delete-btn <?= ($grand_total > 1)?'':'disabled'; ?>" name="delete_all" onclick="return confirm('¿Desea eliminar todos los artículos?');">Eliminar todo</button>
            </form>
            <a href="menu.php" class="btn"> Continuar comprando </a>
        </div>
    </section>

    <?php include 'components/footer.php' ?>

    <script src="js/main.js"></script>
</body>
</html>