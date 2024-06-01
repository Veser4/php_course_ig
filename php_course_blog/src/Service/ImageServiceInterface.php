<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface ImageServiceInterface
{
    public function moveImageToUploads(UploadedFile $file): ?string;
    public function getUploadUrlPath(string $fileName): string;
    public function deleteImageFromUploads(string $fileName);
}