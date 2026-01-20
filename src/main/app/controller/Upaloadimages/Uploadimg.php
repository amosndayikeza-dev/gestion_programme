<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__."../../../service/";

class Uploadimg{
    private UploadimgService $uploadimg_service;

    public function __construct()
    {
        $uploadimg_service = new UploadimgService();
    }

    public function uploadImage()
    {
        $this->uploadimg_service->uploaderImage($_FILES['image']);
        header("Location: /upload-success");
        exit;
    }
}

















?>