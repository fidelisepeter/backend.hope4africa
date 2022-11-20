<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogPostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $author = User::where('id', $this->author_id)->first();
        return [
            'id' => $this->id,
            'title' => $this->title,
            'author' => $author,
            'content' => $this->content,
            'tags' => $this->tags ?? '',
            'thumbnail' => url('thumbnails/'.$this->thumbnail),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ];
    }
}
