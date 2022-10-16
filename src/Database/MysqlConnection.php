<?php

namespace Trulyao\PhpStarter\Database;

use PDO;
use PDOException;
use PDOStatement;
use Trulyao\PhpStarter\Exceptions\{ConnectionException, QueryException};

class MysqlConnection extends Connection
{
    private string $dsn;
    private PDO $pdo;
    protected array $options;

    /**
     * @throws ConnectionException
     */
    public function __construct()
    {
        extract($_ENV);
        $host = $MYSQL_HOST;
        $port = $MYSQL_PORT;
        $user = $MYSQL_USER;
        $pass = $MYSQL_PASS;
        $db = $MYSQL_DATABASE;

        $database_config = [
            'host' => $host,
            'port' => $port,
            'user' => $user,
            'pass' => $pass,
            'db' => $db
        ];

        $this->dsn = $this->buildDSN($database_config);

        $this->options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        $this->pdo = $this->connect();
    }

    private function buildDSN(array $data): string
    {
        return "mysql:host={$data['host']};port={$data['port']};dbname={$data['database']}";
    }

    /**
     * @throws ConnectionException
     */
    private function connect(): PDO
    {
        try {
            $this->pdo = new PDO($this->dsn, $this->options);
            return $this->pdo;
        } catch (PDOException $e) {
            throw new ConnectionException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function getConnection(): PDO
    {
        return $this->pdo;
    }

    /**
     * @throws QueryException
     */
    public function query(string $sql, array $params = []): PDOStatement
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            throw new QueryException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @throws QueryException
     */
    public function select(string $sql, array $params = []): array
    {
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll();
    }
}