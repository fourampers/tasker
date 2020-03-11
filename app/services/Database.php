<?php

namespace App\Services;

use PDO;
use Aura\SqlQuery\QueryFactory;

class Database
{
    private $_queryFactory;
    private $_pdo;

    public function __construct(QueryFactory $queryFactory, PDO $pdo)
    {
        $this->_queryFactory = $queryFactory;
        $this->_pdo = $pdo;
    }

    public function all($table)
    {
        $select = $this->_queryFactory->newSelect();
        $select->cols(["*"])
            ->from($table);

        $sth = $this->_pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOne($table, $id)
    {
        $select = $this->_queryFactory->newSelect();
        $select->cols(["*"])
            ->from($table)
            ->where('id=:id')
            ->bindValues(['id'  =>  $id]);

        $sth = $this->_pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        return $sth->fetch(PDO::FETCH_ASSOC);
    }

    public function getLast($table)
    {
        $select = $this->_queryFactory->newSelect();
        $select->cols(["*"])
            ->from($table)
            ->orderBy(['id DESC'])
            ->limit(1);
        $sth = $this->_pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        return $sth->fetch(PDO::FETCH_ASSOC);
    }

    public function getBy($table, array $filters)
    {
        $filters = self::removeEmptyFilter($filters);

        $select = $this->_queryFactory->newSelect();
        $select->cols(["*"])
        ->from($table)
        ->where(self::setSearchStatement(array_keys($filters)))
        ->bindValues($filters);
        
        $sth = $this->_pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        return $sth->fetch(PDO::FETCH_ASSOC);
    }

    public function store($table, $data)
    {
        $data = array_map(function($value) {
            return strip_tags($value);
        }, $data);

        $insert = $this->_queryFactory->newInsert();

        $insert
            ->into($table)
            ->cols(self::removeEmptyFilter($data));

        $sth = $this->_pdo->prepare($insert->getStatement());
        $sth->execute($insert->getBindValues());
    }

    public function update($table, $id, $data)
    {
        $update = $this->_queryFactory->newUpdate();

        $update
            ->table($table)                  // update this table
            ->cols($data)          // raw value as "(ts) VALUES (NOW())"
            ->where("`$table`.`id` = :id")
            ->bindValue('id', $id);

        $sth = $this->_pdo->prepare($update->getStatement());
        $sth->execute($update->getBindValues());
    }

    public function delete($table, $id)
    {
        $delete = $this->_queryFactory->newDelete();

        $delete
            ->from($table)
            ->where('id = :id')
            ->bindValue('id', $id);

        $sth = $this->_pdo->prepare($delete->getStatement());

        $sth->execute($delete->getBindValues());
    }

    public function getPaginatedFrom($table, $page = 1, $rows = 1)
    {
        $select = $this->_queryFactory->newSelect();

        $select->cols(['*'])
            ->from($table)
            ->page($page)
            ->setPaging($rows);
        $sth = $this->_pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCount($table)
    {
        return count($this->all($table));
    }

    public function sort($table,  $page = 1, $rows = 1, $sort, $order)
    {
        /* 
        * Создаем специальный объект, который поможет
        * в составлении SQL - запроса для выборки задач.
        */
        $tasksOnPage = $this->_queryFactory->newSelect()
                                           ->cols(['*'])
                                           ->from($table)
                                           ->page($page)
                                           ->setPaging($rows);
        
        /*
        * Подготовленный SQL - запрос для выборки задач по следующим критериям:
        *   - номер страницы
        *   - количество задач на одной странице
        */
        $select = $this->_pdo->prepare($tasksOnPage->getStatement())->queryString;

        $sorted = $this->_queryFactory->newSelect();
        $sorted->cols(['*'])
            ->fromSubSelect($select, 'tasks_per_page')
            ->orderBy([$sort . " " . strtoupper($order)]);
        
        $sth = $this->_pdo->prepare($sorted->getStatement());
        $sth->execute($sorted->getBindValues());

        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function removeEmptyFilter(array $filters): array
    {
        foreach ($filters as $key => $value) {
            if (is_int($key) || empty($value)) {
                unset($filters[$key]);
            }
        }
        return $filters;
    }

    public static function setSearchStatement(array $filters): string
    {
        $result = implode(' AND ', array_map(function($filter) { return "$filter=:$filter"; }, $filters));
        return $result;
    }
}