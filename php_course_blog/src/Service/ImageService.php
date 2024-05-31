<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageService implements ImageServiceInterface
{
    const UPLOADS_PATH = DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'assets';
    const ALLOWED_MIME_TYPES_MAP = [
        'image/jpeg' => '.jpg',
        'image/png' => '.png',
        'image/webp' => '.webp',
        'image/gif' => '.gif',
    ];
    public function moveImageToUploads(UploadedFile $file): ?string
    {
        if ($file->getError())
        {
            return null;
        }

        $type = $file->getMimeType();
        $name = $file->getClientOriginalName();
        $imageExt = self::ALLOWED_MIME_TYPES_MAP[$type] ?? null;
        if (!$imageExt)
        {
            throw new \InvalidArgumentException("File '$name' has non-image type '$type'");
        }

        $destFileName = uniqid('image', true) . $imageExt;
        return $this->moveFileToUploads($file, $destFileName);
    }

    public function getUploadUrlPath(string $fileName): string
    {
        return "/assets/$fileName";
    }

    private function getUploadPath(string $fileName): string
    {
        $uploadsPath = dirname(__DIR__, 2) . self::UPLOADS_PATH;

        if (!$uploadsPath || !is_dir($uploadsPath))
        {
            throw new \RuntimeException('Invalid uploads path: ' . self::UPLOADS_PATH);
        }

        return $uploadsPath . DIRECTORY_SEPARATOR . $fileName;
    }

    private function moveFileToUploads(UploadedFile $file, string $destFileName): string
    {
        $fileName = $file->getClientOriginalName();
        $destPath = $this->getUploadPath($destFileName);
        $srcPath = $file->getRealPath();

        if (!@move_uploaded_file($srcPath, $destPath))
        {
            throw new \RuntimeException("Failed to upload file $fileName");
        }

        return $destFileName;
    }
}