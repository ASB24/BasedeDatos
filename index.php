<?php
    $name = '';
    $pass = '';
    $file = '';

    $userExists = true;
    $correctPassword = true;

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $name = $_POST['name'];
        $pass = $_POST['password'];
        $file = './users/'.$name.'.txt';

        if(isset($_POST['login']))
        {
            if (file_exists($file)) {
                $reader = fopen($file, "r");
                if( ($line = fgets($reader)) !== false && $line === $pass ){
                    fclose($reader);
                    signIn($name);
                }else{
                    $correctPassword = false;
                }
                fclose($reader);
            }else{
                $userExists = false;
            }
        }
        else if(isset($_POST['create']))
        {
            $reader = fopen($file, "w");
            fwrite($reader, $pass);
            fclose($reader);
            signIn($name);
        }

    }

    function signIn($name){
        session_start();
        $_SESSION['name'] = $name;
        header("Location: ./files.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <link rel="stylesheet" href="./style.css">
    <title>Enter Site</title>
</head>
<body>
    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="mb-3">
          <label for="name" class="form-label">Username</label>
          <input type="text" name="name" id="name" class="form-control" placeholder="" aria-describedby="nameHelp" required aria-required="true">
          <small id="nameHelp" class="text-muted">Name for username</small>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" name="password" id="password" placeholder="" aria-required="true" required>
        </div>
        <input name="create" id="create" class="btn btn-primary" type="submit" value="Sign Up">
        <input name="login" id="login" class="btn btn-primary" type="submit" value="Sign In">
    </form>
    <?php
        if(!$userExists){
            echo '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <strong>Error 1</strong> User does not exist!
                </div>
            ';
        }else if(!$correctPassword){
            echo '
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <strong>Error 2</strong> Credentials for user are not correct...
                </div>
            ';
        }
    ?>
    
    <script src="./index.js"></script>
</body>
</html>