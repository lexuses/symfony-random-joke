<?php

namespace App\Tests\Unit;

use App\Services\JokeService\Joke;
use App\Services\JokeService\JokeFactory;
use App\Services\JokeService\JokeService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class JokeFactoryTest extends WebTestCase
{
    public function testGetRandomJoke()
    {
        $service = new JokeService();
        $factory = new JokeFactory($service);
        $joke = $factory->createRandomJoke('nerdy');
        $this->assertInstanceOf(Joke::class, $joke);
    }
}