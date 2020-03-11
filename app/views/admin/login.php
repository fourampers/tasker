<?php $this->layout('layout') ?>

<link rel="stylesheet" href="/css/admin/login.css">

<div class="col-md-12"><?= $message->display() ?></div>
<div class="container login-container">
    <div class="row d-flex justify-content-center">
        <div class="login-form-1">
            <h3>Авторизация</h3>
            <form action="/login" method="post" id="login">
                <div class="form-group">
                    <input type="text" class="form-control" id="username" name="username" placeholder="Имя пользователя *" value="" />
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Пароль *" value="" />
                </div>
                <div class="form-group">
                    <input type="submit" class="btnSubmit" value="Войти" />
                </div>
            </form>
        </div>
    </div>
</div>

<script src="/js/admin/validate.js"></script>