<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Transformers\TagTransformer;
use Illuminate\Http\Request;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Serializer\JsonApiSerializer;
use Spatie\Fractal\Facades\Fractal;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }
    function validateRequest($request)
    {
        $rules =
            [
                'name' => 'required',
            ];
        $this->validate($request, $rules);
        $query = Tag::where("name", $request->name);

        $validate = $query->get();
        if ($validate->count() > 0) {
            $add = $query->latest()->first()->id;
            $slug = Str::slug($request->name, '-') . "-" . ($validate->count() + $add);
        } else
            $slug =  Str::slug($request->name, '-');

        $request->request->add([
            'slug' => $slug,
        ]);
    }

    public function index(Request $request)
    {
        $data = new Tag();
        $paginator = $data->paginate($request->query("perPage"));
        $categories = QueryBuilder::for($data->query())
            ->allowedFilters(['name', 'perPage'])->get();

        return Fractal::collection($categories, TagTransformer::class)
            ->serializeWith(new JsonApiSerializer())
            ->paginateWith(new IlluminatePaginatorAdapter($paginator))
            ->respond(200);
    }
    public function create(Request $request)
    {
        $this->validateRequest($request);
        $data = new Tag();
        $data->name = $request->name;
        $data->slug = $request->slug;
        $data->save();
        return fractal($data, TagTransformer::class)
            ->serializeWith(new JsonApiSerializer())
            ->respond(201);
    }
    public function show($slug)
    {
        $data = Tag::where("slug", $slug)->first();
        if ($data == null)
            return response()->json(["message" => "not found", "status" => 404]);
        return fractal($data, TagTransformer::class)
            ->serializeWith(new JsonApiSerializer())
            ->respond(200);
    }

    public function update(Request $request, $slug)
    {
        $this->validateRequest($request);
        $data = Tag::where("slug", "=", $slug)->first();
        if ($data == null)
            return response()->json(["message" => "not found", "status" => 404]);
        $data->name = $request->name;
        $data->slug = $request->slug;
        $data->save();
        return fractal($data, TagTransformer::class)
            ->serializeWith(new JsonApiSerializer())
            ->respond(200);
    }

    public function delete($slug)
    {
        $data = Tag::where("slug", "=", $slug)->first();
        if ($data == null)
            return response()->json(["message" => "not found", "status" => 404]);
        $data->delete();
        return response()->json(["message" => "Success Deleted", "status" => 200]);
    }
}
