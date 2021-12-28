<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;
use Spatie\Fractal\Facades\Fractal;
use League\Fractal\Serializer\JsonApiSerializer;

class AboutController extends Controller
{
    public function index()
    {
        $user = User::get();
        return Fractal::collection($user, UserTransformer::class)
            ->respond(200);
    }
}
