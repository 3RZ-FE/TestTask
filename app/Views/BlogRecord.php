<!DOCTYPE html>
<html lang="en">
<head>
    <title><?= $record->getTitle(); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/record.css">
</head>
<body>
    <div class="content">
        <h1 class="content__title"><?= $record->getTitle(); ?></h1>
        <div class="flex">
            <a href="bloglist" class="content__back"><-- Вернуться к списку статей</a>
            <span class="content__date">Дата добавления: <?= date('Y-m-d', $record->getTimeCreate()); ?></span>
        </div>
        <div class="content__body">
            <?= $record->getBody(); ?>
        </div>
    </div>
    <script src="/assets/js/main.js"></script>
</body>
</html>