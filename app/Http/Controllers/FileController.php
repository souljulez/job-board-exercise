<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class FileController extends Controller
{
    public function download($encryptedPath)
    {
        try{
            $filepath = Crypt::decryptString($encryptedPath);
        } catch (DecryptException $e) {
            abort(403, 'Invalid or tampered download link.');
        }

        if(Storage::disk('private')->exists($filepath)){
            return Storage::disk('private')->download($filepath);
        }
        abort(404,'File not found!!');
    }
}
