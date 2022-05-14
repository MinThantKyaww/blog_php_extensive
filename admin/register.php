<?php

require 'config.php';

if (!empty($_POST)) {
    $username=$_POST['username'];
    $email=$_POST['email'];
    $password=$_POST['password'];

    if ($username=='' || $email=='' || $password=='') {
        echo "<script>alert('fill the form data')</script>";
    }
    else {
        $sql="SELECT COUNT(email) AS num FROM users WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':email',$email);
        $stmt->execute();

        $row=$stmt->fetch(PDO::FETCH_ASSOC);

        if ($row['num']>0) {
            echo "<script>alert('This user already exict,try again!')</script>";
        }
        else {
            $passwordHash = password_hash($password,PASSWORD_BCRYPT);

            $sql = "INSERT INTO users(name,email,password) VALUES(:name,:email,:password)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':name',$username);
            $stmt->bindValue(':email',$email);
            $stmt->bindValue(':password',$passwordHash);

            $result = $stmt->execute();
            
            if ($result) {
                echo "<script>alert('Thanks for ur registeration');window.location.href='index.php';</script>";
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
    <title>Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="card">
        <div class="card-body">
            <h1>Register</h1>
            <form action="register.php" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" value="">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" value="">
            </div>
            <div class="form-group">
                <label for="password">Passward</label>
                <input type="password" class="form-control" name="password" value="">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" name="" value="Register">
                <a href="login.php">Login</a>
            </div>
            </form>
        </div>
    </div>
</body>
</html>