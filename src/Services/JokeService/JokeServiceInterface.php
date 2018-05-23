<?php


namespace App\Services\JokeService;


interface JokeServiceInterface
{
    /**
     * Get categories from API service and return in [key => value] format
     *
     * @return array
     */
    public function getCategories();

    /**
     * Get random joke from API service. Joke MUST have id, text, categories
     *
     * @param string $category
     * @return mixed
     */
    public function getRandomJoke(string $category);
}