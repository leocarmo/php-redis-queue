<?php

namespace LeoCarmo\RedisQueue;

use LeoCarmo\RedisQueue\Exceptions\QueueWithoutConnectionException;

class Listener extends Queue
{

    /**
     * @param string $queue
     * @param string $worker
     *
     * @throws QueueWithoutConnectionException
     */
    public static function restoreMessagesFromProcessingQueue(string $queue, string $worker)
    {
        self::moveMessages(
            $queue,
            self::getProcessingQueueName($queue, $worker),
            $queue
        );
    }

    /**
     * @param string $queue
     * @param string $worker
     * @param int $quantity
     * @param callable $callback
     *
     * @throws QueueWithoutConnectionException
     */
    public static function processMessages(string $queue, string $worker, int $quantity, callable $callback)
    {
        if ($events = self::getMessagesFromQueue($queue, $worker, $quantity)) {
            try {
                $callback(
                    $quantity === 1 ? $events[0] : $events
                );

                self::removeMessagesFromQueue($queue, $worker, $events);
            } catch (\Throwable $e) {
                self::moveMessagesToDeadQueue($queue, $worker);
            }
        }
    }

    /**
     * @param string $queue
     * @param string $worker
     * @param int $quantity
     * @return array
     *
     * @throws QueueWithoutConnectionException
     */
    protected static function getMessagesFromQueue(string $queue, string $worker, int $quantity)
    {
        $clientMulti = self::client($queue)->multi();

        for ($i = 0; $i < $quantity; $i++) {
            $clientMulti->brpoplpush(
                $queue,
                self::getProcessingQueueName($queue, $worker),
                0
            );
        }

        return array_filter(
            $clientMulti->exec()
        );
    }

    /**
     * @param string $queue
     * @param string $worker
     * @param $events
     *
     * @throws QueueWithoutConnectionException
     */
    protected static function removeMessagesFromQueue(string $queue, string $worker, $events)
    {
        $clientMulti = self::client($queue)->multi();

        foreach ($events as $value) {
            $clientMulti->lRem(
                self::getProcessingQueueName($queue, $worker),
                $value,
                1
            );
        }

        $clientMulti->exec();
    }

    /**
     * @param string $queue
     * @param string $worker
     *
     * @throws QueueWithoutConnectionException
     */
    protected static function moveMessagesToDeadQueue(string $queue, string $worker)
    {
        self::moveMessages(
            $queue,
            self::getProcessingQueueName($queue, $worker),
            self::getDeadQueueName($queue)
        );
    }
}
