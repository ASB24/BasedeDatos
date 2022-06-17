<?php
    $name = '';
    $pass = '';
    $file = '';

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
                    echo "The password for the given user is not correct.";
                }
                fclose($reader);
            }else{
                echo "The user does not exist...";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <link rel="stylesheet" href="./style.css">
    <title>Ingresar a la pagina</title>
</head>
<body>
    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="mb-3">
          <label for="name" class="form-label">Nombre</label>
          <input type="text" name="name" id="name" class="form-control" placeholder="" aria-describedby="nameHelp" required aria-required="true">
          <small id="nameHelp" class="text-muted">Nombre de usuario</small>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" name="password" id="password" placeholder="" aria-required="true" required>
        </div>
        <input name="create" id="create" class="btn btn-primary" type="submit" value="Crear">
        <input name="login" id="login" class="btn btn-primary" type="submit" value="Ingresar">
    </form>
</body>
</html>