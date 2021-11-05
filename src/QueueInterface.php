<?php

namespace SaaSFormation\Vendor\Queue;

interface QueueInterface
{
    public function publish(Message $message, string $topicName): void;

    public function consume(string $topicName, callable $callback): void;
}
