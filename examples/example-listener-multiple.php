<?php

require '../vendor/autoload.php';

use LeoCarmo\RedisQueue\Listener;

$redis = new Redis();
$redis->connect('localhost');

//Listener::setDefaultQueueClient($redis);
Listener::setQueueClient('my-queue', $redis);

class ProcessMessages
{

    /**
     * @param $events
     * @throws Exception
     */
    public function __invoke($events)
    {
        foreach ($events as $event) {
            $event_decoded = json_decode($event);

            if ($event_decoded->something === 1) {
                // IMPORTANT: This exception on multiple events,
                // will send all events received by this worker to dead queue.
                // Use transactions or bulk inserts when using multiple events
                throw new \Exception('Fail, send to dead queue');
            }

            dump($event);
        }
    }
}

// If the worker crash, we need to restore the processing messages
Listener::restoreMessagesFromProcessingQueue('my-queue', 1);

$processor = new ProcessMessages();

while (true) {
    Listener::processMessages('my-queue', 1, 10, $processor);
}