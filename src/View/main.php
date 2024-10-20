
<div class="container">
    <a href='/logout'>ВЫХОД</a>
    <div>
        <a href='/profile'>ЛИЧНЫЙ КАБИНЕТ</a>
    </div>
    <div>
        <a href='/cart'>КОРЗИНА</a>
    </div>
    <div>
        <a href='/favorite'>Избранные товары</a>
    </div>
    <h3>КАТАЛОГ</h3>
    <div class="card-deck">
        <?php foreach ($result as $product): ?>
        <form action="/main" method="POST"></form>
        <div class="card text-center">
            <a href="#">
                <div class="card-header">
                    <?php echo $product['name']; ?>
                </div>
                <div class="card-footer">
                    <?php echo $product['price']; ?> рублей
                </div>
                <img class="card-img-top" src=<?php echo $product['images'] ?> width="500" alt="Card image">
                <div class="card-body">
                    <p class="card-text text-muted"> <?php echo $product['category']; ?></p>
                    <a href="#"><h5 class="card-title"><?php echo $product['description']; ?></h5></a>
                </div>
            </a>
        </div>
        <form action="/add-product" method="POST">
            <input type="hidden" id="product_id" name="product_id" value="<?= $product['id']?>" required>

            <input type="text" placeholder="Введите колическтво" id="amount" name="amount" required>
            <label style="color: red"> <?php print_r($errors['amount'] ?? '');?> </label>

            <button type="submit">в корзину</button>
        </form>
        </form>
    </div>
    <?php endforeach; ?>
</div>

<style>
    /*img {*/
    /*    display: block;*/
    /*    margin: 0 auto;*/
    /*}*/
    .container {
        background-color: #f1f1f1;
        width: 1000px;
        margin: 0 auto;

    }

    body {
        font-style: sans-serif;
    }

    a {
        text-decoration: none;
    }

    a:hover {
        text-decoration: none;
    }

    h3 {
        line-height: 3em;
    }

    .card {
        max-width: 500em;
    }

    .card:hover {
        box-shadow: 1px 2px 10px lightgray;
        transition: 0.2s;
    }

    .card-header {
        font-size: 24px;
        color: gray;
        background-color: white;
    }

    .text-muted {
        font-size: 18px;
    }

    .card-footer {
        font-weight: bold;
        font-size: 20px;
        background-color: white;
    }
</style>