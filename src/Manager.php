<?php

namespace LeoCarmo\RedisQueue;

use LeoCarmo\RedisQueue\Exceptions\QueueWithoutConnectionException;

class Manager extends Queue
{

    /**
     * @param string $queue
     * @return bool
     *
     * @throws QueueWithoutConnectionException
     */
    public static function removeMessagesFromQueue(string $queue)
    {
        return parent::removeMessages($queue, $queue);
    }

    /**
     * @param string $queue
     * @return int
     *
     * @throws QueueWithoutConnectionException
     */
    public static function countMessagesInQueue(string $queue)
    {
        return parent::countMessages($queue, $queue);
    }

    /**
     * @param string $queue
     * @param int $start
     * @param int $end
     * @return array
     *
     * @throws QueueWithoutConnectionException
     */
    public static function getMessagesFromQueue(string $queue, int $start, int $end)
    {
        return parent::getMessages($queue, $queue, $start, $end);
    }
}
