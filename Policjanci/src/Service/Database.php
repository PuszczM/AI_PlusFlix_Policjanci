<?php

namespace App\Service;

use PDO;
use PDOException;
use RuntimeException;

class Database
{
    private ?PDO $pdo = null;
    private string $dbPath;

    public function __construct(string $projectDir)
    {
        $this->dbPath = $projectDir . '/var/data.db';
    }

    public function getConnection(): PDO
    {
        if ($this->pdo === null) {
            if (!is_dir(dirname($this->dbPath))) {
                mkdir(dirname($this->dbPath), 0777, true);
            }

            if (!file_exists($this->dbPath)) {
                touch($this->dbPath);
            }

            try {
                $dsn = 'sqlite:' . $this->dbPath;
                $this->pdo = new PDO($dsn);

                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            } catch (PDOException $e) {
                throw new RuntimeException('Błąd połączenia z bazą danych: ' . $e->getMessage());
            }
        }

        return $this->pdo;
    }

    public function query(string $sql, array $params = []): array
    {
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function execute(string $sql, array $params = []): bool
    {
        $stmt = $this->getConnection()->prepare($sql);
        return $stmt->execute($params);
    }
}
