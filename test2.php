<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="wrapper">


    <?php
    if (!empty($_GET['pageno'])) {
      $pageno = $_GET['pageno'];
    }
    else {
      $pageno = 1;
    }
      $frames = 5;
      $offset = ($pageno - 1) * $frames;



      if (!empty($_POST['searchbox'])) {
        $searchKey = $_POST['searchbox'];
        $pdostatement = $pdo->prepare("SELECT * FROM post WHERE title LIKE '%$searchKey%' ORDER BY id DESC");
        $pdostatement->execute();
        $rawResult = $pdostatement->fetchAll();
        $totalpages = ceil(count($rawResult)/$frames);

        $pdostatement = $pdo->prepare("SELECT * FROM post WHERE title LIKE '%$searchKey%' ORDER BY id DESC LIMIT $offset,$frames");
        $pdostatement->execute();
        $result = $pdostatement->fetchAll();
      }
      else {
        $pdostatement = $pdo->prepare("SELECT * FROM post ORDER BY id DESC");
        $pdostatement->execute();
        $rawResult = $pdostatement->fetchAll();
        $totalpages = ceil(count($rawResult)/$frames);

        $pdostatement = $pdo->prepare("SELECT * FROM post ORDER BY id DESC LIMIT $offset,$frames");
        $pdostatement->execute();
        $result = $pdostatement->fetchAll();
      }


    ?>
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link"  data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline" action="" method="post">
            <div class="input-group input-group-sm">
              <input name="searchbox" class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>


    </ul>


  </nav>
    <div class="card">
      <div class="card-body">
            <table class="table table-bordered">
              <h1>Post mangement</h1>
                <div>
                    <a class="btn btn-primary"  href="add.php">Create new</a>
                    <a style="float:right;" class="btn btn-warning" href="logout.php">Log out</a></br>
                </div></br>
                <thead>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Created_at</th>
                    <th>Action</th>
                </thead>
                <tbody>
                   <?php
                    if ($result) {
                        foreach ($result as $value) {
                    ?>
                    <tr>
                        <td><?php echo $value['title']?></td>
                        <td><?php echo substr($value['description'],0,15)?></td>
                        <td><?php echo date('d/m/y',strtotime($value['created_at']))?></td>
                        <td>
                            <a href="edit.php?id=<?php echo $value['id']?>" type="button" class="btn btn-warning">Edit</a>
                            <a href="delete.php?id=<?php echo $value['id']?>" onclick="return confirm('Are you sure you want to delete this item?');"
                              class="btn btn-danger">Delete</a>

                              </td>
                    </tr>


                    <?php
                        }
                    }
                   ?>
                </tbody>
            </table>
        <nav aria-label="Page navigation example">
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
    </div>
  </div>
</body>
</html>
