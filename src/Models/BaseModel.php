<?php

namespace Trulyao\PhpStarter\Models;

use Trulyao\PhpStarter\Database\Connection;

abstract class BaseModel
{
    protected Connection $connection;

    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }

    public function findOne($id) {}

    public function find() {}

    public function create() {}

    public function update() {}

    public function delete() {}

    public function save() {}

}