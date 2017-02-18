<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class IncomingCall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cmd:incomcall {ext} {number} {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Incoming Call Command';

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
     * @return mixed
     */
    public function handle()
    {

        event(new \App\Events\IncomingCallEvent($this->argument('ext'), $this->argument('number'), $this->argument('name')));

    }
}
