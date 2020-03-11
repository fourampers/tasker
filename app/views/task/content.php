<?php $this->layout('layout') ?>

<div class="container">
    <div class="row">
        <div class="col-md-6" id="errors"></div>
        <div class="col-md-12">
            <h1>Изменить задачу #<?= $id ?></h1>
            <form action="/task/<?= $id ?>/edit" method="post" id="create">
                <div class="form-group">
                    <input type="text" class="form-control" id="user" name="content" value="<?= $content ?>">
                </div>
                <div class="form-group">
                    <button class="btn btn-success" type="add">Добавить</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="/js/create/validate.js"></script>