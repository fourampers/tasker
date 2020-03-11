<?php $this->layout('layout') ?>

<div class="container">
    <div class="col-md-12"><?= $message->display() ?></div>
    <div class="row d-flex justify-content-center">        
        <div class="col-md-6">
            <h1>Новая задача</h1>
            <p>Поля <i>Пользователь</i> и <i>Email</i> должны быть обязательно заполнены!</p>
            <form action="store" method="post" id="create">
                <div class="form-group">
                    <input type="text" class="form-control" id="user" name="user[name]" placeholder="Пользователь">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="email" name="user[email]" placeholder="Email">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="content" name="task[content]" placeholder="Задача">
                </div>
                <div class="form-group">
                    <button class="btn btn-info" type="add">Добавить</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="/js/create/validate.js"></script>