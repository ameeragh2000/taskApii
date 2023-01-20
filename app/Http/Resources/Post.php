<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Post extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
            'id'=>$this->id ,
        	'title'=>$this->title,
            'content'=>$this->content,
            'user_id'=>$this->user_id,
            'created_at'=>$this->created_at->formate('d/m/y')	,
            'updated_at'=>$this->updated_at->formate('d/m/y')
        ];
    }
}
