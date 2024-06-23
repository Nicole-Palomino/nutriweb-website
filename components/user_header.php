<?php

if (isset($message)) {
    foreach($message as $message) {
        echo '
        <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove()"></i>
        </div>
        ';
    }
}

?>

<header class="header">
    <section class="flex">
        <a href="home.php" class="logo">NUTRIWEB</a>

        <nav class="navbar">
            <a href="home.php">INICIO</a>
            <a href="about.php">ACERCA</a>
            <a href="menu.php">CATEGORÍAS</a>
            <a href="orders.php">ÓRDENES</a>
            <a href="contact.php">CONTACTO</a>
        </nav>

        <div class="icons">
            <?php
                $count_cart_items = $conn -> prepare("SELECT * FROM `cart` WHERE user_id = ?");
                $count_cart_items -> execute([$user_id]);
                $total_cart_items = $count_cart_items -> rowCount();
            ?>
            <a href="search.php"><i class="fas fa-search"></i></a>
            <a href="cart.php"><i class="fas fa-shopping-cart"></i><span>(<?= $total_cart_items; ?>)</span></a>
            <div class="fas fa-user" id="user-btn"></div>
            <div class="fas fa-bars" id="menu-btn"></div>
        </div>

        <div class="profile">
            <?php
                $select_profile = $conn -> prepare("SELECT * FROM `users` WHERE id = ?");
                $select_profile -> execute([$user_id]);
                if ($select_profile -> rowCount() > 0) {
                    $fetch_profile = $select_profile -> fetch(PDO::FETCH_ASSOC);
            ?>
            <p class="name"><?= $fetch_profile['name']; ?></p>
            <p class="email"><?= $fetch_profile['email']; ?></p>
            <div class="flex">
                <a href="profile.php" class="btn">Perfil</a>
                <a href="components/user_logout.php" onclick="return confirm('Desea cerrar sessión?');" class="delete-btn">Salir</a>
            </div>
            <p class="account">
                <a href="login.php">Iniciar Sesión</a> or
                <a href="register.php">Registrarse</a>
            </p>
            <?php
                } else {
            ?>
            <p class="name">¿Ya tienes una cuenta?</p>
            <p class="email">Inicie Sesión</p>
            <a href="login.php" class="btn">Iniciar Sesión</a>
            <?php
                }
            ?>
        </div>
    </section>
</header>