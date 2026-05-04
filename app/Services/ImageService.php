<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver; // Atau gunakan Driver(new \Intervention\Image\Drivers\Imagick\Driver()) jika pakai Imagick

class ImageService
{
    public function compress($file)
    {
        // 1. Inisialisasi manager dengan driver pilihan (GD atau Imagick)
        $manager = new ImageManager(new Driver());

        // 2. Baca file gambar
        $image = $manager->read($file);

        // 3. Resize (Di V3, metodenya sedikit berbeda)
        $image->scale(width: 1200); // Otomatis menjaga aspect ratio

        // 4. Encode/Compress
        return $image->toJpeg(75); // Mengembalikan format JPG dengan kualitas 75
    }
}