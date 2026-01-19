<!DOCTYPE html>
<html>
<head>
    <title>File Upload Example</title>
</head>
<body>
    <h2>File Upload Example</h2>
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="myfile" required><br><br>
        <input type="submit" name="submit" value="Upload"><br><br>
    </form>
</body>
</html>

<?php

if(isset($_POST["submit"])){
    $filename = $_FILES["myfile"]["name"];
    $tempname = $_FILES["myfile"]["tmp_name"];
    $folder = "uploads/" . $filename;

    if (move_uploaded_file($tempname, $folder)) {
        echo "Your file $filename has been uploaded succesfully";
    }
    else{
        echo "File uploading failed";
    }
}
?>