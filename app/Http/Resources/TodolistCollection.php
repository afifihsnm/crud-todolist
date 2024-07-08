<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\TodolistResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TodolistCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): AnonymousResourceCollection
    {
        return TodolistResource::collection($this->collection);
    }
}
