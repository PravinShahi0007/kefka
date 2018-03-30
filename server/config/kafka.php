<?php return [

    'brokers' => env('KAFKA_BROKERS'),

    'producer' => [
        'config' => [
            'queue.buffering.max.ms' => 1,
        ],
    ],

    'topics' => [

        'alex' => [

            'partitioner' => RD_KAFKA_MSG_PARTITIONER_CONSISTENT,

            'config' => [
            ],
        ],
    ],
];
