<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\data_fetch;
class check extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check';

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
        $obj = app()->make(data_fetch::class);
        $obj->get_data();
    }
}
