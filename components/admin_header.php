<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">
    <section class="flex">
        <a href="dashboard.php" class="logo">Panel de <span>Control</span></a>

        <nav class="navbar">
            <a href="dashboard.php">INICIO</a>
            <a href="products.php">PRODUCTOS</a>
            <a href="placed_orders.php">ÓRDENES</a>
            <a href="admin_accounts.php">ADMIN</a>
            <a href="users_accounts.php">USUARIOS</a>
            <a href="messages.php">CORREOS</a>
        </nav>

        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="user-btn" class="fas fa-user"></div>
        </div>

        <div class="profile">
            <?php
                $select_profile = $conn->prepare("SELECT * FROM `admin` WHERE id = ?");
                $select_profile->execute([$admin_id]);
                $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
            ?>
            <p><?= $fetch_profile['name']; ?></p>
            <a href="update_profile.php" class="btn">Actualizar Perfil</a>
            <a href="../components/admin_logout.php" onclick="return confirm('¿Desea cerrar sesión?');" class="delete-btn">Salir</a>
        </div>
    </section>
</header>