<?php
    require 'config.php';

    if (!empty($_POST)) {

        if ($_FILES) {
          $targetFile = 'images/'.($_FILES['image']['name']);
          $imageType  =  pathinfo($targetFile,PATHINFO_EXTENSION);


          if ($imageType != 'jpg' && $imageType != 'png' && $imageType != 'jpeg') {
              echo "we only accept jpg,png,jpeg";
          }else {
              move_uploaded_file($_FILES['image']['tmp_name'],$targetFile);
              $sql = "INSERT INTO post(title,description,image,created_at) VALUES(:title,:description,:image,:created_at)";
              $pdoStmt = $pdo->prepare($sql);
              $result = $pdoStmt->execute(
              array(':title'=>$_POST['title'],':description'=>$_POST['description'],':image'=>$_FILES['image']['name'],':created_at'=>$_POST['created_at']));
          }
              if ($result) {
                  echo "<script>alert('record add successful:');window.location.href='index.php';</script>";
              }
        }



    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New record</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="card">
        <div class="card-body">
            <h1>Register</h1>
            <form action="add.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="username">Title</label></br>
                <input type="text" class="form-control" name="title" value="" required>
            </div>
            <div class="form-group">
                <label for="username">description</label></br>
                <input type="text" class="form-control" name="description" value="" required>
            </div>
            <div class="form-group">
                <label for="image">image</label></br>
                <input type="file" class="form-control" name="image" value="" required>
            </div>
            <div class="form-group">
                <label for="date">date</label></br>
                <input type="date" class="form-control" name="created_at" value="" required>
            </div></br>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" name="" value="Submit">
                <a class="btn btn-warning" href="index.php">Back</a>
            </div>
            </form>
        </div>
    </div>
</body>
</html>
