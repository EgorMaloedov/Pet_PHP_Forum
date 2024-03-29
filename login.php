<?php session_start();
 ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Комментарии</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="css/app.css" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="index.php">
                    Проект
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                            <li class="nav-item">
                                <a class="nav-link" href="login.php">Войти</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="register.php">Зарегестрироваться</a>
                            </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">Войти</div>

                            <div class="card-body">
                                <form method="POST" action="handler_login.php">

                                    <div class="form-group row">
                                        <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail адрес</label>

                                        <div class="col-md-6">
                                            <input id="email" type="email" class="form-control <?php if ($_SESSION["login"]["handler"] == 1 && $_SESSION["login"]["err"]["email"] == 1) echo'is-invalid'; ?> " name="email"  autocomplete="email" autofocus >
                                            <?php if ($_SESSION["login"]["handler"] == 1 && $_SESSION["login"]["err"]["email"] == 1)

                                          echo
                                          ' <span class="invalid-feedback" role="alert">
                                                    <strong>Логин или пароль неправильный </strong>
                                          </span>';
                                              ?>

                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password" class="col-md-4 col-form-label text-md-right">Пароль</label>

                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control <?php if ($_SESSION["login"]["handler"] == 1 && $_SESSION["login"]["err"]["pass"] == 1) echo'is-invalid'; ?>" name="password"  autocomplete="current-password">

                                            <?php if ($_SESSION["login"]["handler"] == 1 && $_SESSION["login"]["err"]["pass"] == 1)

                                          echo
                                          ' <span class="invalid-feedback" role="alert">
                                                    <strong>Логин или пароль неправильный </strong>
                                          </span>';
                                              ?>

                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-6 offset-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember" id="remember" value="remember">

                                                <label class="form-check-label" for="remember">
                                                    Запомнить меня
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col-md-8 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                               Войти
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
<?php
$_SESSION["login"]["handler"] = 0;
 ?>
