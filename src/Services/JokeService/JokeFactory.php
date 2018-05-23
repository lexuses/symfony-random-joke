<?php

namespace App\Services\JokeService;


class JokeFactory
{
    protected $jokeService;

    /**
     * JokeFactory constructor.
     */
    public function __construct(JokeService $jokeService)
    {
        $this->jokeService = $jokeService;
    }

    /**
     * Create Joke object from JokeService
     *
     * @param $category
     * @return Joke
     * @throws ApiUnavailableException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function createRandomJoke($category)
    {
        $data = $this->jokeService->getRandomJoke($category);

        return new Joke($data['id'], $data['text'], $data['categories']);
    }
}