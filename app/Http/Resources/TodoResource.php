<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use function json_encode;

class TodoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'deadline' => ($this->deadline == null) ? "마감기한이 정해져 있지 않습니다." : date('Y-m-d', strtotime($this->deadline)),
            'isDone' => $this->id,
            'updated_at' => $this->updated_at->diffForHumans()."전에 수정되었습니다.",
        ];
    }
}
