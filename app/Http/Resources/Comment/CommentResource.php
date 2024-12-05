<?php

namespace App\Http\Resources\Comment;

use App\Http\Resources\Post\PostResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'body' => $this->body,
            'user_id' => UserResource::make($this->user),
            'post_id' => PostResource::make($this->post),
        ];
    }
}
