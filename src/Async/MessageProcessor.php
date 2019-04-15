<?php


namespace App\Async;
use Enqueue\Psr\PsrMessage;
use Enqueue\Psr\PsrContext;
use Enqueue\Psr\PsrProcessor;
use Enqueue\Client\TopicSubscriberInterface;

class MessageProcessor implements PsrProcessor, TopicSubscriberInterface
{
    public function process(PsrMessage $message, PsrContext $session)
    {
        echo $message->getBody();

        return self::ACK;
        // return self::REJECT; // when the message is broken
        // return self::REQUEUE; // the message is fine but you want to postpone processing
    }

    public static function getSubscribedTopics()
    {
        return ['aFooTopic'];
    }

}