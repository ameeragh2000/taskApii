<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Comment extends JsonResource
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
        	'comment'=>$this->comment,
            'post_id'=>$this->post_id,
            'user_id'=>$this->user_id,
            'created_at'=>$this->created_at->formate('d/m/y')	,
            'updated_at'=>$this->updated_at->formate('d/m/y')
        ];
    }
}
