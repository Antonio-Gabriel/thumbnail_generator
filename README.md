# Image thumbnail generator

The application dynamically creates a folder, assigns a read and write permission to it, then creates a thumbnail of the image in the same directory.

Example of creating dynamic directories

```php
$folders = [];
foreach (scandir($this->targetDir) as $file) {
  if (is_dir($file)) {
    continue;
  }

  $folders[] = (int) $file;
}

if (empty($folders)) {
  mkdir($this->targetDir . '1', 777, true);

  return '1';
}

sort($folders);

$newFolder = strval($folders[count($folders) - 1] + 1);

mkdir($this->targetDir . $newFolder, 777, true);
```

Then, in the created directory, the image is uploaded and the thumbnail of the image is generated, as follows.

```php
$uploaded = move_uploaded_file(
  $_FILES['photo']['tmp_name'],
  $this->targetFilePath
);

if ($uploaded) {
  $thumbLocal = $dynamicDir . $thumbName;

  $this->thumbnail = new Thumbnail();
  $isUpload = $this->thumbnail->createThumbnail(
    $this->targetFilePath,
    $thumbLocal,
    260
  );

  if ($isUpload) {
    return $dynamicDir;
  }
}
```

Result:

<img src="./example.png" alt="thumbnail generator example">


## Credits

- [António Gabriel](https://github.com/Antonio-Gabriel) and contributors.

## License

The ThumbnailGenerator is licensed under the MIT license.
