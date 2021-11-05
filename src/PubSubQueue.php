<?php

namespace SaaSFormation\Vendor\Queue;

use Google\Cloud\PubSub\PubSubClient;

class PubSubQueue implements QueueInterface
{
    private PubSubClient $client;

    public function __construct(PubSubClient $client)
    {
        $this->client = $client;
    }

    public function publish(Message $message, string $topicName): void
    {
        $topic = $this->client->topic($topicName);
        if(!$topic->exists()) {
            $topic = $this->client->createTopic($topicName);
        }

        $topic->publish([
            'data' => json_encode($message->data()),
            'attributes' => $message->tags()
        ]);
    }

    public function consume(string $topicName, callable $callback): void
    {
        $topic = $this->client->topic($topicName);

        $subscription = $topic->subscribe('subscription-to-' . $topicName . '-' . microtime());

        foreach($subscription->pull() as $message) {
            $callback($subscription, $message);
        }
    }
}
