<?php

require_once "BaseModel.php";

class Upload extends BaseModel {
    private $username;
    private $image;
    function __construct($username, $image) {
        $this->username = $username;
        $this->image = $image;
    }

    function uploadImage() {
        /**
         * uploads an image to /uploads/current_username/image
         */
        $targetDir = dirname(__DIR__, 2) . "/uploads/$this->username/";
        $targetFile = $targetDir . basename($this->image["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Ensure file name doesn't have certain characters
        if (str_contains($this->image["name"], "/") || str_contains($this->image["name"], "\\")) {
            return [false, "Invalid file name"];
        }

        // Create user directory, if it doesn't exist
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, false);
        }

        // Checks if image is actually an image
        $check = getimagesize($this->image["tmp_name"]);

        if ($check === false) {
            return [false, "File is not an image"];
        }

        // Check if file already exists
        if (file_exists($targetFile)) {
            return [true, $this->username . "/" . $this->image["name"]];
        }

        // Check file size
        if ($this->image["size"] > 500000) {
            return [false, "File is too large"];
        }

        // Allow certain file formats: jpg, jpeg, png and gif
        if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "gif") {
            return [false, "Invalid file type"];
        }

        // Upload file
        if (move_uploaded_file($this->image["tmp_name"], $targetFile)) {
            echo "Successfully uploaded";
            return [true, $this->username . "/" . $this->image["name"]];
        } else {
            return [False, "Error uploading file"];
        }

    }
}

?>