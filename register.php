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
                            <div class="card-header">Регистрация</div>

                            <div class="card-body">
                                <form method="POST" action="handler_reg.php">

                                    <div class="form-group row">
                                        <label for="name" class="col-md-4 col-form-label text-md-right">Логин</label>

                                        <div class="col-md-6">
                                            <input id="name" type="text" class="form-control <?php if ($_SESSION["name_err"] != 0 && $_SESSION["handler_reg"] == 0) echo "is-invalid";?>" name="nm" autofocus>

                                            <?php
                                            if ($_SESSION["name_err"] != 0 && $_SESSION["handler_reg"] == 0){
                                            switch ($_SESSION["name_err"]) {
                                              case 1:
                                                $txt = 'Имя пустое';
                                                break;

                                              case 2:
                                                $txt = "Кол-во символов больше 32";
                                                break;
                                            }
                                            echo
                                            ' <span class="invalid-feedback" role="alert">
                                                  <strong>'.$txt.'
                                                      </strong>
                                              </span>';
                                            }
                                             ?>

                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail адрес</label>

                                        <div class="col-md-6">
                                          <input id="email" type="email" class="form-control <?php if ($_SESSION["email_err"] != 0 && $_SESSION["handler_reg"] == 0) echo "is-invalid";?>" name="email" >
                                            <?php
                                            if ($_SESSION["email_err"] != 0 && $_SESSION["handler_reg"] == 0){
                                            switch ($_SESSION["email_err"]) {
                                              case 1:
                                                $txt = 'Нулевая строка';
                                                break;

                                              case 2:
                                                $txt = "Кол-во символов больше 40";
                                                break;

                                              case 3:
                                                $txt = "Ошибка идентификации email";
                                                break;

                                              case 4:
                                                $txt = "Такая почта уже зарегестрирована";
                                                break;
                                            }
                                            echo
                                            ' <span class="invalid-feedback" role="alert">
                                                  <strong>'.$txt.'
                                                      </strong>
                                              </span>';
                                            }
                                             ?>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password" class="col-md-4 col-form-label text-md-right">Пароль</label>

                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control <?php if ($_SESSION["pass_err"] != 0 && $_SESSION["handler_reg"] == 0) echo "is-invalid";?> " name="password"  autocomplete="new-password">

                                            <?php
                                            if ($_SESSION["pass_err"] != 0 && $_SESSION["handler_reg"] == 0){
                                            switch ($_SESSION["pass_err"]) {
                                              case 1:
                                                $txt = 'Пароль пустой';
                                                break;

                                              case 2:
                                                $txt = "Кол-во символов больше 32";
                                                break;
                                            }
                                            echo
                                            ' <span class="invalid-feedback" role="alert">
                                                  <strong>'.$txt.'
                                                      </strong>
                                              </span>';
                                            }
                                             ?>

                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Подтвердите пароль</label>

                                        <div class="col-md-6">
                                            <input id="password-confirm" type="password" class="form-control <?php if ($_SESSION["password_confirm_err"] != 0 && $_SESSION["handler_reg"] == 0) echo "is-invalid";?>" name="password_confirmation"  autocomplete="new-password">

                                            <?php
                                            if ($_SESSION["password_confirm_err"] != 0 && $_SESSION["handler_reg"] == 0){
                                            switch ($_SESSION["password_confirm_err"]) {
                                              case 1:
                                                $txt = 'Пароли не совпадают';
                                                break;
                                            }
                                            echo
                                            ' <span class="invalid-feedback" role="alert">
                                                  <strong>'.$txt.'
                                                      </strong>
                                              </span>';
                                            }
                                             ?>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                Зарегестрироваться
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
<?php $_SESSION["handler_reg"] = 1; ?>
