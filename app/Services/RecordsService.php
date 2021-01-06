<?php

namespace Services;

use Models\Record;

class RecordsService
{
    private $db;

    public function __construct()
    {
        $this->db = new \PDO($_ENV['DB_DSN'], $_ENV['MYSQL_USER'], $_ENV['MYSQL_PASSWORD']);
    }

    public function getRecordsList(array $filters, int $limit = 10): array
    {
        $sql = "SELECT * FROM blog ";
        $is_where = false;

        if (isset($filters['views_type']) && isset($filters['views_value'])) {
            switch ($filters['views_type']) {
                case "more":
                    $op = ">";
                    break;
                case "less":
                    $op = "<";
                    break;
                case "equal":
                    $op = "=";
                    break;
            }
            $value = $filters['views_value'];
            $sql .= "WHERE views $op $value ";
            $is_where = true;
        }

        if (isset($filters['date_type']) && isset($filters['date_value'])) {
            switch ($filters['date_type']) {
                case "more":
                    $op = ">";
                    break;
                case "less":
                    $op = "<";
                    break;
                case "equal":
                    $op = "=";
                    break;
            }
            $value = $filters['date_value'];

            if ($is_where) {
                $sql .= "AND DATEDIFF(FROM_UNIXTIME(time_create, '%Y-%m-%d'), '$value') $op 0 ";
            } else {
                $sql .= "WHERE DATEDIFF(FROM_UNIXTIME(time_create, '%Y-%m-%d'), '$value') $op 0 ";
                $is_where = true;
            }
        }

        if (isset($filters['product'])) {
            $value = $filters['product'];
            if ($is_where) {
                $sql .= "AND product = '$value' ";
            } else {
                $sql .= "WHERE product = '$value' ";
            }
        }

         
        $sql .= "ORDER BY time_create DESC
                 LIMIT $limit ";

        if (!$result = $this->db->query($sql)) {
            throw new \ErrorException('No data!');
        }

        $result = $result->fetchAll();

        return array_map(fn($record) =>
            new Record($record['href'], $record['title'], $record['body'], $record['description'],
                       $record['product'], $record['views'], $record['time_create']), 
        $result);
    }

    public function getRecord(string $href)
    {
        $sql = "SELECT * FROM blog WHERE href = '$href'";

        if (!$result = $this->db->query($sql)) {
            throw new \ErrorException('No data!');
        }

        $result = $result->fetch();

        $sql = "UPDATE blog SET views = views + 1 WHERE href = '$href'";

        $this->db->query($sql);

        return new Record($result['href'], $result['title'], $result['body'], $result['description'],
                          $result['product'], $result['views'], $result['time_create']);
    }

    public function updateRecord(Record $record)
    {
        $href = $record->getHref();
        $title = $record->getTitle();
        $body = $record->getBody();
        $description = $record->getDescription();
        $product = $record->getProduct();
        $views = $record->getNews();
        $time_create = $record->getTimeCreate();

        // Подразумевается что href будет уникальным и неизменным, т.к. первичного ключа в таблице нет
        $sql = "UPDATE blog 
                SET title = '$title', body = '$body', description = '$description',
                    product = '$product', views = $views, time_create = $time_create
                WHERE href = '$href'";

        if (!$result = $this->db->query($sql)) {
            throw new \ErrorException('No data!');
        }

        $this->db->query($sql);
    }
}