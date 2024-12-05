<?php

namespace App\Http\Resources\Post;

use App\Http\Resources\Blog\BlogResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'blog_id' => BlogResource::make($this->whenLoaded('blog')),
        ];
    }
}
