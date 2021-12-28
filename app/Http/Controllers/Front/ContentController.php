<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Content;
use App\Transformers\ContentFrontTransformer;
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
    // function validateRequest($request)
    // {
    //     $rules =
    //         [
    //             "title" => "required|min:1",
    //             'image' => 'image:jpeg,png,jpg,gif,svg|max:2048',
    //         ];
    //     $this->validate($request, $rules);
    //     $query = Content::where("title", $request->title);
    //     $validate = $query->get();
    //     if ($validate->count() > 0) {
    //         $add = $query->latest()->first()->id;
    //         $slug = Str::slug($request->title, '-') . "-" . ($validate->count() + $add);
    //     } else
    //         $slug =  Str::slug($request->title, '-');

    //     $request->request->add([
    //         'slug' => $slug,
    //     ]);
    // }

    /**
     * Function for show all content
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $data = new Content();

        $paginator = $data->paginate($request->query("perPage"));
        $contents = QueryBuilder::for($data->query(""))
            ->allowedFilters('category_id')->get();

        return Fractal::collection($contents, ContentTransformer::class)
            ->serializeWith(new JsonApiSerializer())
            ->paginateWith(new IlluminatePaginatorAdapter($paginator))
            ->respond(200);
    }


    public function showByCategory(Request $request)
    {
        $data = new Category();
        $paginator = $data->paginate($request->query("perPage"));
        $contents = QueryBuilder::for($data->query(""))
            ->allowedFilters('slug')->first();

        return Fractal::collection($contents->contents, ContentFrontTransformer::class)
            ->serializeWith(new JsonApiSerializer())
            ->paginateWith(new IlluminatePaginatorAdapter($paginator))
            ->respond(200);
    }



    /**
     * Function for create single content
     *  @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        // $this->validateRequest($request);
        $data = new Content();
        DB::transaction(function () use ($data) {
            $data->title = "Notitle";
            // $data->body = $request->body;
            // $data->view_count = 0;

            // $data->status = $request->status;
            // $data->category_id = $request->category_id;
            $data->save();

            // $data->tags()->attach($request->tag);
        });
        $data->slug = $data->id . "-" . $data->title;
        $data->save();

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
        $data->view_count++;
        $data->save();
        return fractal($data, ContentTransformer::class)
            ->serializeWith(new JsonApiSerializer())
            ->respond(200);
    }
    public function search($slug)
    {
        $data = Content::where("slug", $slug)->get();

        if ($data == null)
            return response()->json(["message" => "not found", "status" => 404]);
        return fractal($data, ContentTransformer::class)
            ->serializeWith(new JsonApiSerializer())
            ->respond(200);
    }



    public function view($slug)
    {
        $data = Content::where("slug", $slug)->first();
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
