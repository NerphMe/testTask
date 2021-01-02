<?php

namespace App\Console\Commands;

use Binance\API;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use function Symfony\Component\Translation\t;

class CryptoCurrency extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crypto:currency';

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
        $api = new API();
        $ticker = $api->prices();
        $result = json_encode($ticker,true);
        Storage::disk('local')->put('cryptoCourses.json', $result);
    }
}
