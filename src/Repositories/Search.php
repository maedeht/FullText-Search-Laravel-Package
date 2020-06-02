<?php

namespace Ninja\Search\Repositories;

use Illuminate\Support\Facades\DB;
use Ninja\Search\Repositories\SearchLib\FullTextSearch;
use Ninja\Search\Repositories\SearchLib\Join;

class Search implements ISearch
{
    public function filter($str)
    {
        $query = DB::table(config('search.tables.primary'));

        $tables = config('search.tables.joins');
        $search_fields = config('search.fields');

        if (isset($tables))
            $query = (new Join($query))->handle($tables);

        if (isset($search_fields))
            $query = (new FullTextSearch($query))->handle($search_fields, $str);

        return $query;
    }
}
