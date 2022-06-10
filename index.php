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

<br><br>

<h1>Preview images</h1>

<div style="display: flex; gap: 10px;">
    <article>
        <p>A large image</p>
        <img src="./images/1/thumbnail_large.jpeg" alt="">
    </article>

    <article>
        <p>A small image</p>
        <img src="./images/1/thumbnail_small.jpeg" alt="">
    </article>
</div>