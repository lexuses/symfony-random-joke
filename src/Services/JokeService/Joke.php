<?php

namespace App\Services\JokeService;


class Joke
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $text;

    /**
     * @var array
     */
    private $categories;

    /**
     * Joke constructor.
     * @param int $id
     * @param string $text
     * @param array $categories
     */
    public function __construct(int $id, string $text, array $categories)
    {
        $this->id = $id;
        $this->text = $text;
        $this->categories = $categories;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return array
     */
    public function getCategories(): array
    {
        return $this->categories;
    }
}