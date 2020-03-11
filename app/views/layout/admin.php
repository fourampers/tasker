<?php 
    use App\Services\Auth\Session;
?>
<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>My tasks</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/bootstrap-datepicker.min.css">
    <script src="/js/jquery-3.4.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="/js/moment-with-locales.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/bootstrap-datepicker.min.js"></script>
    <script src="/js/jquery.validate.min.js"></script>
</head>
<body class="text-white" style="background-color: #17202A;">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <?php if (Session::exists("user")): ?>
            <span class="navbar-brand mb-0 h1">Tasker <span class="badge badge-success"><a href="admin" class="text-decoration-none text-light">ADMIN</a></span></span>
        <?php else: ?>
            <span class="navbar-brand mb-0 h1">Tasker</span>
        <?php endif; ?>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/">Главная</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="create">Создать</a>
                </li>
            </ul>
        </div>
        <a href="logout" class="btn btn-danger">Выход</a>
    </nav>
    <div class="container" id="content">
        <?= $this->section('content') ?>
    </div>
    <!--<footer id="sticky-footer" class="py-4 bg-dark text-white-50">
        <div class="container text-center">
            <small>Copyright &copy; Your Website</small>
        </div>
    </footer>-->
</body>
</html>