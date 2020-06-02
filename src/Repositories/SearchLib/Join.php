<?php

namespace App\Repositories;
namespace Ninja\Search\Repositories\SearchLib;

class Join extends Base
{
    public function __construct($query)
    {
        $this->query = $query;
    }

    public function handle($tables)
    {
        foreach ($tables as $table => $rel) {
            foreach ($rel as $k => $v)
                $this->query = $this->query->leftJoin($table, $table . '.' . $k, '=', $v['table'] . '.' . $v['column']);
        }

        return $this->query;
    }
}