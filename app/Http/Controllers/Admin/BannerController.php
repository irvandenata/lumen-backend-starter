<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Transformers\BannerTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use League\Fractal\Serializer\JsonApiSerializer;
use Spatie\Fractal\Facades\Fractal;

class BannerController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:api', ['except' => ['login']]);
    // }
    public function index()
    {

        if (Banner::first() == null) {
            $data = new banner();
            $data->title = "none";
            $data->description = "none";
            $data->save();
        }
        $data = Banner::get();
        return Fractal::collection($data, BannerTransformer::class)
            ->serializeWith(new JsonApiSerializer())
            ->respond(200);
    }

    public function update(Request $request)
    {
        $data = Banner::first();
        foreach ($request->request as $key => $value) {
            $data[$key] = $value;
        }
        $data->save();
        $data = Banner::get();
        return fractal($data, BannerTransformer::class)
            ->serializeWith(new JsonApiSerializer())
            ->respond(200);
    }
}
