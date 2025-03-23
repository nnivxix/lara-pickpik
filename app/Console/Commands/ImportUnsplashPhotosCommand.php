<?php

namespace App\Console\Commands;

use App\Models\Photo;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class ImportUnsplashPhotosCommand extends Command
{
    protected $signature = 'unsplash:import-photos';


    protected $description = 'Import photos from Unsplash API';

    public function handle()
    {
        $this->info('Importing photos from Unsplash API...');
        // Import photos from Unsplash API using HTTP client
        // Save photos to the database

        $response = Http::withHeaders([
            'Authorization' => 'Client-ID ' . env('UNSPLASH_ACCESS_KEY'),
        ])->get('https://api.unsplash.com/photos', [
            'per_page' => 50,
        ]);

        $photos = $response->json();

        $photoDataCollection = [];
        foreach ($photos as $photo) {
            $photoDataCollection[] = [
                'id' => $photo['id'],
                'slug' => $photo['slug'],
                'alternative_slugs' => $photo['alternative_slugs'],
                'created_at' => $photo['created_at'],
                'updated_at' => $photo['updated_at'],
                'promoted_at' => $photo['promoted_at'],
                'width' => $photo['width'],
                'height' => $photo['height'],
                'color' => $photo['color'],
                'blur_hash' => $photo['blur_hash'],
                'description' => $photo['description'],
                'alt_description' => $photo['alt_description'],
                'urls' => $photo['urls'],
                'links' => $photo['links'],
                'likes' => $photo['likes'],
                'liked_by_user' => $photo['liked_by_user'],
                'current_user_collections' => $photo['current_user_collections'],
                'sponsorship' => $photo['sponsorship'],
                'topic_submissions' => $photo['topic_submissions'],
                'asset_type' => $photo['asset_type'],
                'user' => $photo['user'],

            ];
        }

        // Insert all photo data into the database in a single query
        if (!empty($photoDataCollection)) {
            Photo::insert($photoDataCollection);
        }


        $this->info('Photos imported successfully!');
    }
}
