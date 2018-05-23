<?php

namespace App\Services;

use Symfony\Component\Templating\EngineInterface;

class MailMessageFactory
{
    protected $mailer;
    protected $templating;

    public function __construct(\Swift_Mailer $mailer, EngineInterface $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    /**
     * Create Mail Message
     *
     * @param $to
     * @param $text
     * @return \Swift_Message
     */
    public function makeMail($to, $text)
    {
        return $this->mailer
            ->createMessage()
            ->setFrom('send@example.com')
            ->setTo($to)
            ->setSubject('Random Joke')
            ->setBody(
                $this->templating->render(
                    'mail.html.twig',
                    [ 'text' => $text ]
                )
            )
            ;
    }
}