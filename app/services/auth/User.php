<?php


namespace App\Services\Auth;

use App\Services\Database;


class User
{
    private $_database;
    private $_data;
    private $_sessionName;
    private $_isLoggedIn = false;

    public function __construct(Database $database)
    {
        $this->_database    = $database;
        $this->_sessionName = config("session.name");
    }

    public function login($username = null, $password = null)
    {
        if ($this->find($username)) {
            if ($this->data()->password === Hash::make($password, $this->data()->salt)) {
                Session::put($this->_sessionName, $this->data()->id);
                return true;
            }
        }
        return false;
    }

    public function logout()
    {
        Session::delete($this->_sessionName);
        if (!Session::exists($this->_sessionName)) {
            $this->_isLoggedIn = false;
        }
    }

    private function find($user)
    {
        if (is_int($user)) {
            $searchBy = ["id" => $user];
        } else if (is_string($user)) {
            $searchBy = ["username" => $user];
        }
        $this->_data = $this->_database->getBy("admin", $searchBy);
        if ($this->_data) {
            return true;
        }
        return false;
    }

    public function data()
    {
        return (object) $this->_data;
    }

    public function isLoggedIn()
    {
        if (Session::exists($this->_sessionName)) {
            $user = (int) Session::get($this->_sessionName);
            if ($this->find($user)) {
                $this->_isLoggedIn = true;
            }
        }
        return $this->_isLoggedIn;
    }
}