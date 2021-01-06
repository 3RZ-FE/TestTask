<?php

namespace Controllers;

use Core\View;
use Services\RecordsService;
use Services\ProductsService;
use Utils\JsonLoader;

class MainController
{
    public function actionInitializeDatabase()
    {
        $db = new \PDO($_ENV['DB_DSN'], $_ENV['MYSQL_USER'], $_ENV['MYSQL_PASSWORD']);

        $jsonLoader = new JsonLoader;

        $files = explode(' ', $_ENV['DB_FILES']);

        foreach ($files as $file) {
            $jsonLoader->loadData($db, dirname(__DIR__).'/data/'.$file);
        }

        $sql = "CREATE UNIQUE INDEX name_index
                ON products (name);";

        $db->exec($sql);

        $sql = "CREATE UNIQUE INDEX href_index
                ON blog (href);";

        $db->exec($sql);

        $sql = "ALTER TABLE blog
                ADD CONSTRAINT FK_blog_product FOREIGN KEY (product)
                REFERENCES products (name)
                ON DELETE CASCADE
                ON UPDATE CASCADE;";

        $db->exec($sql);

        echo 'Таблицы созданы и наполнены данными! Перейти к списку записей: 
        <a href="http://localhost/main/bloglist">http://localhost/main/bloglist</a>';
    }

    public function actionBlogList()
    {
        $recordsService = new RecordsService;
        $productsService = new ProductsService;

        try {
            $records = $recordsService->getRecordsList([]);
            $products = $productsService->getProductsList();
            View::render('BlogList', ['records' => $records, 'products' => $products]);
        } catch (\ErrorException $e) {
            echo 'Это первый запуск приложения! Запустите сначала скрипт для инициализации БД:
            <a href="http://localhost/main/initializedatabase">http://localhost/main/initializedatabase</a>';
        }        
    }

    public function actionRecord()
    {
        $recordsService = new RecordsService;

        $record = $recordsService->getRecord($_GET['href']);
        View::render('BlogRecord', ['record' => $record]);
    }

    public function actionBlogListAjax()
    {
        $recordsService = new RecordsService;

        $filters = array();
        $limit = 10;

        if (isset($_GET['views_type']) && isset($_GET['views_value'])) {
            $filters['views_type'] = $_GET['views_type'];
            $filters['views_value'] = $_GET['views_value'];
        }

        if (isset($_GET['product'])) {
            $filters['product'] = $_GET['product'];
        }

        if (isset($_GET['date_type']) && isset($_GET['date_value'])) {
            $filters['date_type'] = $_GET['date_type'];
            $filters['date_value'] = $_GET['date_value'];
        }

        if (isset($_GET['limit'])) {
            $limit = $_GET['limit'];
        }

        $records = $recordsService->getRecordsList($filters, $limit);

        $result = array();

        foreach ($records as $record) {
            $result[] = [
                'title' => $record->getTitle(),
                'description' => $record->getDescription(),
                'views' => $record->getViews(),
                'href' => $record->getHref(),
                'date' => date('Y-m-d', $record->getTimeCreate())
            ];
        }

        header('Content-type: application/json');
        echo json_encode($result);
    }
}