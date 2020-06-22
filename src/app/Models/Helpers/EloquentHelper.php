<?php


namespace App\Models\Helpers;


use Illuminate\Pagination\LengthAwarePaginator;

class EloquentHelper
{

    public function queryPagination(string $query, int $page = 1, int $limit = 150): LengthAwarePaginator
    {
        //gerando o count da query passada
        $select = \Str::of($query)
            ->after('SELECT')
            ->before('FROM');

        $count_query_str = \Str::of($query)->replace($select, ' COUNT(*) as count ');
        $count_query = \DB::select($count_query_str)[0];

        $offset = ($page - 1) * $limit;
        $sql = $query." LIMIT ".$limit." OFFSET ".$offset;

        $result = \DB::select($sql);

        return new LengthAwarePaginator($result, $count_query->count, $limit, $page);
    }

}
