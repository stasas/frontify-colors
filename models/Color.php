<?php

namespace Models;

class Color
{
    private $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findAll()
    {
        $statement = "
            SELECT
                color_id, name, value
            FROM
                colors;
        ";

        try {
            $statement = $this->db->query($statement);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function find($color_id)
    {
        $statement = "
            SELECT
                color_id, name, value
            FROM
                colors
            WHERE color_id = ?;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute([$color_id]);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function insert(array $input)
    {
        $statement = "
            INSERT INTO colors
                (name, value)
            VALUES
                (:name, :value);
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute([
                'name' => sanitize($input['name']),
                'value'  => sanitize($input['value']),
            ]);
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function delete($color_id)
    {
        $statement = "
            DELETE FROM colors
            WHERE color_id = :color_id;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(['color_id' => $color_id]);
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}
