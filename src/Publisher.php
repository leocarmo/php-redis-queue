<?php

namespace LeoCarmo\RedisQueue;

use LeoCarmo\RedisQueue\Exceptions\QueueWithoutConnectionException;

class Publisher extends Queue
{

    /**
     * @param string $queue
     * @param array $message
     *
     * @throws QueueWithoutConnectionException
     */
    public static function pushMessage(string $queue, array $message)
    {
        self::client($queue)->lPush($queue, json_encode($message));
    }
}
