<?php

class Database
{
    private $connection = null;

    public function __construct()
    {
        try {
            $this->connection = new \PDO(
                'mysql:host=' . DB_HOST . ';charset=utf8mb4;dbname=' . DB_DATABASE_NAME,
                DB_USERNAME,
                DB_PASSWORD
            );
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
