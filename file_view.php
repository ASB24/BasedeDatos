<?php
    session_start();
    $name = $_SESSION['name'];
    $exists = true;

    $item = '';
    $dir = "./uploads/$name/";
    if(isset($_GET['item'])){
        $_SESSION['curr_item'] = $_GET['item'];
        $item = $_GET['item'];
    }
    $file_dir = $dir.$item;

    if( $_SERVER['REQUEST_METHOD'] === "POST" ){
        if(isset($_POST['delete'])){

            $item = $_SESSION['curr_item'];
            header("Location: ".$_SERVER['PHP_SELF']."?item=$item&b=true");
            
        }
    }

    if( $_SERVER['REQUEST_METHOD'] === "GET" ){

        if(isset($_GET['b']) && $_GET['b'] == true){
            if(file_exists($file_dir)){
                $files = array_diff( scandir($dir), array('.','..') );
                $item = explode(".", $item)[0];
    
                foreach( $files as $file ){
                    $compare = explode(".", $file)[0];
                    if($item === $compare){
                        unlink($dir.$file);
                        $exists = false;
                    }
                }
                header("Location: ./files.php?m=true");
                exit();
            }else{
                echo "File does not exist...";
            }
        }

    }

    function addOrUpdateUrlParam($name, $value)
    {
        $params = $_GET;
        unset($params[$name]);
        $params[$name] = $value;
        return basename($_SERVER['PHP_SELF']).'?'.http_build_query($params);
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
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
        <button type="submit" name="delete" class="btn btn-primary">Delete Text and Image</button>
    </form>
    <script src="./index.js"></script>
</body>
</html>