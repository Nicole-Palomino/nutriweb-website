<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('location:admin_login.php');
};

if(isset($_POST['add_product'])){

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_SPECIAL_CHARS);
    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_SPECIAL_CHARS);
    $category = $_POST['category'];
    $category = filter_var($category, FILTER_SANITIZE_SPECIAL_CHARS);
    $description = $_POST['description'];
    $description = filter_var($description, FILTER_SANITIZE_SPECIAL_CHARS);

    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_SPECIAL_CHARS);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_img/'.$image;

    $select_products = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
    $select_products->execute([$name]);

    if($select_products->rowCount() > 0){
        $message[] = 'Nombre del producto ya existe!';
    }else{
        if($image_size > 2000000){
            $message[] = 'El tamaño de la imagen es demasiado grande';
        }else{
            move_uploaded_file($image_tmp_name, $image_folder);

            $insert_product = $conn->prepare("INSERT INTO `products`(name, category, description, price, image) VALUES(?,?,?,?,?)");
            $insert_product->execute([$name, $category, $description, $price, $image]);

            $message[] = 'Producto agregado!';
        }

    }

}

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_product_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
   $delete_product_image->execute([$delete_id]);
   $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
   unlink('../uploaded_img/'.$fetch_delete_image['image']);
   $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
   $delete_product->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
   $delete_cart->execute([$delete_id]);
   header('location:products.php');

}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MUTRIWEB | PRODUCTOS</title>

    <link rel="shortcut icon" href="../img/NutriWeb.ico" type="image/x-icon">
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body>
    <?php include '../components/admin_header.php' ?>

    <section class="add-products">
        <form action="" method="POST" enctype="multipart/form-data">
            <h3>Agregar producto</h3>
            <input type="text" required placeholder="Ingresar nombre del producto" name="name" maxlength="100" class="box">
            <input type="number" min="0" max="9999999999" required placeholder="Precio del producto" name="price" onkeypress="if(this.value.length == 10) return false;" class="box">
            <input type="text" required placeholder="Ingresar descripción del producto" name="description" maxlength="250" class="box">
            <select name="category" class="box" required>
                <option value="" disabled selected>Selecciona una categoría --</option>
                <option value="almuerzos y cenas">Almuerzos y cenas</option>
                <option value="ensaladas">Ensaladas</option>
                <option value="snacks">Snacks</option>
                <option value="bebidas">Bebidas</option>
            </select>
            <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp" required>
            <input type="submit" value="Agregar producto" name="add_product" class="btn">
        </form>
    </section>

    <section class="show-products" style="padding-top: 0;">
        <div class="box-container">
            <?php
                $show_products = $conn->prepare("SELECT * FROM `products`");
                $show_products->execute();
                if($show_products->rowCount() > 0){
                    while($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)){  
            ?>

            <div class="box">
                <img src="../uploaded_img/<?= $fetch_products['image']; ?>" alt="">
                <div class="flex">
                    <div class="price"><span>S/</span><?= $fetch_products['price']; ?></div>
                    <div class="category"><?= $fetch_products['category']; ?></div>
                </div>
                <div class="name"><?= $fetch_products['name']; ?></div>
                <div class="description"><?= $fetch_products['description']; ?></div>
                <div class="flex-btn">
                    <a href="update_product.php?update=<?= $fetch_products['id']; ?>" class="option-btn">Actualizar</a>
                    <a href="products.php?delete=<?= $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('¿Desea eliminar el producto?');">Eliminar</a>
                </div>
            </div>
            <?php
                    }
                }else{
                    echo '<p class="empty">No hay productos agregados!</p>';
                }
            ?>
        </div>
    </section>

    <script src="../js/admin_script.js"></script>
</body>
</html>