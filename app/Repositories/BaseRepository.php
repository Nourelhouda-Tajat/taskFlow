<?php

require_once __DIR__ . '/../Core/Database.php';

abstract class BaseRepository
{
    protected PDO $db;
    protected string $table;

    public function __construct(string $table)
    {
        $this->table = $table;
        $this->db = Database::getInstance()->getConnection();

    }

    public function find(int $id): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch();
    }

    public function findAll(): array
    {
        $sql = "SELECT * FROM {$this->table}";
        $stmt = $this->db->query($sql);

        return $stmt->fetchAll();
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([$id]);
    }

    public function save(array $data)
    {
        throw new Exception("Generic save() not implemented. Override in child class.");
    }
}
