<?php
    session_start();
    $name = $_SESSION['name'];
    $exists = true;

    $item = '';
    $dir = "./uploads/$name/";
    if(isset($_GET['item'])){
        $item = $_GET['item'];
    }
    $file_dir = $dir.$item;

    if(isset($_GET['b']) && $_GET['b'] == true){
        if(file_exists($file_dir)){
            $files = array_diff( scandir($dir), array('.','..') );
            $item = explode(".", $item)[0];


            foreach( $files as $file ){
                $compare = explode(".", $file)[0];
                if($item === $compare){
                    unlink($dir.$file);
                }
            }
            $exists = false;
            header("Location: ./files.php?m=true");
            exit();
        }else{
            echo "File does not exist...";
        }
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

    <title>File View</title>
</head>
<body>
    <h1>Text Inside:</h1>
    <p>
        <?php
            if ($exists) {
                echo file_get_contents($file_dir);
            }
        ?>
    </p>
</body>
</html>