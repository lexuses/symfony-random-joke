<?php

namespace App\Tests\Unit;

use App\Services\JokeService\JokeService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class JokeServiceTest extends WebTestCase
{
    public function testGetCategories()
    {
        $service = new JokeService();
        $categories = $service->getCategories();

        $this->assertTrue(is_array($categories), $message='Categories are not array instance');
        $this->assertGreaterThan(0, $categories, $message='No category items in response');
    }

    public function testGetRandomJoke()
    {
        $service = new JokeService();
        $joke = $service->getRandomJoke('nerdy');

        $this->assertTrue(is_array($joke), $message='Joke from service is not array');

        $this->assertArrayHasKey('id', $joke);
        $this->assertArrayHasKey('text', $joke);
        $this->assertArrayHasKey('categories', $joke);
    }
}