<?php
    require 'admin/config.php';
    session_start();
    if (empty($_SESSION['user_id']) ||  empty($_SESSION['logged_in'])) {
        echo "<script>
        alert('please log in to continue:');
        window.location.href='login.php';
        </script>";
    }

    $pdo_statement = $pdo->prepare("SELECT * FROM post WHERE id=".$_GET['id']);
    $pdo_statement->execute();
    $result = $pdo_statement->fetchAll();
    // print'<pre>';
    // print_r($_GET['id']);
    // exit();
    $post_id=$_GET['id'];
    $pdo_statement1 = $pdo->prepare("SELECT * FROM comments WHERE post_id=$post_id");
    $pdo_statement1->execute();
    $cmresult = $pdo_statement1->fetchAll();

    // print'<pre>';
    // print_r($cmresult);
    // exit();


    // $pdo_statement2 = $pdo->prepare("SELECT * FROM users WHERE id=".$_SESSION['user_id']);
    // $pdo_statement2->execute();
    // $Result = $pdo_statement2->fetchAll();
    // print'<pre>';
    // print_r($Result);
    // exit();

    if ($_POST) {
      $comment=$_POST['comment'];
      if ($_POST['comment'] != '') {
        $sql = "INSERT INTO comments(content,author_id,post_id) VALUES(:content,:authour_id,:post_id)";
        $pdoStmt = $pdo->prepare($sql);
        $cmtresult = $pdoStmt->execute(
        array(':content'=>$comment,':authour_id'=>$_SESSION['user_id'],':post_id'=>$post_id));

          if ($cmtresult) {
          header('Location: blogdetails.php?id='.$post_id);
          }
      }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>blogdetails</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="container-xl">
  <div class="row">
    <div class="col-md-12">
      <!-- Box Comment -->
      <div class="card card-widget">
        <div class="card-header">
          <h1 style="text-align:center !important">blog post</h1>
          <!-- /.user-block -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <img class="img-fluid pad" src="admin/images/<?php echo $result[0]['image']?>" alt="Photo">
          <br><br>
          <p><?php echo $result[0]['description']?></p>
          <a type="button" class="btn btn-success" href="/blog">Go back to home page</a>

        </div>

        <!-- /.card-body -->
        <div class="card-footer card-comments">
          <h3 style="text-algin:center !important">Comments</h3>

          <?php
          foreach ($cmresult as $value) {?>
            <div class="card-comment">
              <!-- User image -->
              <img class="img-circle img-sm" src="dist/img/user4-128x128.jpg" alt="User Image">

              <div class="comment-text">
                <span class="username">
                <?php

                  $name=$value['author_id'];
                  $pdo_statement2 = $pdo->prepare("SELECT * FROM users WHERE id=$name");
                  $pdo_statement2->execute();
                  $Result = $pdo_statement2->fetchAll();


                ?>
                <?php echo $Result[0]['name']?>
                  <span class="text-muted float-right"><?php echo $value['created-at']?></span>
                </span><!-- /.username -->
                    <?php echo $value['content']?>
              </div>
              <!-- /.comment-text -->
            </div>
          <?php
        }
          ?>

        </div>
        <!-- /.card-footer -->
        <div class="card-footer">
          <form action="" method="post">
            <img class="img-fluid img-circle img-sm" src="dist/img/user4-128x128.jpg" alt="Alt Text">
            <!-- .img-push is used to add margin to elements next to floating images -->
            <div class="img-push">
              <input name="comment" type="text" class="form-control form-control-sm" placeholder="Press enter to post comment">
            </div>
          </form>
        </div>
        <!-- /.card-footer -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->
  </div>


  <footer style="margin-left:0px;" class="main-footer" style="margin-left:0px !Important">
    <strong>Copyright © 2014-2021 <a href="#">Min thant kyaw</a>.</strong>
        All rights reserved.
      <div class="float-right d-none d-sm-inline-block">
          <b><a  class="btn btn-warning" href="logout.php">Log out</a></b>
      </div>
  </footer>



<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
