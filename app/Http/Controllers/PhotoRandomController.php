<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use App\Http\Resources\PhotoResource;

class PhotoRandomController extends Controller
{
    public function __invoke(Request $request)
    {
        $photo = Photo::query()
            ->inRandomOrder()
            ->first();

        return PhotoResource::make($photo);
    }
}
