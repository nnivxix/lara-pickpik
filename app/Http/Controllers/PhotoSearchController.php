<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PhotoResource;

class PhotoSearchController extends Controller
{

    public function __invoke(Request $request)
    {
        try {
            $request->validate([
                'query' => 'required|string|min:3',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $e->errors(),
            ], 422);
        }

        $query = $request->query('query');
        $page = $request->query('page', 1);

        $photos = Photo::query()
            ->where('description', 'like', "%{$query}%")
            ->orWhere('alt_description', 'like', "%{$query}%")
            ->limit(10)
            ->offset(($page - 1) * 10)
            ->get();

        $collection = PhotoResource::collection($photos);
        $collection->wrap('results');

        return $collection->additional([
            // dummy data for total and total_pages
            'total' => 1000,
            'total_pages' => 100,
        ]);
    }
}
