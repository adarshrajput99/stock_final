<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\paisa;
class logon extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:logon';

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
        $obj = app()->make(paisa::class);
        $token = $obj->call_5paisa(197624);
        $obj->testing($token);
    }
}
