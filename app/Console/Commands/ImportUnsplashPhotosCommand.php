<?php

namespace App\Console\Commands;

use App\Models\Photo;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class ImportUnsplashPhotosCommand extends Command
{
    protected $signature = 'unsplash:import-photos
                            {--page=1 : The page number to import photos from Unsplash API}
                            {--per-page=30 : The number of photos to import per page}';


    protected $description = 'Import photos from Unsplash API';

    public function handle()
    {
        $this->info('Importing photos from Unsplash API...');
        // Import photos from Unsplash API using HTTP client
        // Save photos to the database

        $perPage = $this->option('per-page');
        $page = $this->option('page');

        $response = Http::withHeaders([
            'Authorization' => 'Client-ID ' . env('UNSPLASH_ACCESS_KEY'),
        ])->get('https://api.unsplash.com/photos', [
            'per_page' => $perPage,
            'page' => $page,
        ]);

        $photos = $response->json();

        $photoDataCollection = [];
        foreach ($photos as $photo) {
            $photoDataCollection[] = [
                'id' => $photo['id'],
                'slug' => $photo['slug'],
                'alternative_slugs' => isset($photo['alternative_slugs']) ? json_encode($photo['alternative_slugs'], JSON_PRETTY_PRINT) : null,
                'created_at' => now(),
                'updated_at' => now(),
                // 'promoted_at' => $photo['promoted_at'] ?? now(),
                'width' => $photo['width'],
                'height' => $photo['height'],
                'color' => $photo['color'],
                'blur_hash' => $photo['blur_hash'] ?? null,
                'description' => $photo['description'] ?? null,
                'alt_description' => $photo['alt_description'] ?? null,
                'urls' => json_encode($photo['urls'], JSON_PRETTY_PRINT),
                'links' => json_encode($photo['links'], JSON_PRETTY_PRINT),
                'likes' => $photo['likes'],
                'liked_by_user' => $photo['liked_by_user'],
                'current_user_collections' => isset($photo['current_user_collections']) ? json_encode($photo['current_user_collections'], JSON_PRETTY_PRINT) : null,
                'sponsorship' => isset($photo['sponsorship']) ? json_encode($photo['sponsorship'], JSON_PRETTY_PRINT) : null,
                'topic_submissions' => isset($photo['topic_submissions']) ? json_encode($photo['topic_submissions'], JSON_PRETTY_PRINT) : null,
                'asset_type' => $photo['asset_type'] ?? null,
                'user' => json_encode($photo['user'], JSON_PRETTY_PRINT),
            ];
        }

        // Insert all photo data into the database in a single query
        if (!empty($photoDataCollection)) {

            // add db transaction
            DB::transaction(function () use ($photoDataCollection) {
                Photo::upsert($photoDataCollection, ['id'], ['slug', 'alternative_slugs', 'created_at', 'updated_at', 'width', 'height', 'color', 'blur_hash', 'description', 'alt_description', 'urls', 'links', 'likes', 'liked_by_user', 'current_user_collections', 'sponsorship', 'topic_submissions', 'asset_type', 'user']);
            });
            // Photo::insert($photoDataCollection);

            //create file json to store data
            // $filePath = public_path('photos.json');
            // $file = fopen($filePath, 'w');

            // fwrite($file, json_encode($photoDataCollection, JSON_PRETTY_PRINT));
            // fclose($file);
            $this->info('Photos imported successfully!');
        } else {
            $this->info('No photos found to import!');
        }
    }
}
