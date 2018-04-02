<?php namespace App\Providers;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use RdKafka\Conf;
use RdKafka\Producer;
use RdKafka\ProducerTopic;
use RdKafka\TopicConf;


class KafkaServiceProvider extends ServiceProvider
{
    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(Conf::class, function (Application $app) {

            $producerConfigurationData = config("kafka.producer");
            $config = new Conf();
            $config->set('debug','all');

            foreach ($producerConfigurationData['config'] as $key => $value) {
                $config->set($key, $value);
            }

            return $config;
        });

        $this->app->singleton(Producer::class, function (Application $app) {

            $config = $app->make(Conf::class);
            $producer = new Producer($config);

            // todo: Figure out the correct log level to set for $debug and !$debug
            $producer->setLogLevel(LOG_DEBUG);
            $producer->addBrokers(config('kafka.brokers'));

            return $producer;
        });

        $this->app->bind(TopicConf::class, function (Application $app, array $deps) {

            $topicConfigurationData = config("kafka.topics.{$deps['name']}");

            $topicConfiguration = new TopicConf();
            $topicConfiguration->setPartitioner(array_pull($topicConfigurationData, 'partitioner', RD_KAFKA_MSG_PARTITIONER_CONSISTENT));

            foreach ($topicConfigurationData['config'] as $key => $value) {
                $topicConfiguration->set($key, $value);
            }

            return $topicConfiguration;
        });

        $this->app->bind(ProducerTopic::class, function (Application $app, array $deps) {

            $kafka = $app->make(Producer::class);
            $topicConfiguration = $app->makeWith(TopicConf::class, $deps);

            $producerTopic = $kafka->newTopic($deps['name'], $topicConfiguration);

            return $producerTopic;
        });
    }
}
