<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use App\Models\Content;
use App\Models\File;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Mockery\Undefined;

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

    public function getImgContent($slug)
    {
        $data = Content::where('slug', $slug)->first();

        return response()->json(["data" =>  $data->files, "url" => url('') . "/storage", "status" => 202]);
    }
    public function uploadImgContent(Request $request)
    {
        $data = Content::where('slug', $request->slug)->first();
        $path = null;
        try {

            if ($request->file('file')) {

                $name_picture = Str::random(6) . '.png';
                $picture = Image::make($request['file'])->encode('png');
                $namePath = "Contents";
                $path = $namePath . "/" . $name_picture;
                Storage::put("public/" . $path, $picture);
            }
            $data->files()->create(['link' => $path, 'type' => 'image']);
            return response()->json([$data->files->where('link', $path)->first(),  "Success"]);
        } catch (\Throwable $th) {
            return response()->json([500, " Failed"]);
        }
    }
    public function deleteImgContent($id)
    {
        try {
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
        } catch (\Throwable $th) {
            return response()->json('not found', 404);
        }
    }

    public function uploadProfile(Request $request)
    {

        $data = User::where('id', 1)->first();
        $id = 0;
        if ($data->files->first() != null) $id = $data->files->first()->id;
        $path = null;
        try {

            if ($id != 0) {
                $img = File::where("id", $id)->first();
                if ($img != null) {
                    if (Storage::exists("public/" . $img->link)) {
                        Storage::delete("public/" . $img->link);
                        $img->delete();
                    }
                }
            }




            if ($request->file('file')) {
                $name_picture = Str::random(6) . '.png';
                $picture = Image::make($request['file'])->encode('png');
                $namePath = "Profile";
                $path = $namePath . "/" . $name_picture;
                Storage::put("public/" . $path, $picture);
            }

            $data->files()->create(['link' => $path, 'type' => 'image']);

            return response()->json([$data->files->where('link', $path)->first(),  "Success"]);
        } catch (\Throwable $th) {
            return response()->json([500, " Failed", $th]);
        }
    }
    public function uploadBanner(Request $request)
    {

        $data = Banner::first();
        $id = 0;

        if (count($data->files) != 0) $id = $data->files->first()->id;
        $path = null;

        try {
            if ($id != 0) {
                $img = File::where("id", $id)->first();
                if ($img != null) {
                    if (Storage::exists("public/" . $img->link)) {
                        Storage::delete("public/" . $img->link);
                        $img->delete();
                    }
                }
            }

            if ($request->file('file')) {

                $name_picture = Str::random(6) . '.png';
                $picture = Image::make($request['file'])->encode('png');
                $namePath = "Banner";

                $path = $namePath . "/" . $name_picture;
                Storage::put("public/" . $path, $picture);
            }

            $data->files()->create(['link' => $path, 'type' => 'image']);

            return response()->json([$data->files->first()->link,  "Success"]);
        } catch (\Throwable $th) {
            return response()->json([500, " Failed", $th]);
        }
    }
}
