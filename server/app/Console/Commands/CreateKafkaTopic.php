<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use RdKafka\TopicConf;
use Symfony\Component\Console\Input\InputArgument;


class CreateKafkaTopic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kafka:create-topic';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a kafka topic';

    public function getArguments()
    {
        return [
            [
                'name',
                InputArgument::REQUIRED,
                'A name for the topic.',
            ]
        ];
    }

    public function getOptions()
    {
        return [

        ];
    }

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
        $topicConfiguration = new TopicConf();

        $topicConfiguration->set();
    }
}
