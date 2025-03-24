<?php

namespace App\Http\Controllers;

use App\Http\Resources\PhotoResource;
use App\Models\Photo;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'per_page' => 'integer|min:1|max:30',
        ]);

        $photos = Photo::limit($request->per_page ?? 15)
            ->inRandomOrder()
            ->get();

        return PhotoResource::collection($photos)
            ->response()
            ->setData($photos->map(fn($photo) => (new PhotoResource($photo))->resolve()));
    }

    public function show(Request $request, Photo $photo)
    {
        return new PhotoResource($photo);
    }
}
