<?php
    session_start();
    require 'config.php';
    require 'common.php';

    if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
      header('Location: login.php');
    }
    if ($_SESSION['role'] != 1) {
      header('Location: login.php');
    }
    // print"<pre>";
    // print_r($_FILES);
    // exit();

    if ($_POST) {
        if (empty($_POST['title']) || empty($_POST['description']) || empty($_FILES['image']['name'])) {
        if (empty($_POST['title'])) {
            $titleError = 'title cannot be empty';
        }
        if (empty($_POST['description'])) {
            $descriptionError = 'description cannot be empty';
        }
        if (empty($_FILES['image']['name'])) {
            $imageError = 'image cannot be empty';
        }
    } else {
        

        if ($_FILES) {
          $targetFile = 'images/'.($_FILES['image']['name']);
          $imageType  =  pathinfo($targetFile,PATHINFO_EXTENSION);


          if ($imageType != 'jpg' && $imageType != 'png' && $imageType != 'jpeg') {
            echo "<script>alert('we only accept jpg,png,jpeg');</script>";
          }else {
              move_uploaded_file($_FILES['image']['tmp_name'],$targetFile);
              $sql = "INSERT INTO post(title,description,image) VALUES(:title,:description,:image)";
              $pdoStmt = $pdo->prepare($sql);
              $result = $pdoStmt->execute(
              array(':title'=>$_POST['title'],':description'=>$_POST['description'],':image'=>$_FILES['image']['name']));
            }
              if ($result) {
                  echo "<script>alert('record add successful:');window.location.href='index.php';</script>";
              }
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
            <h1>New record</h1>
            <form action="add.php" method="post" enctype="multipart/form-data">
            <input name="_token" type="hidden" value="<?php echo $_SESSION['_token']; ?>">
            <div class="form-group">
                <label for="username">Title</label></br>
                <p style="color:red;"><?php echo empty($titleError) ? '' : $titleError;?></p>
                <input type="text" class="form-control" name="title" value="" >
            </div>
            <div class="form-group">
                <label for="username">description</label></br>
                <p style="color:red;"><?php echo empty($descriptionError) ? '' : $descriptionError;?></p>
                <input type="text" class="form-control" name="description" value="" >
            </div>
            <div class="form-group">
                <label for="image">image</label></br>
                <p style="color:red;"><?php echo empty($imageError) ? '' : $imageError;?></p>
                <input type="file" class="form-control" name="image" value="" >
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" name="" value="Submit">
                <a class="btn btn-warning" href="index.php">Back</a>
            </div>
            </form>
        </div>
    </div>
</body>
</html>
