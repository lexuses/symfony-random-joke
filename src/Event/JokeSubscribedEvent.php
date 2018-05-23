<?php

namespace App\Event;

use Symfony\Component\EventDispatcher\Event;

class JokeSubscribedEvent extends Event
{
    const NAME = 'joke.subscribed';

    protected $email;
    protected $category;

    /**
     * JokeSubscribeEvent constructor.
     * @param $email string
     * @param $category string
     */
    public function __construct($email, $category)
    {
        $this->email = $email;
        $this->category = $category;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }
}