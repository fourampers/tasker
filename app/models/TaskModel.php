<?php
namespace App\Models;

use App\Services\Database;

class TaskModel
{
    public $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function store($data)
    {
        if (empty($data) || !is_array($data)) {
            return false;
        }

        $userExists = ($this->database->getBy('user', $data['user'])) ? true : false;
        
        if ($userExists) {
            $data['task']['user_id'] = $this->database->getBy('user', $data['user'])['id'];
        } else {
            $data['user']['id'] = $data['task']['user_id'] = $this->database->getLast('user')['id'] + 1;
        }
        array_walk($data, function($values, $table) {
            $this->database->store($table, $values);
        });

        return true;
    }

    public function update($id, $data)
    {
        $this->database->update("task", $id, $data);
    }

    public function sort(array $sort)
    {
        return $this->database->sort('v_task', $sort['page'], $sort['per_page'], $sort['sort'], $sort['order']);
    }

}