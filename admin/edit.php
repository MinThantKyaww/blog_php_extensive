<?php
    session_start();
    require 'config.php';
    require 'common.php';

    if ($_POST) {
      $title = $_POST['title'];
      $desc = $_POST['description'];
      $id=$_GET['id'];
      if ($_FILES['image']['name'] != null) {

          $image=$_FILES['image']['name'];
          $targetFile = 'images/'.($_FILES['image']['name']);
          $imageType = pathinfo($targetFile,PATHINFO_EXTENSION);

          if ($imageType != 'jpg' &&  $imageType != 'png' && $imageType != 'jpeg') {
             echo "image type can't be assessed";
          }
          else {
              move_uploaded_file($_FILES['image']['tmp_name'],$targetFile);
          }
          if ($_POST['title'] == '' || $_POST['description'] == '') {
              echo "<script>alert('title and description cannot be empty')</script>";
          }
          else{
                $pdostatement= $pdo->prepare("UPDATE post SET title='$title',description='$desc',image='$image' WHERE id ='$id'");
                $result = $pdostatement->execute();
          if($result) {
              echo "<script>alert('record update successful:');window.location.href='index.php';</script>";
          }
          }
      }
      else {
        if ($_POST['title'] == '' || $_POST['description'] == '') {
              echo "<script>alert('title and description cannot be empty')</script>";
          }
        else{
            $pdostatement= $pdo->prepare("UPDATE post SET title='$title',description='$desc' WHERE id ='$id'");
        $result = $pdostatement->execute();
        if($result) {
            echo "<script>alert('record update successful:without changing photo');window.location.href='index.php';</script>";
        }
        }
      }
    }

       $pdo_statement = $pdo->prepare("SELECT * FROM post WHERE id=".$_GET['id']);
       $pdo_statement->execute();
       $result = $pdo_statement->fetchAll();
    //    print'<pre>';
    //    print_r($result);
    //    exit();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit record</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css" >
</head>
<body>
<div class="card">
        <div class="card-body">
            <h1>Edit</h1>
            <form action="" method="post" enctype="multipart/form-data">
            <input name="_token" type="hidden" value="<?php echo $_SESSION['_token']; ?>">
            <input type="hidden" name="id" value="<?php echo escape($result[0]['id'])?>">
            <div class="form-group">
                <label for="username">Title</label>
                <input type="text" class="form-control" name="title" value="<?php echo escape($result[0]['title'])?>">
            </div>
            <div class="form-group">
                <label for="username">description</label>
                <input type="text" class="form-control" name="description" value="<?php echo escape($result[0]['description'])?>">
            </div>
            <div class="form-group">
                <label for="image">image</label>
                <img src="images/<?php echo $result[0]['image']?>" style="float:right"  width="100px" height="100px"  alt="">
                <input type="file" class="form-control" name="image" value="">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" name="" value="Update">
                <a class="btn btn-warning" href="index.php">Back</a>
            </div>
            </form>
        </div>
    </div>
</body>
</html>
