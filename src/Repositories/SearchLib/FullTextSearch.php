<?php

namespace Ninja\Search\Repositories\SearchLib;


class FullTextSearch extends Base
{
    private $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function handle($search_fields, $str)
    {
        $this->addCondition($search_fields, $str);
        $this->setRelevanceScore($search_fields, $str);
        $this->setTotalOrderBy($search_fields);
        $this->setRelevanceOrderBy($search_fields);

        return $this->query;
    }

    private function addCondition($search_fields, $str)
    {
        foreach ($search_fields as $table => $fields) {
            $table_fields = $this->renameColumns($table, $fields);
            $this->query = $this->fullTextCondition($table_fields, $str);
        };
    }

    private function renameColumns($table, $fields)
    {
        return array_map(function ($field) use ($table) {
            return $table . "." . $field;
        }, $fields);
    }

    private function fullTextCondition($table_fields, $str)
    {
        return $this->query->orWhereRaw("MATCH(" . implode(',', $table_fields) . ")" .
            "AGAINST('" . $this->fullTextWildcards($str) . "' IN BOOLEAN MODE)");
    }

    private function setRelevanceScore($search_fields, $str)
    {
        foreach ($search_fields as $table => $fields) {
            $table_fields = $this->renameColumns($table, $fields);
            $this->query = $this->fullTextSelect($table_fields, $str, $table);
        }
    }

    private function fullTextSelect($table_fields, $str, $table)
    {
        return $this->query->selectRaw("MATCH(" . implode(',', $table_fields) . ")" .
            "AGAINST('" . $this->fullTextWildcards($str) . "' IN BOOLEAN MODE) as " . $table . "_score");
    }

    private function setTotalOrderBy($search_fields)
    {
        $total_array = array_map(function ($table) {
            return '(select ' . $table . '_score)';
        }, array_keys($search_fields));
        $this->query = $this->query->selectRaw(implode('+', $total_array)." as total_score")
            ->orderBy('total_score', 'DESC');
    }

    private function setRelevanceOrderBy($search_fields)
    {
        foreach ($search_fields as $table => $fields)
        {
            $this->query = $this->query->orderBy($table.'_score', 'DESC');
        }
    }
}