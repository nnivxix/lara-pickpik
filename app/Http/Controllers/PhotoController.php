<?php

namespace App\Http\Controllers;

use App\Http\Resources\PhotoResource;
use App\Models\Photo;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    public function index(Request $request)
    {
        $photos = Photo::query()
            ->inRandomOrder()
            ->paginate(15);

        return PhotoResource::collection($photos);
    }

    public function show(Request $request, Photo $photo) {}
}
