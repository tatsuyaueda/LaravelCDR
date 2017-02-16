<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PushWebsocketNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chat:message {message}';

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
     * @return mixed
     */
    public function handle()
    {
        $user = \App\User::first();
        $message = \App\Message::create([
            'user_id' => $user->id,
            'message' => $this->argument('message'),
        ]);

        // ToDo: テスト用
        if(starts_with($message->message, "B")){
            event(new \App\Events\MessageCreateBroadcastEvent($message));
        }else{
            event(new \App\Events\MessageCreatePrivateEvent($message));
        }

    }
}
