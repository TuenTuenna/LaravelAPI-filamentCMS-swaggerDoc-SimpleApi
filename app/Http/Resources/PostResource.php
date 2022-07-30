<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $is_published_result = $this->is_published ? "발행됨" : "발행 안됨";
        return [
            'id' => "아이디 : " . $this->id,
            'title' => "타이틀 : " . $this->title,
            'content' => "컨텐트 : " . $this->content,
            'is_published' => "발행여부 : " . $is_published_result,
            'created_at' => $this->created_at->diffForHumans() . " 에 생성됨",
            'updated_at' => $this->updated_at->diffForHumans() . " 에 수정됨",
        ];
    }
}
