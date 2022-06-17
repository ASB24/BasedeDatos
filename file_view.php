<?php
    session_start();
    $name = $_SESSION['name'];

    $item = '';
    $dir = "./uploads/$name/";
    if(isset($_GET['item'])){
        $item = $_GET['item'];
    }
    $file_dir = $dir.$item;
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

    <title>File View</title>
</head>
<body>
    <h1>Text Inside:</h1>
    <p>
        <?php
            echo file_get_contents($file_dir);
        ?>
    </p>
</body>
</html>