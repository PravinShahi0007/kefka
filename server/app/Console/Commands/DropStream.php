<?php namespace App\Console\Commands;

use Aws\Kinesis\KinesisClient;
use Illuminate\Console\Command;


class DropStream extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'domain-streams:drop {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Drop a domain stream.';

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
        $name = $this->argument('name');

        $kinesis = new KinesisClient([
            'region' => 'local',
            'version' => '2013-12-02',
            'endpoint' => 'http://localhost:4567',
            'credentials' => [
                'key' => 'local',
                'secret' => 'local',
            ],
        ]);

        $kinesis->deleteStream([
            'StreamName' => $name,
        ]);
    }
}
