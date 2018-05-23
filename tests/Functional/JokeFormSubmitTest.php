<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class JokeFormSubmitTest extends WebTestCase
{
    public function testSubmitFormAndMailIsSent()
    {
        $userEmail = 'test@example.com';

        $client = static::createClient();
        $client->enableProfiler();

        $crawler = $client->request('GET', '/');
        $mailCollector = $client->getProfile()->getCollector('swiftmailer');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Send')->form();
        $form['subscription[email]'] = $userEmail;
        $form['subscription[category]'] = 'nerdy';

        $client->submit($form);

        // checks that an email was sent
        $this->assertSame(1, $mailCollector->getMessageCount());

        $collectedMessages = $mailCollector->getMessages();
        $message = $collectedMessages[0];

        // Asserting e-mail data
        $this->assertInstanceOf('Swift_Message', $message);
        $this->assertEquals('Random Joke', $message->getSubject());
        $this->assertEquals($userEmail, key($message->getTo()));

        // Check response
        $client->followRedirect();

        $this->assertContains(
            'Success',
            $client->getResponse()->getContent()
        );




    }
}