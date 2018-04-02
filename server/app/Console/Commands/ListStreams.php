<?php namespace App\Console\Commands;

use Aws\Kinesis\KinesisClient;
use Illuminate\Console\Command;

class ListStreams extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'domain-streams:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lists all domain streams.';

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
            'region' => 'local',
            'version' => '2013-12-02',
            'endpoint' => 'http://localhost:4567',
        ]);

        $list = $kinesis->listStreams();

        dd($list);
    }
}
