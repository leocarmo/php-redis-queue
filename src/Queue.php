<?php

namespace LeoCarmo\RedisQueue;

use LeoCarmo\RedisQueue\Exceptions\QueueWithoutConnectionException;

abstract class Queue
{

    use RedisClient;

    /**
     * @param string $queue
     * @param string $worker
     * @return string
     */
    protected static function getProcessingQueueName(string $queue, string $worker)
    {
        return "{$queue}-worker-{$worker}";
    }

    /**
     * @param string $queue
     * @return string
     */
    protected static function getDeadQueueName(string $queue)
    {
        return "{$queue}-dead";
    }

    /**
     * @param string $queue
     * @param string $source
     * @param string $destination
     *
     * @throws QueueWithoutConnectionException
     */
    protected static function moveMessages(string $queue, string $source, string $destination)
    {
        do {
            $value = self::client($queue)->rpoplpush($source, $destination);
        } while ($value !== false);
    }

    /**
     * @param string $queue
     * @param string $key
     * @return bool
     *
     * @throws QueueWithoutConnectionException
     */
    protected static function removeMessages(string $queue, string $key)
    {
        return (bool) self::client($queue)->del($key);
    }

    /**
     * @param string $queue
     * @param string $key
     * @return int
     *
     * @throws QueueWithoutConnectionException
     */
    protected static function countMessages(string $queue, string $key)
    {
        return (int) self::client($queue)->lLen($key);
    }

    /**
     * @param string $queue
     * @param string $key
     * @param int $start
     * @param int $end
     * @return array
     *
     * @throws QueueWithoutConnectionException
     */
    protected static function getMessages(string $queue, string $key, int $start, int $end)
    {
        return self::client($queue)->lRange(
            $key, $start, $end
        );
    }
}
