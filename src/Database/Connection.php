<?php

namespace Trulyao\PhpStarter\Database;

// Extend this class to create a new database connection class using any database driver of your choice

abstract class Connection
{

    private string $dsn;

    public function getConnection()
    {
    }

    private function buildDSN(array $data)
    {
    }

    public function query(string $sql, array $params = [])
    {
    }

    public function select(string $sql, array $params = [])
    {
    }

}