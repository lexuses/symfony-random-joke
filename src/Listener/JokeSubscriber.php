<?php

namespace App\Listener;

use App\Event\JokeSubscribedEvent;
use App\Services\JokeService\JokeFactory;
use App\Services\MailMessageFactory;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class JokeSubscriber implements EventSubscriberInterface
{
    private $jokeFactory;
    private $mailFactory;
    private $mailer;

    /**
     * JokeSubscriber constructor.
     */
    public function __construct(JokeFactory $jokeFactory, MailMessageFactory $mailFactory, \Swift_Mailer $mailer)
    {
        $this->jokeFactory = $jokeFactory;
        $this->mailFactory = $mailFactory;
        $this->mailer = $mailer;
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2')))
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
            JokeSubscribedEvent::NAME => 'onSubscribe',
        ];
    }

    /**
     * Get joke and send it to email
     *
     * @param JokeSubscribedEvent $event
     * @throws \App\Services\JokeService\ApiUnavailableException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function onSubscribe(JokeSubscribedEvent $event)
    {
        $joke = $this->jokeFactory->createRandomJoke(
            $event->getCategory()
        );
        $mail = $this->mailFactory
            ->makeMail($event->getEmail(), $joke->getText());
        $this->mailer->send($mail);
    }
}