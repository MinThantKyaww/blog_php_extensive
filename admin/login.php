<?php
require 'config.php';
session_start();

if (!empty($_POST)) {
    $email=$_POST['email'];
    $password=$_POST['password'];        

    $sql="SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':email',$email);
    // $stmt->bindValue(':password',$password);
    $stmt->execute();

    $user=$stmt->fetch(PDO::FETCH_ASSOC);
    if (empty($user)) {
        echo "<script>alert('wrong user ')</script>";
    }
    else{
        $passwordValid= password_verify($password,$user['password']);
        if ($passwordValid) {
            $_SESSION['user_id']=$user['id'];
            $_SESSION['logged_in']=time();
            


            header('location: index.php');
            exit();
        }
    
    else{
        echo "<script>alert('wrong password ')</script>";             
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
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="card">
        <div class="card-body">
            <h1>Log in</h1>
            <form action="login.php" method="post">
        
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" value="" required>
            </div>
            <div class="form-group">
                <label for="password">Passward</label>
                <input type="password" class="form-control" name="password" value="" required>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" name="" value="Login">
                <a calss="btn btn-primary" href="register.php">Register</a>
            </div>
            </form>
        </div>
    </div>
</body>
</html>