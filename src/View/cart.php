
<div class="container">
    <a href='/logout'>Выход</a>
    <div>
        <a href='/profile'>Личный кабинет</a>
    </div>
    <div>
        <a href='/main'>Главная страница</a>
    </div>
    <div>
        <a href='/favorite'>Избранные товары</a>
    </div>

    <h3>КОРЗИНА</h3>
    <div class="card-deck">
        <?php foreach ($result as $elem): ?>
        <form action="/main" method="POST"></form>
        <div class="card text-center">
            <a href="#">
                <div class="card-header">
                    <?php echo $elem->getName() ?? ''; ?>
                </div>
                <div class="card-footer">
                    <?php echo $elem->getPrice() ?? ''; ?> рублей
                </div>
                <img class="card-img-top" src=<?php echo $elem->getImages() ?? ''; ?> width="500" alt="Card image">
                <div class="card-body">
                    <p class="card-text text-muted"> <?php echo $elem->getCategory() ?? ''; ?></p>
                    <a href="#"><h5 class="card-title"><?php echo $elem->descriprion() ?? ''; ?></h5></a>
                </div>
            </a>
        </form>

    </div>

    <?php endforeach; ?>
        <p><b><?php if (isset($sumAll)) {
                    echo 'Обшая сумма в корзине ' . $sumAll . ' рублей'; ?></b></p>
    </div>    <a href='/buy'>Купить все содержимое в корзине</a>
    <?php }?>


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
        b