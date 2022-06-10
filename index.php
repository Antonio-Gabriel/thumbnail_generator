<?php

require_once "./file.php";
require_once "./thumbnail.php";

/**
 * Upload file and generate a thumbnail
 *
 * @author António Gabriel <antoniocamposgabriel@gmail.com>
 */

if (isset($_FILES)) {
    $file = new File();
    $uploadedFileName = $file->upload();

    echo $uploadedFileName;
}

?>

<form action="./index.php" method="post" enctype="multipart/form-data">
    <input type="file" name="photo" accept=".png, .jpeg, .jpg" />
    <button type="submit">Upload</button>
</form>