<?php

require '../vendor/autoload.php';

use \LeoCarmo\RedisQueue\DeadQueue;

$redis = new Redis();
$redis->connect('localhost');

$queue = 'my-queue';

//DeadQueue::setDefaultQueueClient($redis);
DeadQueue::setQueueClient($queue, $redis);

echo DeadQueue::countMessagesInQueue($queue) . PHP_EOL;
dump(DeadQueue::getMessagesFromQueue($queue, 0, 9));

DeadQueue::restoreMessages($queue);
echo DeadQueue::countMessagesInQueue($queue) . PHP_EOL;

dump(DeadQueue::removeMessagesFromQueue($queue));
dump(DeadQueue::getMessagesFromQueue($queue, 0, 9));
echo DeadQueue::countMessagesInQueue($queue) . PHP_EOL;



