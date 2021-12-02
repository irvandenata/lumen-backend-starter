<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Content;
use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class FileController extends Controller
{
    /**
     * Function for validate input data
     *  @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    function validateRequest($request)
    {
        $rules =
            [
                'image' => 'required|image:jpeg,png,jpg,gif,svg|max:2048',
            ];
        $this->validate($request, $rules);
    }


    public function uploadImgContent(Request $request)
    {
        $data = Content::where('id', $request->id)->first();
        $path = null;
        if ($request->file('file')) {
            $name_picture = Str::random(6) . '.png';
            $picture = Image::make($request['file'])->resize(null, 1000, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->encode('png', 100);
            $namePath = "Contents";
            $path = $namePath . "/" . $name_picture;
            Storage::put("public/" . $path, $picture);
        }
        $data->files()->create(['link' => $path, 'type' => 'image']);
        return response()->json(200);
    }
    public function deleteImgContent($id)
    {
        if ($id != "") {
            $img = File::where("id", $id)->first();
            if ($img->link != null) {
                if (Storage::exists("public/" . $img->link)) {
                    Storage::delete("public/" . $img->link);
                    $img->delete();
                }
            }
            return response()->json('success', 200);
        }
        return response()->json('not found', 404);
    }
}
