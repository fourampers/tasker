<?php


namespace App\Controllers;

use App\Models\AdminModel;
use League\Plates\Engine;
use Plasticbrain\FlashMessages\FlashMessages;
use App\Services\Redirect;
use App\Services\Auth\Session;
use App\Services\Auth\User;

class AdminController
{
    private $_model;
    private $_view;
    private $_user;
    private $_msg;

    public function __construct(AdminModel $model, Engine $view,  User $user, FlashMessages $msg)
    {
        $this->_model = $model;
        $this->_view  = $view;
        $this->_user  = $user;
        $this->_msg   = $msg;
    }

    public function index()
    {
        if (!Session::exists("user")) {
            Redirect::to("/login");
        }
        $tasks = $this->_model->allTasks();
        echo $this->_view->render('admin/index', ["tasks" => $tasks, "message" => $this->_msg]);
    }

    public function login()
    {
        if (Session::exists("user")) {
            Redirect::to("/admin");
        }
        echo $this->_view->render('admin/login', ["message" => $this->_msg]);
    }

    public function attempt()
    {
        if (!$this->_user->login($_POST["username"], $_POST["password"])) {
            $this->_msg->error("Неверный логин и/или пароль!");
            Redirect::to("/login");
        }
        $this->_msg->success("Успешная авторизация!");
        Redirect::to("/admin");
    }

    public function logout()
    {
        if (Session::exists("user")) {
            $this->_user->logout();
        }
        Redirect::to("/");
    }

}