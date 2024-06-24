<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}else{
    $user_id = '';
    header('location:home.php');
};

if(isset($_POST['submit'])){

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_SPECIAL_CHARS);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_SPECIAL_CHARS);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $method = $_POST['method'];
    $method = filter_var($method, FILTER_SANITIZE_SPECIAL_CHARS);
    $address = $_POST['address'];
    $address = filter_var($address, FILTER_SANITIZE_SPECIAL_CHARS);
    $total_products = $_POST['total_products'];
    $total_price = $_POST['total_price'];

    $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
    $check_cart->execute([$user_id]);

    if($check_cart->rowCount() > 0){

        if($address == ''){
            $message[] = 'Por favor agregar su dirección!';
        }else{
            
            $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?,?)");
            $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price]);

            $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
            $delete_cart->execute([$user_id]);

            $message[] = 'Pedido realizado con éxito!';
        }
        
    }else{
        $message[] = 'Tucarrito esta vacío';
    }

}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NUTRIWEB | CHECKOUT</title>

    <link rel="shortcut icon" href="img/NutriWeb.ico" type="image/x-icon">
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'components/user_header.php'; ?>

    <div class="heading">
        <h3>CHECKOUT</h3>
        <p><a href="home.php">Home</a> <span> / Checkout</span></p>
    </div>

    <section class="checkout">
        <h1 class="title">Resumen del pedido</h1>

        <form action="" method="post">
            <div class="cart-items">
                <h3>Artículos</h3>
                <?php
                    $grand_total = 0;
                    $cart_items[] = '';
                    $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                    $select_cart->execute([$user_id]);
                    if($select_cart->rowCount() > 0){
                    while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
                        $cart_items[] = $fetch_cart['name'].' ('.$fetch_cart['price'].' x '. $fetch_cart['quantity'].') - ';
                        $total_products = implode($cart_items);
                        $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
                ?>
                <p><span class="name"><?= $fetch_cart['name']; ?></span> <span class="price">S/<?= $fetch_cart['price']; ?> x <?= $fetch_cart['quantity']; ?></span></p>
                <?php
                        }
                    }else{
                        echo '<p class="empty">Tu carrito está vacío!</p>';
                    }
                ?>
                <p class="grand-total"><span class="name">Total: </span><span class="price">S/<?= $grand_total; ?></span></p>
                <a href="cart.php" class="btn">Ver carrito</a>
            </div>

            <input type="hidden" name="total_products" value="<?= $total_products; ?>">
            <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
            <input type="hidden" name="name" value="<?= $fetch_profile['name'] ?>">
            <input type="hidden" name="number" value="<?= $fetch_profile['number'] ?>">
            <input type="hidden" name="email" value="<?= $fetch_profile['email'] ?>">
            <input type="hidden" name="address" value="<?= $fetch_profile['address'] ?>">
            
            <div class="user-info">
                <h3>Tus datos</h3>
                <p><i class="fas fa-user"></i><span><?= $fetch_profile['name'] ?></span></p>
                <p><i class="fas fa-phone"></i><span><?= $fetch_profile['number'] ?></span></p>
                <p><i class="fas fa-envelope"></i><span><?= $fetch_profile['email'] ?></span></p>
                <a href="update_profile.php" class="btn">Actualizar datos</a>

                <h3>Dirección de envío</h3>
                <p><i class="fas fa-map-marker-alt"></i><span><?php if($fetch_profile['address'] == ''){echo 'Por favor ingrese su dirección';}else{echo $fetch_profile['address'];} ?></span></p>
                <a href="update_address.php" class="btn">Actualizar dirección</a>
                <select name="method" class="box" required>
                    <option value="" disabled selected>Selecciona método de pago --</option>
                    <option value="cash on delivery">Pago contra reembolso</option>
                    <option value="credit card">Tarjeta de crédito</option>
                    <option value="paytm">Yape</option>
                    <option value="paypal">Paypal</option>
                </select>
                <input type="submit" value="Realizar pedido" class="btn <?php if($fetch_profile['address'] == ''){echo 'disabled';}?>" style="width:100%; background:var(--red); color:var(--white);" name="submit">
            </div>
        </form>
    </section>

    <?php include 'components/footer.php'; ?>

    <script src="js/main.js"></script>
</body>
</html>