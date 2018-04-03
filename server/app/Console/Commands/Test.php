<?php namespace App\Console\Commands;

use App\Events\ManualSignup;
use App\Streams\Circumstance;
use App\Streams\DomainEvent;
use Aws\Kinesis\KinesisClient;
use Google\Protobuf\Any;
use Google\Protobuf\Timestamp;
use Illuminate\Console\Command;
use Illuminate\Contracts\Hashing\Hasher;
use Ramsey\Uuid\Uuid;

class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'domain-streams:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete me.';

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
    public function handle(Hasher $hasher)
    {
        $manualSignup = new ManualSignup();
        $manualSignup->setId(Uuid::uuid4()->toString());
        $manualSignup->setEmail('atrauzzi@gmail.com');
        $manualSignup->setFirstName('Alexander');
        $manualSignup->setLastName('Trauzzi');
        $manualSignup->setAlias('Omega');
        $manualSignup->setPassword($hasher->make('zxczxc123'));

        $any = new Any();
        $any->pack($manualSignup);

        $timestamp = new Timestamp();
        // https://github.com/google/protobuf/issues/4462
        $timestamp->fromDateTime(new \DateTime(now()));

        $domainEvent = new DomainEvent();
        $domainEvent->setReceived($timestamp);
        $domainEvent->setRelay('alex');
        $domainEvent->setEvent($any);
        $domainEvent->setCircumstance(Circumstance::MANUAL);

        //dump($domainEvent->serializeToString());
        dump($domainEvent->serializeToJsonString());

        $kinesis = new KinesisClient([
            'region' => 'local',
            'version' => '2013-12-02',
            'endpoint' => 'http://localhost:4567',
            'credentials' => [
                'key' => 'local',
                'secret' => 'local',
            ],
        ]);

        $kinesis->putRecord([
            'StreamName' => 'identity',
            'Data' => $domainEvent->serializeToString(),
            'PartitionKey' => $manualSignup->getId(),
        ]);
    }
}
