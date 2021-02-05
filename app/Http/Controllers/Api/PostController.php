<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\PostResource;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $posts = Post::with(['category', 'tags'])->latest()->simplePaginate(12);

    return PostResource::collection($posts);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $rules = [
      'user_id' => ['required'],
      'category_id' => ['required'],
      'title' => ['required', 'unique:posts', 'string'],
      'slug' => ['required', 'unique:posts', 'string'],
      'body' => ['required', 'string'],
      'image' => ['nullable', 'image', 'max:10000'],
    ];
    $validator = \Validator::make($request->all(), $rules);

    // handle img
    if ($request->file('image')) {
      $file_name = Str::of($request->file('image')->getClientOriginalName())->beforeLast('.')->append(date(now()))->slug()->append('.')->append($request->file('image')->getClientOriginalExtension());
      Storage::disk('public')->putFileAs('images', $request->file('image'), $file_name);
      $img_url = url('/' . 'storage/' . 'images/' . $file_name);
    }

    try {
      Post::create([
        'user_id' => $request->user_id,
        'category_id' => $request->category_id,
        'title' => $request->title,
        'slug' => $request->slug,
        'body' => $request->body,
        'image' => $img_url,
        // 'status' => $request->status
      ]);

      return response()->json(['message' => 'data saved successfully'], 200);
    } catch (\Throwable $th) {
      return response()->json($validator->errors(), 400);
      // return response()->json('test', 400);
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    return response()->json(Post::findOrFail($id), 200);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $post = Post::findOrFail($id);

    $rules = [
      'user_id' => ['required'],
      'category_id' => ['required'],
      'title' => ['required', 'unique:posts', 'string'],
      'slug' => ['required', 'unique:posts', 'string'],
      'body' => ['required', 'string'],
      'image' => ['nullable', 'image', 'max:10000'],
    ];
    $validator = \Validator::make($request->all(), $rules);

    // handle img
    if ($request->file('image')) {
      $file_name = Str::of($request->file('image')->getClientOriginalName())->beforeLast('.')->append(date(now()))->slug()->append('.')->append($request->file('image')->getClientOriginalExtension());
      Storage::disk('public')->putFileAs('images', $request->file('image'), $file_name);
      $img_url = url('/' . 'storage/' . 'images/' . $file_name);
    }

    try {
      $post->update([
        'user_id' => $request->user_id,
        'category_id' => $request->category_id,
        'title' => $request->title,
        'slug' => $request->slug,
        'body' => $request->body,
        // 'image' => $img_url,
        // 'status' => $request->status
      ]);

      return response()->json(['message' => 'data updated successfully'], 200);
    } catch (\Throwable $th) {
      return response()->json($validator->errors(), 400);
      // return response()->json('test', 400);
    }
  }


  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $post = Post::findOrFail($id);

    $post->delete();

    return response()->json(null, 204);
  }
}
