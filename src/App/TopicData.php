<?php

namespace App;

use PDO;

class TopicData
{
    protected $connection;

    public function __construct()
    {
        $this->connect();
    }

    public function connect()
    {
        $config = \App\Config::get('database');

        $this->connection = new PDO('mysql:host='.$config['hostname'].';dbname='.$config['dbname'], $config['username'], $config['password']);
    }

    public function getAllTopics()
    {
        $query = $this->connection->prepare('SELECT * FROM topics');
        $query->execute();

        return $query;
    }

    public function getTopic($id)
    {
        $sql = 'SELECT * FROM topics WHERE id = :id LIMIT 1';
        $query = $this->connection->prepare($sql);

        $values = [':id' => $id];
        $query->execute($values);

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function add($data)
    {
        $query = $this->connection->prepare(
            'INSERT INTO topics (
                title,
                description
            ) VALUES (
                :title,
                :description
            )'
        );

        $data = [
            ':title' => $data['title'],
            ':description' => $data['description'],
        ];

        $query->execute($data);
    }

    public function update($data)
    {
        $query = $this->connection->prepare(
            'UPDATE topics
                SET
                    title = :title,
                    description = :description
                WHERE
                    id = :id'
        );

        $data = [
            ':id' => $data['id'],
            ':title' => $data['title'],
            ':description' => $data['description'],
        ];

        return $query->execute($data);
    }

    public function delete($id)
    {
        $query = $this->connection->prepare(
            'DELETE FROM topics
                WHERE
                    id = :id'
        );

        $data = [
            ':id' => $id,
        ];

        return $query->execute($data);
    }
}
