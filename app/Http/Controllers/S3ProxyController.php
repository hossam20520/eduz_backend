<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
class S3ProxyController extends Controller
{



    public function show($filename)
    {
        $s3FilePath = 'images/educations/' . $filename;
    
        if (Storage::disk('s3')->exists($s3FilePath)) {
            $file = Storage::disk('s3')->get($s3FilePath);
            $response = new Response($file, 200);
            $response->header('Content-Type', Storage::disk('s3')->mimeType($s3FilePath));
            return $response;
        }
    
        abort(404);
    }



}
