<?php namespace App\Http\Controllers;


use Aws\Kinesis\KinesisClient;
use Illuminate\Http\Request;

class EventController
{
    public function show(Request $request) {

        $kinesis = new KinesisClient([
            'region' => 'local',
            'version' => '2013-12-02',
            'endpoint' => 'http://localhost:4567',
            'credentials' => [
                'key' => 'local',
                'secret' => 'local',
            ],
        ]);
//dd([
//    'StreamName' => $request->get('stream', 'identity'),
//    'ShardId' => 1,
//    'ShardIteratorType' => 'AT_SEQUENCE_NUMBER',
//    'StartingSequenceNumber' => intval($request->get('position', 1)),
//]);
        $iterator = $kinesis->getShardIterator([
            'StreamName' => $request->get('stream', 'identity'),
            'ShardId' => '0',
            'ShardIteratorType' => 'TRIM_HORIZON',
//            'StartingSequenceNumber' => $request->get('position', '1'),
        ])->get('ShardIterator');
//dd($iterator);
        $records = $kinesis->getRecords([
            'Limit' => 1,
            'ShardIterator' => $iterator,
        ]);
dd($records);
    }
}