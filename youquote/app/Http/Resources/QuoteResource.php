<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuoteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);   // transform all data 

        // return [                            // specify which data to transfer
        //     'content' => $this->content,
        //     'author' => $this->author,
        // ];
    }
}
