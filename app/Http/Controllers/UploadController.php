<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\CoreService\CoreResponse;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function upload() {
        // $req = request()->all();
        // $path = request()->file('file')->store('tmp');
        $file = request()->file('file');
        $originalname = $file->getClientOriginalName();

        if(Storage::exists("tmp/".$originalname)) {
            $id = 1;
            $filename = pathinfo(storage_path("tmp/".$originalname), PATHINFO_FILENAME);
            while(true) {
                $originalname = $filename."($id).".$file->getClientOriginalExtension();
                if(!Storage::exists("tmp/".$originalname))
                    break;
                $id++;
            }
        }
        $path = $file->storeAs('tmp', $originalname);
        $result = [
            "path" => $path,
            "originalname" =>$originalname
        ];
        return CoreResponse::ok($result);
    }
}