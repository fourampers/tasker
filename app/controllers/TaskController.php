<?php


namespace App\Controllers;

use League\Plates\Engine;
use Plasticbrain\FlashMessages\FlashMessages;
use App\Services\Redirect;
use App\Services\Auth\Session;
use App\Models\TaskModel;

class TaskController
{
    private $_model;
    private $_view;
    private $_msg;

    public function __construct(TaskModel $model, Engine $view, FlashMessages $msg)
    {
        $this->_model = $model;
        $this->_view  = $view;
        $this->_msg   = $msg;
    }

    public function index()
    {
        $page = (!empty($_GET['page'])) ? $_GET['page'] : 1;
        $perPage = (!empty($_GET['per_page'])) ? $_GET['per_page'] : 3;

        if (!empty($_GET['sort']) && !empty($_GET['order'])) {
            Session::put("sort", ["by" => $_GET['sort'], "order" => $_GET['order']]);
        }

        $sort = [
            'sort' => Session::get("sort")["by"] ?? $_GET['sort'] ?? '',
            'order' => Session::get("sort")["order"] ?? $_GET['order'] ?? '',
            'page' => $page,
            'per_page' => $perPage
        ];

        if (!empty($sort['sort']) && !empty($sort['order'])) {
            $tasks = $this->_model->sort($sort);
        } else {
            $tasks = $this->_model->database->getPaginatedFrom('v_task', $page, $perPage);
        }

        $paginator = paginate(
            $this->_model->database->getCount('v_task'),
            $page,
            $perPage,
            '?page=(:num)'
        );
        echo $this->_view->render('task/index', ['tasks' => $tasks, 'paginator' => $paginator, "message" => $this->_msg]);
    }

    public function create()
    {
        echo $this->_view->render('task/create', ["message" => $this->_msg]);
    }

    public function store()
    {
        if (!$this->_model->store($_POST)) {
            $this->_msg->error("Задача не может быть добавлена: необюходимые поля пустые!");
            Redirect::to("/create");
        }
        $this->_msg->success("Задача добавлена!");
        Redirect::to("/");
    }

    public function content($id)
    {
        $content = $this->_model->database->getOne("task", $id)['content'];
        echo $this->_view->render("task/content", ["id" => $id, "content" => $content]);
    }

    public function updateStatus($id)
    {
        if (Session::exists("user")) {
            $this->_model->update($id, ["status_id" => 2]);
            $this->_msg->success("Статус задачи изменен!");
        }
        Redirect::to("/admin");
    }

    public function updateContent($id)
    {
        if (Session::exists("user")) {
            $this->_model->update($id, ["content" => $_POST['content'], "edited" => 1]);
            $this->_msg->success("Задача отредактирована!");
        }
        Redirect::to("/admin");
    }

}