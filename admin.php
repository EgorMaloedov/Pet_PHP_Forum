<?php
session_start();
if($_SESSION["admin"]["success"] == 1):
 ?>
<?php
session_start();
require_once("db.php");
 ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Комментарии - Админка</title>

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
                        <?php echo '   <li class="nav-item">
                                  <a class="nav-link" href="profile.php"><i>'.$_SESSION["user"]["name"].'</i></a>
                              </li>
                              <li class="nav-item">
                                  <a class="nav-link" href="exit.php">Выйти</a>
                              </li>
                              <li class="nav-item">
                                  <a class="nav-link" href="admin.php">Админка</a>
                              </li>
                          ';
                          ?>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header"><h3>Админ панель</h3></div>

                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Аватар</th>
                                            <th>Имя</th>
                                            <th>Дата</th>
                                            <th>Комментарий</th>
                                            <th>Действия</th>
                                        </tr>
                                    </thead>
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

                                    <tbody>
                                        <tr>
                                            <td>
                                                <img src="<?php echo $comment["img"]; ?>" alt="Аватарка" class="img-fluid" width="64" height="64">
                                            </td>
                                            <td><?php echo $comment["name"]; ?></td>
                                            <td><?php echo $comment["date"]; ?></td>
                                            <td><?php echo $comment["text"]; ?></td>
                                            <td>
                                                    <?php if($comment["status"]==0): ?><a href="admin_handler.php?id=<?php $id = $comment["id"]; echo $id;?>&action=accept" class="btn btn-success" >Разрешить</a><?php endif; ?>

                                                    <?php if($comment["status"]==1): ?><a href="admin_handler.php?id=<?php $id = $comment["id"]; echo $id;?>&action=ban" class="btn btn-warning">Запретить</a><?php endif; ?>

                                                <a href="admin_handler.php?id=<?php $id = $comment["id"]; echo $id;?>&action=delete" onclick="return confirm('are you sure?')" class="btn btn-danger">Удалить</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                      <?php endforeach; ?>
                                </table>
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
if($_SESSION["admin"]["success"] != 1)
header("Location: ../index.php");
 ?>
