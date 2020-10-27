<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Advert;
use Illuminate\Support\Facades\Storage;

class GetImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $advertId;

    protected $images;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($advertId, $images)
    {
        $this->advertId = $advertId;
        $this->images = $images;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $imageLinks = [];
        foreach ($this->images as $image) {
            $contents = file_get_contents($image);
            $name = basename($image);
            if (Storage::disk('local')->put('public/' . $name, $contents)) {
                $imageLinks[] = Storage::disk('local')->url('public/' . $name);
            }

        }

        $advert = Advert::find($this->advertId);

        $advert->images = serialize($imageLinks);
        $advert->save();

    }
}
