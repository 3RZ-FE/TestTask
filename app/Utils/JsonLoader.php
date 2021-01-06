<?php

namespace Utils;

class JsonLoader
{
    /**
     * Загружает описание таблицы из json
     * Делает запрос для создания таблицы и заполняет данными
     */
    public function loadData(\PDO $db, string $file)
    {
        if (!file_exists($file)) {
            throw new \ErrorException('File '.$file.' with json data is not found!');
        }

        $data = file_get_contents($file);

        if ($data === false) {
            throw new \ErrorException('Error while reading file '.$file);
        }

        $data = json_decode($data, true);

        if (!$data) {
            throw new \ErrorException('Invalid json in '.$file);
        }

        // Создание таблицы
        $basename = basename($file, '.json');

        $sql = "CREATE TABLE $basename (";

        foreach ($data['columns'] as $column => $type) {
            $sql .= "$column $type, ";
        }
        
        $sql = substr($sql, 0, -2);
        $sql .= ");";

        $db->exec($sql);

        // Заполнение данными
        $sql = "INSERT INTO $basename (";

        foreach ($data['columns'] as $column => $type) {
            $sql .= "$column, ";
        }

        $sql = substr($sql, 0, -2);
        $sql .= ") VALUES ";

        foreach ($data['data'] as $string) {
            $sql .= "(";
            foreach ($data['columns'] as $column => $type) {
                $value = $string[$column];
                $value = str_replace("'", "\'", $value);
                $sql .= "'$value', ";
            }
            $sql = substr($sql, 0, -2);
            $sql .= "), ";
        }

        $sql = substr($sql, 0, -2);
        $sql .= ";";
        
        $db->exec($sql);        
    }
}