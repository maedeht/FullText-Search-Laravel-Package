<?php

namespace Ninja\Search\Controller;

use Illuminate\Support\Facades\DB;
use Ninja\Search\Repositories\ISearch;

class SearchController
{
    private $search;

    public function __construct(ISearch $search)
    {
        $this->search = $search;
    }

    public function index()
    {
        $str = request()->get('find');
        if(is_null($str))
        {
            // Retrieve all data and return
            return true;
        }
        $result = $this->search->filter($str)->paginate(10);

        return $result;
    }
}