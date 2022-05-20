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


if (!empty($_POST)) {

    if (empty($_POST['role'])) {
        $role=0;
    } else {
        $role=1;
    }

    $name=$_POST['name'];
    $email=$_POST['email'];
    $password=$_POST['password'];

    if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password'])) {
        if (empty($_POST['name'])) {
            $nameError = 'name cannot be empty';
        }
        if (empty($_POST['email'])) {
            $emailError = 'email cannot be empty';
        }
        if (empty($_POST['password'])) {
            $passwordError = 'password cannot be empty';
        }
    } else {
        $sql="INSERT INTO users(name,email,password,role) VALUES(:name,:email,:password,:role)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':name',$name);
    $stmt->bindValue(':email',$email);
    $stmt->bindValue(':password',$password);
    $stmt->bindValue(':role',$role);
    $stmt->execute();

    header('location: user_listenings.php');
    exit();
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
            <h1>User adding</h1>
            <form action="user_add.php" method="post">
            <input name="_token" type="hidden" value="<?php echo $_SESSION['_token']; ?>">
            <div class="form-group">
                <label for="username">Name</label></br>
                <input type="text" class="form-control" name="name" value="" >
            </div>
            <p style="color:red;"><?php echo empty($nameError) ? '' : $nameError;?></p>
            <div class="form-group">
                <label for="username">Email</label></br>
                <input type="email" class="form-control" name="email" value="" >
            </div>
            <p style="color:red;"><?php echo empty($emailError) ? '' : $emailError;?></p>
            <div class="form-group">
                <label for="password">Password</label></br>
                <input type="passsword" class="form-control" name="password" value="" >
            </div><br>
            <p style="color:red;"><?php echo empty($passwordError) ? '' : $passwordError;?></p>
            <div class="form-group">
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" name="role" id="flexSwitchCheckDefault">
                  <label class="form-check-label" for="flexSwitchCheckDefault">Role</label>
                </div>
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
