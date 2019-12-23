<?php
session_start();
require_once("db.php");
if ($_COOKIE["email_cookie"] != 0 && $_COOKIE["name_cookie"] != 0) {
  $_SESSION["user"]["email"] = $_COOKIE["email_cookie"] ;
  $_SESSION["user"]["name"] = $_COOKIE["name_cookie"] ;
  $_SESSION["user"]["image"] = $_COOKIE["image_cookie"];
  $_SESSION["user"]["success"] = 1;
}
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
<?php if($_SESSION["user"]["success"] == 0) echo '   <li class="nav-item">
          <a class="nav-link" href="login.php">Войти</a>
      </li>
      <li class="nav-item">
          <a class="nav-link" href="register.php">Зарегестрироваться</a>
      </li>
  ';
    else {
      echo ' <li class="nav-item">
                <a class="nav-link" href="profile.php"><i>'.$_SESSION["user"]["name"].'</i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="exit.php">Выйти</a>
            </li> ';
    }
  ?>





                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
          <?php
          if ($_SESSION["flash"]["reg"] == 1 && $_SESSION["reg"]["handler"] == 1)
          echo
          '<div class="alert alert-success" style="text-align:center;"role="alert">
            Успешная регистрация
          </div>';

          if ($_SESSION["flash"]["login"] == 1 && $_SESSION["login"]["handler"] == 1){
            $log = $_SESSION["user"]["name"];
          echo
          '<div class="alert alert-success" style="text-align:center;"role="alert">
            Добро пожаловать <i>'.$log.'
          </i></div>';
        }
           ?>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header"><h3>Комментарии</h3></div>

                            <div class="card-body">
                              <?php if ($_SESSION["flash"]["message"] == 1 && $_SESSION["message"]["handler"] == 1) {
                                echo '
                                <div class="alert alert-success" role="alert">
                                  Комментарий успешно добавлен
                                </div>';
                              }
                                elseif ($_SESSION["flash"]["message"] == 0 && $_SESSION["message"]["handler"] == 1) {
                                  echo '
                                  <div class="alert alert-danger" role="alert">
                                    Комментарий не был добавлен
                                  </div>';
                                }

                               ?>


                                <?php
                                $sql  = "SELECT * FROM comments";
                                $stmt = $pdo -> query($sql);
                              $comments = array_reverse($stmt -> fetchAll(PDO::FETCH_ASSOC));

                                    foreach ($comments as $comment):
                                      if ($comment["mail"] == "NULL")
                                        $comment["img"] = "no-user.jpg";
                                        else {
                                          $email_log = "'".$comment["mail"]."'";
                                          $sql = "SELECT name,img FROM users WHERE email = ".$email_log."";
                                          $stmt = $pdo->prepare($sql);
                                          $stmt -> execute();
                                          $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                          $comment["name"] = $user[0]["name"];
                                          $comment["img"] = $user[0]["img"];
                                        }
                                      ?>

                                  <div class="media">
                                      <?php  if($comment["status"] == 1): ?><img src="<?php echo $comment["img"]; ?>" class="mr-3" alt="..." width="64" height="64"> <?php endif; ?>
                                              <div class="media-body">
                                                <h5 class="mt-0"><?php if($comment["status"] == 1) echo $comment["name"]; ?></h5>
                                                <span><small><?php if($comment["status"] == 1) echo $comment["date"]; ?></small></span>
                                                <p>
                                                   <?php if($comment["status"] == 1) echo $comment["text"];?>
                                                </p>

                                              </div>
                                          </div>

                                      <?php endforeach; ?>


                            </div>
                        </div>
                    </div>
                    <div class="col-md-12" style="margin-top: 20px;">
                        <div class="card">
                            <div class="card-header"><h3>Оставить комментарий</h3></div>

                            <div class="card-body">
                                <form action="handler.php" method="post">
                                      <?php if($_SESSION["user"]["success"] == 0): ?>
                                    <div class="form-group">
                                    <label for="exampleFormControlTextarea1" name = "name">Имя</label>
                                    <input name="name" class="form-control <?php if ($_SESSION["message"]["err"]["name"]!=0 && $_SESSION["message"]["handler"] == 1) echo "is-invalid";?>" id="exampleFormControlTextarea1" />
                                      <?php
                                      if ($_SESSION["message"]["err"]["name"]!=0 && $_SESSION["message"]["handler"] == 1){
                                      switch ($_SESSION["message"]["err"]["name"]) {
                                          case 1:
                                          $txt = "Мне кажется, что это имя слишком короткое...";
                                          break;
                                          case 2:
                                          $txt = "Имя слишком длинное(32)";
                                          break;
                                        }
                                      echo
                                      ' <span class="invalid-feedback" role="alert">
                                            <strong>'.$txt.'
                                                </strong>
                                        </span>';}

                                       ?>
                                  </div>
  <?php endif; ?>
                                  <div class="form-group">
                                    <label for="exampleFormControlTextarea1" name = "text">Сообщение</label>
                                    <textarea name="text" class="form-control <?php if ($_SESSION["message"]["err"]["text"]!=0 && $_SESSION["message"]["handler"] == 1) echo "is-invalid";?>" id="exampleFormControlTextarea1" rows="3"></textarea>


                                    <?php
                                    if ($_SESSION["message"]["err"]["text"]!=0 && $_SESSION["message"]["handler"] == 1){
                                    switch ($_SESSION["message"]["err"]["text"]) {
                                        case 1:
                                        $txt = "Неужели, вы не хотите ничего написать...";
                                        break;
                                        case 2:
                                        $txt = "Увы... но количество символов ограничено(255)";
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
                                  <button type="submit" class="btn btn-success">Отправить</button>
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
$_SESSION["flash"]["err_log"] = 0;
$_SESSION["flash"]["message"] = 0;
$_SESSION["flash"]["login"] = 0;
$_SESSION["flash"]["reg"] = 0;
$_SESSION["login"]["handler"] = 0;
$_SESSION["reg"]["handler"] = 0;
$_SESSION["message"]["handler"] = 0;

 ?>
