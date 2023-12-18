<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class FileController extends Controller
{
    public function browseFiles()
    {
        // Get all files in the storage directory
        $files = $this->getFiles(storage_path('app'));

        // You can now do something with the $files array, like returning it as JSON
        return response()->json($files);
    }

    public function openImage($filename)
    {
        // Define the path to the storage directory
        $storagePath = storage_path('app/public/uploads');

        // Check if the file exists in the storage directory
        $filePath = "{$storagePath}/{$filename}";
        if (File::exists($filePath)) {
            // Get the MIME type of the file
            $mime = File::mimeType($filePath);

            // Create a response with the file contents and appropriate headers
            $response = Response::make(File::get($filePath), 200);
            $response->header('Content-Type', $mime);

            return $response;
        }

        // Return a 404 response if the file is not found
        return response()->json(['error' => 'Image not found.'], 404);
    }

    private function getFiles($directory)
    {
        $files = [];

        // Get all files and directories in the specified directory
        $items = File::allFiles($directory);

        foreach ($items as $item) {
            $files[] = [
                'path' => $item->getPathname(),
                'name' => $item->getFilename(),
            ];
        }

        return $files;
    }
}
