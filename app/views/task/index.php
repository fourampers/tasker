<?php $this->layout('layout') ?>

<div class="row">
    <div class="col-md-12"><?= $message->display() ?></div>
    <div class="col-md-12">
        <h1>Все задачи</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-sm-6">
        <div class="dropdown show">
          <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Сортировать по</a>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            <a class="dropdown-item" href="?page=<?php echo $_GET['page'] ?? 1; ?>&sort=content&order=asc">Задача (возрастание)</a>
            <a class="dropdown-item" href="?page=<?php echo $_GET['page'] ?? 1; ?>&sort=content&order=desc">Задача (убывание)</a>
            <a class="dropdown-item" href="?page=<?php echo $_GET['page'] ?? 1; ?>&sort=user&order=asc">Пользователь (возрастание)</a>
            <a class="dropdown-item" href="?page=<?php echo $_GET['page'] ?? 1; ?>&sort=user&order=desc">Пользователь (убывание)</a>
            <a class="dropdown-item" href="?page=<?php echo $_GET['page'] ?? 1; ?>&sort=email&order=asc">Email (возрастание)</a>
            <a class="dropdown-item" href="?page=<?php echo $_GET['page'] ?? 1; ?>&sort=email&order=desc">Email (убывание)</a>
          </div>
        </div>
    </div>
</div>
<div class="row pt-2 pb-2">
    <div class="col-md-10">
        <div class="table-responsive">
            <table class="table table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th class="th-sm" scope="col">Задача</th>
                        <th class="th-sm" scope="col">Пользователь</th>
                        <th class="th-sm" scope="col">Email</th>
                        <th class="th-sm text-center" scope="col">Статус</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($tasks as $task):?>
                        <tr>
                            <td><?= $task['content'];?></td>
                            <td><?= $task['user'];?></td>
                            <td><?= $task['email'];?></td>
                            <td class="text-center"><span class="badge badge-pill badge-<?php echo ($task["status"] === "выполняется") ? "warning" : "success"; ?>"><?= $task["status"] ?></span></td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?= paginator($paginator); ?>
    </div>
</div>