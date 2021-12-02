<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Transformers\CategoryTransformer;
use Illuminate\Http\Request;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Serializer\JsonApiSerializer;
use Spatie\Fractal\Facades\Fractal;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Str;

class CategoryController extends Controller
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
    $query = Category::where("name", $request->name);

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
    $category = new Category();
    $paginator = $category->paginate($request->query("perPage"));
    $categories = QueryBuilder::for($category->query())
      ->allowedFilters(['name', 'perPage'])->get();

    return Fractal::collection($categories, CategoryTransformer::class)
      ->serializeWith(new JsonApiSerializer())
      ->paginateWith(new IlluminatePaginatorAdapter($paginator))
      ->respond(200);
  }
  public function create(Request $request)
  {
    $this->validateRequest($request);
    $category = new Category();
    $category->name = $request->name;
    $category->slug = $request->slug;
    $category->save();
    return fractal($category, CategoryTransformer::class)
      ->serializeWith(new JsonApiSerializer())
      ->respond(201);
  }

  public function show($slug)
  {
    $category = Category::where("slug", $slug)->first();
    if ($category == null)
      return response()->json(["message" => "not found", "status" => 404]);
    return fractal($category, CategoryTransformer::class)
      ->serializeWith(new JsonApiSerializer())
      ->respond(200);
  }

  public function update(Request $request, $slug)
  {
    $this->validateRequest($request);
    $category = Category::where("slug", "=", $slug)->first();
    if ($category == null)
      return response()->json(["message" => "not found", "status" => 404]);
    $category->name = $request->name;
    $category->slug = $request->slug;
    $category->save();
    return fractal($category, CategoryTransformer::class)
      ->serializeWith(new JsonApiSerializer())
      ->respond(200);
  }

  public function delete($slug)
  {
    $category = Category::where("slug", "=", $slug)->first();
    if ($category == null)
      return response()->json(["message" => "not found", "status" => 404]);
    $category->delete();
    return response()->json(["message" => "Success Deleted", "status" => 200]);
  }
}
