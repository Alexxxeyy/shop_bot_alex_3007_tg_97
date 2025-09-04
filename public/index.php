<?php

use app\models\Products;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "/../vendor/autoload.php";

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <!-- paste it html head -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@6.0/dist/fancybox/fancybox.css"/>
</head>
<body>
<header>
    <h1>Магазин Книг</h1>
</header>

<section>
    <div class="container">
        <div class="products">
            <?php foreach (Products::all() as $product) { ?>
                <div class="product">
                    <div class="image">
                        <img src="<?= str_replace('/images/book/', '/images/book_', $product['image']) ?>" alt="">
                    </div>
                    <div class="title product-title"><?= $product['name'] ?></div>
                    <div class="price product-price"><?= $product['price'] ?> руб.</div>
                    <form action="" class="product-form">
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                        <input type="submit" value="Купить" class="btn">
                    </form>
                </div>
            <?php } ?>
        </div>
    </div>
</section>
<footer>
    Все права защищены
</footer>
<div style="display:none;">
    <div id="order">
        <h2>Ваш заказ</h2>
        <div class="title order-title"></div>
        <div class="price order-price"></div>
        <form action="" class="order-form">
            <div class="form-control count">
                Количество
                <input type="number" name="product_count" value="1" min="1">
            </div>
            <div class="form-control phone">
                Телефон
                <input type="text" name="phone" value="">
            </div>
            <input type="hidden" name="product_id" value="">
            <input type="submit" value="Заказать" class="btn">
        </form>
    </div>
</div>
<!-- paste it in bottom of html body -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@6.0/dist/fancybox/fancybox.umd.js"></script>
<script src="js/script.js"></script>

</body>
</html>
