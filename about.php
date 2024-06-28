<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NUTRIWEB | ACERCA DE NOSOTROS</title>

    <link rel="shortcut icon" href="img/NutriWeb.ico" type="image/x-icon">
   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'components/user_header.php'; ?>

    <div class="heading">
        <h3>Acerca de nosotros</h3>
        <p><a href="index.php">Inicio</a> <span> / Acerca de nosotros</span></p>
    </div>

    <section class="about">
        <div class="row">
            <div class="image">
                <img src="img/about-img.svg" alt="">
            </div>

            <div class="content">
                <h3>¿Por qué elegirnos?</h3>
                <p>
                    En NutriWeb, nos destacamos por ofrecer comida saludable y deliciosa preparada con ingredientes frescos y naturales, sin aditivos ni conservantes. Nuestro equipo de chefs y nutricionistas crea menús equilibrados que se pueden personalizar para satisfacer diversas necesidades dietéticas, desde opciones veganas hasta menús sin gluten. Además, proporcionamos información nutricional detallada para cada plato, permitiéndote tomar decisiones informadas sobre tu alimentación.
                    Elegir NutriWeb significa optar por comodidad y rapidez, con un servicio de delivery confiable que lleva tus comidas saludables directamente a tu puerta. Nos comprometemos con la sostenibilidad utilizando envases ecológicos y prácticas responsables, y ofrecemos promociones especiales y programas de fidelidad para nuestros clientes. Nuestro equipo de atención al cliente está siempre disponible para garantizar que tengas la mejor experiencia posible con nosotros.
                </p>
                <a href="menu.php" class="btn">Nuestro menú</a>
            </div>
        </div>
    </section>

    <section class="steps">
        <h1 class="title">PASOS SENCILLOS</h1>
        <div class="box-container">
            <div class="box">
                <img src="https://i.postimg.cc/prC02kHJ/step-1.png" alt="">
                <h3>Elija la Orden</h3>
                <p>Explora nuestro menú y selecciona tus platos favoritos, adaptados a tus necesidades dietéticas y preferencias.</p>
            </div>
            <div class="box">
                <img src="https://i.postimg.cc/WpwY6pkq/step-2.png" alt="">
                <h3>Entrega rápida</h3>
                <p>Recibe tus comidas saludables en la puerta de tu casa de manera rápida y confiable, siempre frescas y listas para disfrutar.</p>
            </div>
            <div class="box">
                <img src="https://i.postimg.cc/8PkKy8RK/step-3.png" alt="">
                <h3>Disfrutar de la comida</h3>
                <p>Saborea cada bocado sabiendo que estás comiendo alimentos nutritivos y deliciosos, diseñados para tu bienestar.</p>
            </div>
        </div>
    </section>

    <section class="reviews">
        <h1 class="title">COMENTARIOS DE LOS CLIENTES</h1>

        <div class="swiper reviews-slider">
            <div class="swiper-wrapper">
                <div class="swiper-slide slide">
                    <img src="img/pic-1.png" alt="">
                    <p>"Me encanta la variedad de opciones saludables. Solo desearía que ampliaran el menú vegano."</p>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                        <i class="fa-regular fa-star"></i>
                    </div>
                    <h3>Juan Palacios</h3>
                </div>
                <div class="swiper-slide slide">
                    <img src="img/pic-2.png" alt="">
                    <p>"¡Increíble! La comida es deliciosa y llega siempre a tiempo. Recomiendo NutriWeb a todos."</p>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <h3>Marta Nuñez</h3>
                </div>
                <div class="swiper-slide slide">
                    <img src="img/pic-3.png" alt="">
                    <p>"El mejor servicio de delivery de comida saludable que he probado. Perfecto para mi dieta sin gluten."</p>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <h3>Paola Giménez</h3>
                </div>
                <div class="swiper-slide slide">
                    <img src="img/pic-4.png" alt="">
                    <p>"Entrega rápida y comida fresca. Sería genial tener más promociones y descuentos."</p>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                        <i class="fa-regular fa-star"></i>
                    </div>
                    <h3>Laura Maldonado</h3>
                </div>
                <div class="swiper-slide slide">
                    <img src="img/pic-5.png" alt="">
                    <p>"Excelente calidad y sabor. La transparencia nutricional es un gran plus. ¡Cinco estrellas!"</p>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <h3>Alan Torres</h3>
                </div>
                <div class="swiper-slide slide">
                    <img src="img/pic-6.png" alt="">
                    <p>"NutriWeb ha transformado mi forma de comer. La comida es saludable, deliciosa y el servicio es impecable."</p>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                        <i class="fa-regular fa-star"></i>
                    </div>
                    <h3>Paola Fernández</h3>
                </div>
            </div>

            <div class="swiper-pagination"></div>
        </div>
    </section>

    <?php include 'components/footer.php'; ?>

    <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

    <script src="js/main.js"></script>

    <script>

        var swiper = new Swiper(".reviews-slider", {
            loop:true,
            grabCursor: true,
            spaceBetween: 20,
            pagination: {
                el: ".swiper-pagination",
                clickable:true,
            },
            breakpoints: {
                0: {
                slidesPerView: 1,
                },
                700: {
                slidesPerView: 2,
                },
                1024: {
                slidesPerView: 3,
                },
            },
        });

    </script>

</body>
</html>