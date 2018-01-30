<?php

namespace Simple\Database;

class QueryBuilder
{
    private $connection;
    private $query = '';
    private $values;
    private $statement;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection->getConnection();
    }

    public function select(string $table, $columns) : self
    {
        $table = $this->prepareName($table);

        $this->query = 'SELECT ';

        if(is_array($columns)) {

            foreach ($columns as $column) {
                $this->query .= $column . ', ';
            }
            $this->query = rtrim($this->query, ', ');

        } else {
            $this->query .= $this->prepareValueName($columns);
        }

        $this->query .= ' FROM ' . $table;

        return $this;
    }

    public function where(string $column, string $condition, string $value) : self
    {
        $this->addValue($column, $value);

        $this->query .= ' WHERE ';
        $this->query .= "{$this->prepareName($column)} {$condition} {$this->prepareValueName($column)}";

        return $this;
    }

    public function join(string $table, string $local, string $foreign) : self
    {
        $table = $this->prepareName($table);

        $this->query .= ' JOIN ' . $table;
        $this->query .= ' ON ' . $local . ' = '. $foreign;

        return $this;
    }

    public function limit(int $count, int $offset = null) : self {

        if ($offset) {
            $this->query .= " LIMIT :offset, :count";
            $this->addValue('offset', $offset);
        } else {
            $this->query .= " LIMIT :count";
        }
        $this->addValue('count', $count);

        return $this;
    }

    public function orderBy(string $column, string $sort = 'ASC') : self
    {
        $column = $this->prepareName($column);

        $this->query .= " ORDER BY {$column} {$sort}";

        return $this;
    }

    public function insert(string $table, array $values) : self
    {
        $table = $this->prepareName($table);
        $this->query = 'INSERT INTO ';
        $this->query .= $table;

        $queryColumn = ' (';
        $queryValue = 'VALUES (';

        foreach ($values as $key => $value) {
            $queryColumn .= $this->prepareName($key) . ', ';
            $queryValue .= $this->prepareValueName($key) . ', ';

            $this->addValue($key, $value);
        }

        $queryColumn = rtrim($queryColumn, ', ') . ')';
        $queryValue = rtrim($queryValue, ', ') . ')';

        $this->query .=  $queryColumn . ' ' . $queryValue;

        return $this;
    }

    public function update($table, array $values) : self
    {
        $table = $this->prepareName($table);

        $this->query = 'UPDATE ';
        $this->query .= $table . ' SET ';

        foreach ($values as $key => $value) {
            $this->query .= $this->prepareName($key) . ' = ' . $this->prepareValueName($key) . ', ';

            $this->addValue($key, $value);
        }
        $this->query = rtrim($this->query, ', ');
        
        return $this;
    }

    public function delete(string $table) : self
    {
        $table = $this->prepareName($table);

        $this->query = 'DELETE FROM '. $table;

        return $this;
    }

    public function execute()
    {
        try {
            $this->prepare();
            $this->statement->execute($this->values);
            return $this->fetch();
        } catch (\Exception $e) {
            return false;
        }

    }

    private function getStatement()
    {
        return $this->statement;
    }

    private function fetch()
    {
        return $this->getStatement()->fetchAll();
    }

    private function addValue(string $key, $value)
    {
        $this->values[$key] = $value;
    }

    private function prepareName(string $column) : string
    {
        $result = "`".str_replace("`","``",$column)."`";
        return $result;
    }

    private function prepareValueName($value)
    {
        $result = ":{$value}";

        return $result;
    }

    private function prepare()
    {
        $this->statement = $this->connection->prepare($this->query);
    }
}