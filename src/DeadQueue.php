<?php

namespace LeoCarmo\RedisQueue;

use LeoCarmo\RedisQueue\Exceptions\QueueWithoutConnectionException;

class DeadQueue extends Queue
{

    /**
     * @param string $queue
     *
     * @throws QueueWithoutConnectionException
     */
    public static function restoreMessages(string $queue)
    {
        self::moveMessages(
            $queue,
            self::getDeadQueueName($queue),
            $queue
        );
    }

    /**
     * @param string $queue
     * @return int
     *
     * @throws QueueWithoutConnectionException
     */
    public static function removeMessagesFromQueue(string $queue)
    {
        return parent::removeMessages(
            $queue, self::getDeadQueueName($queue)
        );
    }

    /**
     * @param string $queue
     * @return int
     *
     * @throws QueueWithoutConnectionException
     */
    public static function countMessagesInQueue(string $queue)
    {
        return parent::countMessages(
            $queue, self::getDeadQueueName($queue)
        );
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
        return parent::getMessages(
            $queue, self::getDeadQueueName($queue), $start, $end
        );
    }
}
