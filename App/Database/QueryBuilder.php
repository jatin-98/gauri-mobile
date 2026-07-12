<?php

namespace App\Database;

use DB;

/**
 * QueryBuilder
 *
 * A static DAO wrapper around Illuminate's Query Builder.
 * Provides reusable, table-agnostic database operations.
 */
class QueryBuilder
{
    public static function fetchOneRecord(string $tablename, array $whereCondition)
    {
        return DB::table($tablename)->where($whereCondition)->first();
    }

    public static function insertRecords(string $tablename, array $records)
    {
        return DB::table($tablename)->insertGetId($records);
    }

    public static function fetchAll(string $tablename)
    {
        return DB::table($tablename)->get();
    }

    public static function fetchAllWithWhereCondition(string $tablename, array $whereCondition)
    {
        return DB::table($tablename)->where($whereCondition)->get();
    }

    public static function insertMultipleRecords(string $tablename, array $records)
    {
        return DB::table($tablename)->insert($records);
    }

    public static function fetchLimitedrecords(string $tableName, int $limit, array $orderByCondition)
    {
        return DB::table($tableName)
            ->limit($limit)
            ->orderBy($orderByCondition[0], $orderByCondition[1])
            ->get();
    }

    public static function fetchDatatableRecords(string $tableName, string $searchText, array $searchFields, int $offset, int $limit)
    {
        $query = DB::table($tableName);

        if (!empty($searchText) && !empty($searchFields)) {
            $query->where(function ($q) use ($searchFields, $searchText) {
                foreach ($searchFields as $column) {
                    $q->orWhere($column, 'LIKE', "%{$searchText}%");
                }
            });
        }

        return $query->offset($offset)->limit($limit)->get();
    }

    public static function deleteRecord(string $tableName, int $id)
    {
        return DB::table($tableName)->where('id', $id)->delete();
    }

    public static function beginTransaction()
    {
        return DB::beginTransaction();
    }

    public static function commit()
    {
        return DB::commit();
    }

    public static function rollback()
    {
        return DB::rollBack();
    }

    public static function getCount(string $tableName, array $whereCondition = [])
    {
        $query = DB::table($tableName);

        if (!empty($whereCondition)) {
            $query->where($whereCondition);
        }

        return $query->count();
    }

    public static function fetchWithJoins(string $baseTable, array $joins = [], array $select = ['*'], array $where = [], array $orderBy = [])
    {
        $query = DB::table($baseTable);

        foreach ($joins as $join) {
            $type = $join['type'] ?? 'inner';
            $query->join($join['table'], $join['base_column'], '=', $join['join_column'], $type);
        }

        $query->select($select);

        if (!empty($where)) {
            foreach ($where as $key => $value) {
                if (is_array($value)) {
                    $query->whereIn($key, $value);
                } else {
                    $query->where($key, $value);
                }
            }
        }

        if (!empty($orderBy)) {
            foreach ($orderBy as $column => $direction) {
                $query->orderBy($column, $direction);
            }
        }

        try {
            return $query->get();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public static function updateRecord(string $tableName, array $data, $where): int
    {
        $query = DB::table($tableName);

        if (is_numeric($where)) {
            $query->where('id', $where);
        } elseif (is_array($where)) {
            foreach ($where as $column => $value) {
                is_array($value)
                    ? $query->whereIn($column, $value)
                    : $query->where($column, $value);
            }
        } else {
            return 0;
        }

        return $query->update($data);
    }

    public static function upsert(string $table, array $records, array $updateColumns)
    {
        return DB::table($table)->upsert($records, ['invoice_id', 'id'], $updateColumns);
    }
}
