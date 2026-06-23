<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    function removeImage($existed_file)
    {
        $fullPath = public_path($existed_file);
        if (file_exists($fullPath)) {
            unlink($fullPath);
            return true;
        }
        return false;
    }

    function storeImage($file, $path, $existed_file = "")
    {
        if (!empty($existed_file)) {
            $this->removeImage($existed_file);
        }

        $basePath = public_path($path);

        // Ensure folder exists
        if (!is_dir($basePath)) {
            mkdir($basePath, 0755, true);
        }

        // Create unique filename
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        // Move file
        $file->move($basePath, $fileName);

        // Return relative path (used in DB)
        return $path . $fileName;
    }
}
