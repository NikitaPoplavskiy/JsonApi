<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
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
            'type'          => 'product',
            'id'            => (string)$this->id,
            'attributes'    => [
                'name' => $this->name,
                'price' => $this->price,
                'description' => $this->description,
                'quantity' => $this->quantity,
                'category_id' => $this->category_id,
                'external_id' => $this->external_id,
            ],
        ];
    }
}
