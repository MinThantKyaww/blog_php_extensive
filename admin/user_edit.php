<?php
    session_start();
    require 'config.php';
    require 'common.php';

    if ($_POST) {
      $name = $_POST['name'];
      $email = $_POST['email'];
      $id=$_GET['id'];
      
        if (empty($_POST['name']) || empty($_POST['email'])) {
            if (empty($_POST['name'])) {
            $nameError = 'name cannot be empty';
        }
        if (empty($_POST['email'])) {
            $emailError = 'email cannot be empty';
        }
        } else {
            $pdostatement= $pdo->prepare("UPDATE users SET name='$name',email='$email' WHERE id ='$id'");
        $result = $pdostatement->execute();
        if($result) {
              echo "<script>alert('record update successful:');window.location.href='user_listenings.php';</script>";
          }
        }
        
    }

       $pdo_statement = $pdo->prepare("SELECT * FROM users WHERE id=".$_GET['id']);
       $pdo_statement->execute();
       $result = $pdo_statement->fetchAll();

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
            <form action="" method="post">
            <input name="_token" type="hidden" value="<?php echo $_SESSION['_token']; ?>">
            <input type="hidden" name="id" value="<?php echo $result[0]['id']?>">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name" value="<?php echo escape($result[0]['name'])?>">
            </div>
            <p style="color:red;"><?php echo empty($nameError) ? '' : $nameError;?></p>
            <div class="form-group">
                <label for="role">Email</label>
                <input type="email" class="form-control" name="email" value="<?php echo escape($result[0]['email'])?>">
            </div><br>
            <p style="color:red;"><?php echo empty($emailError) ? '' : $emailError;?></p>
            <div class="form-group">
                 <div class="form-group">
                    <label for="">Role</label>
                    <input type="checkbox" name="role" value="1" <?php echo $result[0]['role'] == 1 ? 'checked':''?>>
                  </div>
            </div></br>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" name="" value="Update">
                <a class="btn btn-warning" href="user_listenings.php">Back</a>
            </div>
            </form>
        </div>
    </div>
</body>
</html>
