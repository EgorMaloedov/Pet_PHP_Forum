<?php
session_start();
if ($_SESSION["user"]["success"] == 1):
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
                                <a class="nav-link" href="profile.php"><i><?php echo $_SESSION["user"]["name"]; ?></i></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="exit.php">Выйти</a>
                            </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
          <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header"><h3>Профиль пользователя</h3></div>

                        <div class="card-body">

                          <?php

                           if ($_SESSION["flash"]["profile"] == 1 && $_SESSION["profile"]["handler"] == 1)
                          echo '<div class="alert alert-success" role="alert">
                            Профиль успешно обновлен
                          </div>';
                          elseif ($_SESSION["flash"]["profile"] == 0 && $_SESSION["profile"]["handler"] == 1) {
                            echo '<div class="alert alert-danger" role="alert">
                              Профиль не был обновлен
                            </div>';
                          }

                          ?>

                            <form action="handler_profile.php" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Имя</label>
                                            <input type="text" class="form-control <?php if ($_SESSION["profile"]["err"]["name"] != 0 && $_SESSION["profile"]["handler"] != 0) echo"is-invalid"; ?>" name="name" id="exampleFormControlInput1" value="<?php echo $_SESSION["user"]["name"]; ?>">
                                            <?php
                                            if ($_SESSION["profile"]["err"]["name"] != 0 && $_SESSION["profile"]["handler"] != 0)
                                            {
                                              switch ($_SESSION["profile"]["err"]["name"]) {
                                                case 1:
                                                  $text = "Имя пустое";
                                                break;
                                                case 2:
                                                  $text = "Переполнение строки (32)";
                                                break;
                                                case 3:
                                                  $text = "Имя занято";
                                                break;
                                              }
                                            echo'<span class="text text-danger">
                                                '.$text.'
                                            </span>';
                                            }
                                            ?>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Email</label>
                                            <input type="email" class="form-control <?php if ($_SESSION["profile"]["err"]["email"] != 0 && $_SESSION["profile"]["handler"] != 0) echo"is-invalid"; ?>" name="email" id="exampleFormControlInput1" value="<?php echo $_SESSION["user"]["email"]; ?>">
                                            <?php
                                            if ($_SESSION["profile"]["err"]["email"] != 0 && $_SESSION["profile"]["handler"] != 0)
                                            {
                                              switch ($_SESSION["profile"]["err"]["email"]) {
                                                case 1:
                                                  $text = "Email пустой";
                                                break;
                                                case 2:
                                                  $text = "Переполнение строки (40)";
                                                break;
                                                case 3:
                                                  $text = "Такой Email зарегестрирован";
                                                break;
                                                case 4:
                                                  $text = "Email не соответствует стандарту";
                                                  break;
                                              }
                                            echo'<span class="text text-danger">
                                                '.$text.'
                                            </span>';
                                            }
                                            ?>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Аватар</label>
                                            <input type="file" class="form-control <?php if($_SESSION["profile"]["err"]["image"] != 0) echo "is-invalid"; ?>" name="image" id="exampleFormControlInput1">
                                            <?php
                                              if($_SESSION["profile"]["err"]["image"] != 0)
                                              {
                                                switch($_SESSION["profile"]["err"]["image"]){
                                                  case 1:
                                                  $text = "Файл не выбран";
                                                }
                                                echo'<span class="text text-danger">
                                                    '.$text.'
                                                </span>';
                                              }
                                             ?>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <img src="<?php echo $_SESSION["user"]["image"] ?>" alt="Авотарочка" class="img-fluid">
                                    </div>

                                    <div class="col-md-12">
                                        <button class="btn btn-warning">Редактировать профиль</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-12" style="margin-top: 20px;">
                    <div class="card">
                        <div class="card-header"><h3>Безопасность</h3></div>

                        <div class="card-body">


                            <?php
                            if ($_SESSION["flash"]["security"] == 1 && $_SESSION["security"]["handler"] == 1)
                           echo '<div class="alert alert-success" role="alert">
                             Пароль успешно обновлен
                           </div>';
                           elseif ($_SESSION["flash"]["security"] == 0 && $_SESSION["security"]["handler"] == 1) {
                             echo '<div class="alert alert-danger" role="alert">
                               Пароль не был обновлен
                             </div>';
                           }
                             ?>

                            <form action="handler_security.php" method="post">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Текущий пароль</label>
                                            <input type="password" name="current" class="form-control <?php if ($_SESSION["profile"]["err"]["pass_current"] != 0 && $_SESSION["security"]["handler"] != 0) echo"is-invalid"; ?>" id="exampleFormControlInput1">
                                                <?php if ($_SESSION["profile"]["err"]["pass_current"] != 0 && $_SESSION["security"]["handler"] != 0){

                                                      switch($_SESSION["profile"]["err"]["pass_current"]){
                                                          case 1:
                                                            $text = "Пароль пустой";
                                                          break;
                                                          case 2:
                                                            $text = "Переполнение строки (32)";
                                                          break;
                                                          case 3:
                                                            $text = "Пароль неправильный";
                                                          break;
                                                      }
                                                      echo'<span class="text text-danger">
                                                          '.$text.'
                                                      </span>';
                                                      }

                                                 ?>

                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Новый пароль</label>
                                            <input type="password" name="password" class="form-control <?php if ($_SESSION["profile"]["err"]["new_pass"] != 0 && $_SESSION["security"]["handler"] != 0) echo"is-invalid"; ?>" id="exampleFormControlInput1">
                                            <?php if ($_SESSION["profile"]["err"]["new_pass"] != 0 && $_SESSION["security"]["handler"] != 0){

                                                  switch($_SESSION["profile"]["err"]["new_pass"]){
                                                      case 1:
                                                        $text = "Пароль пустой";
                                                      break;
                                                      case 2:
                                                        $text = "Переполнение строки (32)";
                                                      break;
                                                  }
                                                  echo'<span class="text text-danger">
                                                      '.$text.'
                                                  </span>';
                                                  }

                                             ?>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Подтверждение пароля</label>
                                            <input type="password" name="password_confirmation" class="form-control <?php if ($_SESSION["profile"]["err"]["pass_confirm"] != 0 && $_SESSION["security"]["handler"] != 0) echo"is-invalid"; ?>" id="exampleFormControlInput1">
                                            <?php if ($_SESSION["profile"]["err"]["pass_confirm"] != 0 && $_SESSION["security"]["handler"] != 0){

                                                  switch($_SESSION["profile"]["err"]["pass_confirm"]){
                                                      case 1:
                                                        $text = "Пароль пустой";
                                                      break;
                                                      case 2:
                                                        $text = "Переполнение строки (32)";
                                                      break;
                                                      case 3:
                                                        $text = "Пароли не совпадают";
                                                      break;
                                                  }
                                                  echo'<span class="text text-danger">
                                                      '.$text.'
                                                  </span>';
                                                  }

                                             ?>
                                        </div>

                                        <button class="btn btn-success">Подтвердить</button>
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
endif;
if ($_SESSION["user"]["success"] == 0){
  header("Location: ../index.php");
}
$_SESSION["flash"]["security"] = 0;
$_SESSION["flash"]["profile"] = 0;
$_SESSION["profile"]["handler"] = 0;
$_SESSION["security"]["handler"] = 0;
 ?>
