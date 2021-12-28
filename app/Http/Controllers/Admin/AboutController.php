<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialMedia;
use App\Models\User;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use League\Fractal\Serializer\JsonApiSerializer;
use Spatie\Fractal\Facades\Fractal;

class AboutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }
    public function index()
    {
        $user = User::get();
        return Fractal::collection($user, UserTransformer::class)
            ->serializeWith(new JsonApiSerializer())
            ->respond(200);
    }
    public function update(Request $request)
    {
        $sosmed = array();
        $password = "";
        array_push($sosmed, $request->sosmedlink);
        array_push($sosmed, $request->sosmedname);
        if ($request->password != "") {
            $password = Hash::make($request->password);
            $request->request->remove('password');
        } else $request->request->remove('password');

        $request->request->remove('sosmedlink');
        $request->request->remove('sosmedname');
        $user = User::where("id", "=", 1)->first();

        foreach ($request->request as $key => $value) {
            $user[$key] = $value;
        }
        if ($password != '') $user['password'] = $password;
        $user->save();
        $user->sosmeds()->delete();
        foreach ($sosmed[0] as $i => $value) {
            SocialMedia::create([
                'id' => $user->id . "-" . $i,
                'user_id' => 1,
                'link' => $sosmed[0][$i],
                'name' => $sosmed[1][$i]
            ]);
        }
        return fractal($user, UserTransformer::class)
            ->serializeWith(new JsonApiSerializer())
            ->respond(200);
    }
}
