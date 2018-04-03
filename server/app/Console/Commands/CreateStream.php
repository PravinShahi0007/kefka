<?php namespace App\Console\Commands;

use Aws\Kinesis\KinesisClient;
use Illuminate\Console\Command;

class CreateStream extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'domain-streams:create {name} {partition_count=5}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new domain stream.';

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
        $partitionCount = intval($this->argument('partition_count'));

        $kinesis = new KinesisClient([
            'region' => 'local',
            'version' => '2013-12-02',
            'endpoint' => 'http://localhost:4567',
            'credentials' => [
                'key' => 'local',
                'secret' => 'local',
            ],
        ]);

        $kinesis->createStream([
            'StreamName' => $name,
            'ShardCount' => $partitionCount,
        ]);
    }
}
