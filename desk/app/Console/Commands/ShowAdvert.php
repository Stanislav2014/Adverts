<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Advert;

class ShowAdvert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'show:advert {id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $advertId = $this->argument('id');
        $headers = ['Name', 'Description', 'Price'];
        if ($advertId) {
            $advert = Advert::find($advertId, ['name', 'description', 'price'])->toArray();
//            dd($advert);
            $this->table($headers, ['items' => $advert]);
        } else {
            $adverts = Advert::all(['name', 'description', 'price']);
//        dd($adverts);
            $this->table($headers, $adverts);
        }
    }
}
