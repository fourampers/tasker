<?php
namespace App\Models;

use App\Services\Database;

class AdminModel
{
    public $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function allTasks()
    {
        return $this->database->all("v_admin");
    }
    
}