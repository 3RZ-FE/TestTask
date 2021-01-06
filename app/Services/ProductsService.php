<?php

namespace Services;

use Models\Product;

class ProductsService
{
    public function getProductsList(): array
    {
        $db = new \PDO($_ENV['DB_DSN'], $_ENV['MYSQL_USER'], $_ENV['MYSQL_PASSWORD']);

        $sql = "SELECT * FROM products";

        if (!$result = $db->query($sql)) {
            throw new \ErrorException('No data!');
        }

        $result = $result->fetchAll();

        return $result = array_map(fn($record) => new Product($record['name'], $record['href']), $result);
    }
}