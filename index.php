<?php
    require 'admin/config.php';
    session_start();
    if (empty($_SESSION['user_id']) ||  empty($_SESSION['logged_in'])) {
        echo "<script>
        alert('please log in to continue:');
        window.location.href='login.php';
        </script>";
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Blog posts</title>

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
          <h1 style="text-align:center !important">Blog Posts</h1>
        </div>
      </div>
      <div class="row">
        <?php
        if (!empty($_GET['pageno'])) {
          $pageno = $_GET['pageno'];
        }
        else {
          $pageno = 1;
        }
          $frames = 6;
          $offset = ($pageno - 1) * $frames;
          $pdostatement = $pdo->prepare("SELECT * FROM post ORDER BY id DESC");
          $pdostatement->execute();
          $rawResult = $pdostatement->fetchAll();
          $totalpages = ceil(count($rawResult)/$frames);

          $pdostatement = $pdo->prepare("SELECT * FROM post ORDER BY id DESC LIMIT $offset,$frames");
          $pdostatement->execute();
          $result = $pdostatement->fetchAll();

           if ($result) {
               foreach ($result as $value) {
           ?>
           <div class="col-md-4">
             <div class="card card-widget">
               <div class="card-header">
                   <h2 style="text-align:center !important"><?php echo $value['title']?></h2>
               </div>
               <div class="card-body">
                 <a href="blogdetails.php?id=<?php echo $value['id']?>"><img class="img-fluid pad" src="admin/images/<?php echo $value['image']?>" alt="Photo" width=100%></a>
               </div>
             </div>
           </div>
           <?php
               }
           }
        ?>

            <div class="col-md-6">
              <nav aria-label="Page navigation example" >
                <ul class="pagination">
                  <li class="page-item"><a class="page-link" href="?pageno=1">Fir</a></li>
                  <li class="page-item <?php if($pageno <= 1){echo 'disabled';}?>">
                    <a class="page-link" href="<?php if ($pageno <=1) {echo '#';}else {echo "?pageno=".($pageno-1);}?>">Previous</a>
                  </li>
                  <li class="page-item"><a class="page-link" href="#"><?php echo $pageno;?></a></li>
                  <li class="page-item <?php if($pageno >= $totalpages){echo 'disabled';}?>">
                    <a class="page-link" href="<?php if($pageno>=$totalpages){echo '#';}else{echo "?pageno=".($pageno+1);}?>">Next</a>
                  </li>
                  <li class="page-item"><a class="page-link" href="?pageno=<?php echo $totalpages?>">Last</a></li>
                </ul>
              </nav>
            </div>
            <div class="col-md-6">
              <a href="logout.php" class="btn btn-danger btn-block">logout.php</a>
            </div>



        </div>



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
