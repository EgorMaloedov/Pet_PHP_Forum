<?php
session_start();
require_once("db.php");
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
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header"><h3>Комментарии</h3></div>

                            <div class="card-body">
                              <?php if ($_SESSION["err_name"] == 0 && $_SESSION["err_text"] == 0 && $_SESSION["handler"]==0) {
                                echo '
                                <div class="alert alert-success" role="alert">
                                  Комментарий успешно добавлен
                                </div>';
                              } ?>


                                <?php
                                $sql  = "SELECT * FROM comments";
                                $stmt = $pdo -> query($sql);
                              $comments = array_reverse($stmt -> fetchAll(PDO::FETCH_ASSOC));

                                    foreach ($comments as $comment):
                                      ?>

                                  <div class="media">
                                            <img src="img/no-user.jpg" class="mr-3" alt="..." width="64" height="64">
                                              <div class="media-body">
                                                <h5 class="mt-0"><?php echo $comment["name"]; ?></h5>
                                                <span><small><?php echo $comment["date"]; ?></small></span>
                                                <p>
                                                   <?php echo $comment["text"];?>
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
                                    <div class="form-group">
                                    <label for="exampleFormControlTextarea1" name = "name">Имя</label>
                                    <input name="name" class="form-control <?php if ($_SESSION["err_name"]!=0 && $_SESSION["handler"] == 0): echo "is-invalid";?>" id="exampleFormControlTextarea1" />
                                      <?php
                                      switch ($_SESSION["err_name"]) {
                                          case 1:
                                          $txt = "Пожалуй, это имя слишком короткое...";
                                          break;
                                          case 2:
                                          $txt = "Оно слишком длинное(32)";
                                          break;
                                        }
                                      echo
                                      ' <span class="invalid-feedback" role="alert">
                                            <strong>'.$txt.'
                                                </strong>
                                        </span>';

                                      endif;
                                       ?>
                                  </div>

                                  <div class="form-group">
                                    <label for="exampleFormControlTextarea1" name = "text">Сообщение</label>
                                    <textarea name="text" class="form-control <?php if ($_SESSION["err_text"]!=0 && $_SESSION["handler"] == 0) echo "is-invalid";?>" id="exampleFormControlTextarea1" rows="3"></textarea>


                                    <?php
                                    if ($_SESSION["err_text"]!=0 && $_SESSION["handler"] == 0){
                                    switch ($_SESSION["err_text"]) {
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
<?php $_SESSION["handler"]=1; ?>
