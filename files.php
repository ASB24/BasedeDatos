<?php
    session_start();
    $name = $_SESSION['name'];
    date_default_timezone_set('America/Santo_Domingo');

    $dir_name = "./uploads/$name/";
    if(!is_dir($dir_name)){
        mkdir($dir_name, 0777);
    }

    $uploadError = false;
    $notImageError = false;
    $fileUploaded = false;

    if( $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])){
        $text = $_POST['comment'];
        $file_name = $dir_name.$name.date("_Ymd_Hi");
        if($image_info = getimagesize($_FILES["image"]["tmp_name"])){
            //Write file
            $reader = fopen($file_name.".txt", "w");
            fwrite($reader, $text);
            fclose($reader);

            //Upload image
            $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            if( move_uploaded_file( $_FILES['image']['tmp_name'], $file_name.".".$extension ) ){
                $fileUploaded = true;
            }else{
                $uploadError = true;
            }

        }else{
            $notImageError = true;
        }
    }

    $deletedConfirm = false;
    if(isset($_GET['m']) && $_GET['m'] == true){
        $deletedConfirm = true;
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" integrity="sha512-6PM0qYu5KExuNcKt5bURAoT6KCThUmHRewN3zUFNaoI6Di7XJPTMoT6K0nsagZKk2OB4L7E3q1uQKHNHd4stIQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <link rel="stylesheet" href="./style.css">

    <title>Upload Files</title>
</head>
<body>
    <?php
        echo "<h1>Welcome, $name</h1>";
        if($deletedConfirm){
            echo '
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <strong>Done!</strong> Files successfully deleted.
                </div>
            ';
        }
    ?>

    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="uploadImage-tab" data-bs-toggle="tab" data-bs-target="#uploadImage" type="button" role="tab" aria-controls="uploadImage" aria-selected="true">Upload Files</button>
            <button class="nav-link" id="uploads-tab" data-bs-toggle="tab" data-bs-target="#uploads" type="button" role="tab" aria-controls="uploads" aria-selected="false">Uploads</button>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="uploadImage" role="tabpanel" aria-labelledby="uploadImage-tab">
            <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="userComment">Comment</label>
                    <textarea class="form-control" id="userComment" rows="5" name="comment" required aria-required="true"></textarea>
                </div>
                <div class="mb-3">
                    <label for="imagen" class="form-label">Image</label>
                    <input class="form-control" type="file" name="image" id="image" accept="image/*" required aria-required="true">
                </div>
                <button type="submit" name="upload" class="btn btn-primary">Upload</button>
            </form>
        </div>
        <div class="tab-pane fade" id="uploads" role="tabpanel" aria-labelledby="uploads-tab">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col"><i class="fa-regular fa-file-image"></i> Image</th>
                        <th scope="col"><i class="fa-regular fa-comment-dots"></i> Comment</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $files = array_diff( scandir("./uploads/$name/"), array('.','..') );
                    foreach( $files as $file ){
                        $ext = explode(".", $file)[1];
                        if($ext !== "txt"){
                            echo "
                            <tr>
                                <th scope=\"row\">$file</th>
                            ";
                        }else{
                            echo "
                                <td>
                                    <a class=\"nav-link\" aria-disabled=\"false\" href=\"./file_view.php?item=$file\">$file</a>
                                </td>
                            </tr>
                            ";
                        }
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php
        if($uploadError){
            echo '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <strong>Error 3</strong> File could not be uploaded...
                </div>
            ';
        }else if($notImageError){
            echo '
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <strong>Error 4</strong> The file you are trying to upload is not an image!
                </div>
            ';
        }else if($fileUploaded){
            echo '
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <strong>Done!</strong> Files uploaded successfully!
                </div>
            ';
        }
    ?>
    
    <script src="./index.js"></script>
</body>
</html>