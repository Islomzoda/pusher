<?php

namespace App\Console\Commands;

use App\Jobs\PusherJob;
use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class PusherCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upload:jobs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $clients = Client::whereBetween('send_at', [now(), now()->addMinutes(10)])
            ->where('status', 'dispatching')
            ->get();
        if ($clients->isNotEmpty()){
            foreach ($clients as $client){
                PusherJob::dispatch($client->id)->delay(Carbon::parse($client->send_at));
            }
        }


    }
}
