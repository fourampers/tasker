<?php $this->layout('layout/admin') ?>

<div class="row">
    <div class="col-md-12"><?= $message->display() ?></div>
    <div class="col-md-12">
        <h1>Панель администратора</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
    </div>
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-hover table-dark" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th class="th-sm text-center" scope="col">#</th>
                        <th class="th-sm text-left" scope="col">Задача</th>
                        <th class="th-sm text-left" scope="col">Пользователь</th>
                        <th class="th-sm text-left" scope="col">Email</th>
                        <th class="th-sm text-left" scope="col">Создана</th>
                        <th class="th-sm text-left" scope="col" colspan="2"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($tasks as $task):?>
                        <tr>
                            <td class="text-center">
                            <?php if ($task["status"] === "выполняется"): ?>
                                <a href="/task/<?= $task["id"] ?>/done" class="badge badge-light">выполнить</a>
                            <?php endif; ?>
                                <a href="/task/<?= $task["id"] ?>/edit" class="badge badge-light">изменить</a>
                            </td>
                            <td><?= $task["content"] ?></td>
                            <td><?= $task["user"] ?></td>
                            <td><?= $task["email"] ?></td>
                            <td><?= $task["created_at"] ?></td>
                            <td>
                                <span class="badge badge-pill badge-<?php echo ($task["status"] === "выполняется") ? "warning" : "success"; ?>"><?= $task["status"] ?></span>
                                <?php if (!empty($task["edited"])): ?>
                                    <span class="badge badge-pill badge-info">Отредактировано администратором</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
            </table>
        </div>
    </div>
</div>