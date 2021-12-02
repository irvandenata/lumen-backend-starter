<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Transformers\ContentTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Serializer\JsonApiSerializer;
use Spatie\Fractal\Facades\Fractal;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Str;

class ContentController extends Controller
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
                "title" => "required|min:1",
                'image' => 'image:jpeg,png,jpg,gif,svg|max:2048',
            ];
        $this->validate($request, $rules);
        $query = Content::where("title", $request->title);
        $validate = $query->get();
        if ($validate->count() > 0) {
            $add = $query->latest()->first()->id;
            $slug = Str::slug($request->title, '-') . "-" . ($validate->count() + $add);
        } else
            $slug =  Str::slug($request->title, '-');

        $request->request->add([
            'slug' => $slug,
        ]);
    }

    /**
     * Function for show all content
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = new Content();
        $paginator = $data->paginate($request->query("perPage"));
        $datas = QueryBuilder::for($data->query())
            ->allowedFilters(['name'])
            ->appends(request()->query());
        return Fractal::collection($datas, ContentTransformer::class)
            ->serializeWith(new JsonApiSerializer())
            ->paginateWith(new IlluminatePaginatorAdapter($paginator))
            ->respond(200);
    }


    /**
     * Function for create single content
     *  @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $this->validateRequest($request);
        $data = new Content();
        DB::transaction(function () use ($request, $data) {
            $data->title = $request->title;
            $data->body = $request->body;
            $data->view_count = 0;
            $data->like = 0;
            $data->status = $request->status;
            $data->category_id = $request->category_id;
            $data->slug = $request->slug;
            $data->save();
            $data->tags()->attach($request->tag);
        });
        return fractal($data, ContentTransformer::class)
            ->serializeWith(new JsonApiSerializer())
            ->respond(201);
    }

    /**
     * Function for show single content
     *  @param slug from content  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $data = Content::where("slug", $slug)->first();
        if ($data == null)
            return response()->json(["message" => "not found", "status" => 404]);
        return fractal($data, ContentTransformer::class)
            ->serializeWith(new JsonApiSerializer())
            ->respond(200);
    }

    /**
     * Function for update content, identify from slug
     *  @param slug from content  $slug
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $this->validateRequest($request);
        $data = Content::where("slug", "=", $slug)->first();
        if ($data == null)
            return response()->json(["message" => "not found", "status" => 404]);
        $data->name = $request->name;
        $data->slug = $request->slug;
        $data->save();
        return fractal($data, ContentTransformer::class)
            ->serializeWith(new JsonApiSerializer())
            ->respond(200);
    }

    /**
     * Function for delete content
     *  @param slug from content  $slug
     * @return \Illuminate\Http\Response
     */
    public function delete($slug)
    {
        $data = Content::where("slug", "=", $slug)->first();
        if ($data == null)
            return response()->json(["message" => "not found", "status" => 404]);
        $data->delete();
        return response()->json(["message" => "Success Deleted", "status" => 200]);
    }
}
