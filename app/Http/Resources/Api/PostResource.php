<?php

namespace App\Http\Resources\Api;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\TagResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function toArray($request)
  {
    // return parent::toArray($request);
    return [
      'user' => $this->user->name,
      'category' => new CategoryResource($this->category),
      'title' => $this->title,
      'slug' => $this->slug,
      'body' => $this->body,
      'image' => $this->image,
      'status' => $this->status(),
      'tags' => TagResource::collection($this->tags),
      'created_at' => $this->created_at->format('Y-m-d h:i a')
    ];
  }

  // public function with($request)
  // {
  //   return [
  //     'version' => '1.0.0',
  //     'author_url' => url('/')
  //   ];
  // }
}
