<!DOCTYPE html>
<html lang="en">
<head>
    <title>Статьи</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/main.css">
</head>
<body>
    <div class="wrapper d-flex align-items-stretch">
        <nav class="sidebar">
            <h1 class="sidebar__title">Фильтры</h1>
            <div class="sidebar__filters">
                <div class="sidebar__filters__item">
                    <input id="views-checkbox" type="checkbox" onclick="viewsCheckboxClick(this)">
                    <label for="views-checkbox">По количеству просмотров</label>
                    <input class="input" id="views-input" type="number" min="0" value="10" onchange="viewsRefresh()" disabled>

                    <div class="radio-group">
                        <div class="radio-group__item">
                            <input type="radio" id="views-radio1" name="view-radio" onclick="viewsRefresh()" value="more" checked disabled>
                            <label for="views-radio1">Больше, чем</label>
                        </div>

                        <div class="radio-group__item">
                            <input type="radio" id="views-radio2" name="view-radio" onclick="viewsRefresh()" value="less" disabled>
                            <label for="views-radio2">Меньше, чем</label>
                        </div>

                        <div class="radio-group__item">
                            <input type="radio" id="views-radio3" name="view-radio" onclick="viewsRefresh()" value="equal" disabled>
                            <label for="views-radio3">Равно</label>
                        </div>
                    </div>
                </div>
                <div class="sidebar__filters__item">
                    <input id="product-checkbox" type="checkbox" onclick="productCheckboxClick(this)">
                    <label for="product-checkbox">По продукту</label>
                    <select class="product-select" id="product-select" onchange="productRefresh()" disabled>
                        <option disabled>Выберите продукты</option>
                        <?php foreach ($products as $product): ?>
                            <option value="<?= $product->getName(); ?>"><?= $product->getName(); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="sidebar__filters__item">
                    <input id="date-checkbox" type="checkbox" onclick="dateCheckboxClick(this)">
                    <label for="date-checkbox">По дате</label>
                    <input class="input" id="date-input" type="date" value="<?php echo date('Y-m-d'); ?>" onchange="dateRefresh()" disabled>

                    <div class="radio-group">
                        <div class="radio-group__item">
                            <input type="radio" id="date-radio1" name="date-radio" onclick="dateRefresh()" value="more" checked disabled>
                            <label for="date-radio1">Позже, чем</label>
                        </div>

                        <div class="radio-group__item">
                            <input type="radio" id="date-radio2" name="date-radio" onclick="dateRefresh()" value="less" disabled>
                            <label for="date-radio2">Ранее, чем</label>
                        </div>

                        <div class="radio-group__item">
                            <input type="radio" id="date-radio3" name="date-radio" onclick="dateRefresh()" value="equal" disabled>
                            <label for="date-radio3">Равна</label>
                        </div>
                    </div>
                </div>
                <div class="sidebar__filters__item">
                    <p>Кол-во отображаемых записей:</p>
                    <select class="limit-select" id="limit-select" onchange="limitRefresh()">
                        <option disabled>Выберите кол-во:</option>
                        <option value="1">1</option>
                        <option value="3">3</option>
                        <option value="5">5</option>
                        <option value="10" selected>10</option>
                        <option value="20">20</option>
                    </select>
                </div>
            </div>
        </nav>

        <div class="content">
            <h1 class="content__title">Статьи</h1>
            <div class="content__list" id="list">
                <?php foreach ($records as $record): ?>
                    <a class="blog-item" href="record?href=<?= $record->getHref(); ?>">
                        <div class="blog-item__title">
                            <h3><?= $record->getTitle(); ?></h3>
                        </div>

                        <div class="blog-item__description">
                            <span><?= $record->getDescription(); ?></span>
                        </div>

                        <div class="blog-item__stats">
                            <span>Просмотров: <?= $record->getViews(); ?></span>
                            <span>Дата добавления: <?= date('Y-m-d', $record->getTimeCreate()); ?></span>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <script src="/assets/js/main.js"></script>
</body>
</html>