<?php

namespace App\Http\Controllers;

use App\File;
use App\CanvassAttachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function download($id){
        $file = File::findOrFail($id);

         $exists = Storage::disk('ticket')->exists($file->path,$file->orignal_name);
         $original_name = $file->original_name;

        if($exists){
             ob_end_clean();
             return Storage::disk('ticket')->download($file->path,$original_name);
         }else {
             return 'File does not exits';
         }

    }

    public function getCanvassAttach($id){
        $file = CanvassAttachments::findorFail($id);
        
        $exists = Storage::disk('canvass_attach')->exists($file->path,$file->orignal_name);
        $original_name = $file->original_name;
         

       if($exists){
            ob_end_clean();
            return Storage::disk('canvass_attach')->download($file->path,$original_name);
        }else {
            return 'File does not exits';
        }
        // canvass_attach
    }

}
