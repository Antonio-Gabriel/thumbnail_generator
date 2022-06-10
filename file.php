<?php

require_once "./thumbnail.php";

/**
 * Upload file (image) after convert to thumbnail
 *
 * @author António Gabriel <antoniocamposgabriel@gmail.com>
 */

class File
{
    public function __construct(
        private $fileType = null,
        private ?string $targetDir = null,
        private ?string $fileName = null,
        private ?string $targetFilePath = null,
        private ?Thumbnail $thumbnail = null
    ) {
        $this->targetDir = "images/";
        $this->fileName = basename($_FILES["photo"]["name"]);

        $this->thumbnail = new Thumbnail();
    }

    public function upload(string $defaulFile = "empty.png")
    {
        if (
            !empty($_FILES["photo"]["name"])
        ) {

            $createdDirName = $this->createDynamicPath();
            $dynamicDir = "{$this->targetDir}{$createdDirName}/";

            // Optional, i used because in my operational system is required permitted the folder for the upload
            shell_exec("chmod -R 777 ./{$dynamicDir}");

            $this->targetFilePath = $dynamicDir . $this->fileName;
            $this->fileType = pathinfo($this->targetFilePath, PATHINFO_EXTENSION);

            $currentDir = $this->uploadAndMakeThumbnail($dynamicDir);

            return $currentDir;
        } else {
            return $defaulFile;
        }
    }

    private function uploadAndMakeThumbnail(string $dynamicDir)
    {

        $temp = explode(".", $this->fileName);
        $newfilename = "thumbnail_large" . '.' . end($temp);
        $thumbName = str_replace("_large", "_small", $newfilename);

        $this->targetFilePath = $dynamicDir . $newfilename;

        $uploaded = move_uploaded_file(
            $_FILES["photo"]["tmp_name"],
            $this->targetFilePath
        );

        if ($uploaded) {
            $thumbLocal = $dynamicDir . $thumbName;

            $isUpload = $this->thumbnail->createThumbnail(
                $this->targetFilePath,
                $thumbLocal,
                260
            );

            if ($isUpload) {
                return $dynamicDir;
            }
        }
    }

    private function createDynamicPath()
    {
        $folders = [];
        foreach (scandir($this->targetDir) as $file) {
            if (is_dir($file)) {
                continue;
            }

            $folders[] = (int)$file;
        }

        if (empty($folders)) {
            mkdir($this->targetDir . "1", 777, true);

            return "1";
        }

        sort($folders);

        $newFolder = strval($folders[count($folders) - 1] + 1);

        mkdir($this->targetDir . $newFolder, 777, true);

        return $newFolder;
    }
}
