<?php namespace App\Console\Commands;

use Aws\Kinesis\KinesisClient;
use Illuminate\Console\Command;


class Consume extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'domain-streams:consume';

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
        $kinesis = new KinesisClient([
            "endpoint" => "localhost",
        ]);

        // what shards/partitions are we reading from?

        // iterate forever
            // check for terminated state
            // get 1 item
            // check for any error state
            // publish item to laravel events
    }
}
