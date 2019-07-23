<?php

namespace LeoCarmo\RedisQueue;

use LeoCarmo\RedisQueue\Exceptions\QueueWithoutConnectionException;

trait RedisClient
{

    /**
     * @var \Redis
     */
    protected static $redis;

    /**
     * @param string $queue
     * @param \Redis $redis
     */
    public static function setQueueClient(string $queue, \Redis $redis)
    {
        self::$redis[$queue] = $redis;
    }

    /**
     * @param \Redis $redis
     */
    public static function setDefaultQueueClient(\Redis $redis)
    {
        self::$redis['default'] = $redis;
    }

    /**
     * @param string $queue
     * @return \Redis
     *
     * @throws QueueWithoutConnectionException
     */
    protected static function client(string $queue)
    {
        if (self::$redis[$queue]) {
            return self::$redis[$queue];
        }

        if (self::$redis['default']) {
            return self::$redis['default'];
        }

        throw new QueueWithoutConnectionException("Queue {$queue} without redis connection.");
    }
}
