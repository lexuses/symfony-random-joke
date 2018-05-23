<?php

namespace App\Form;

use App\Services\JokeService\JokeService;
use Symfony\Component\Form\ChoiceList\ArrayChoiceList;
use Symfony\Component\Form\ChoiceList\ChoiceListInterface;
use Symfony\Component\Form\ChoiceList\Loader\ChoiceLoaderInterface;

class JokeCategoryChoiceLoader implements ChoiceLoaderInterface
{
    private $loader;
    private $choiceList;

    /**
     * JokeCategoryChoiceLoader constructor.
     */
    public function __construct()
    {
        $this->loader = new JokeService();
    }

    /**
     * Loads a list of choices.
     *
     * Optionally, a callable can be passed for generating the choice values.
     * The callable receives the choice as first and the array key as the second
     * argument.
     *
     * @param null|callable $value The callable which generates the values
     *                             from choices
     *
     * @return ChoiceListInterface The loaded choice list
     */
    public function loadChoiceList($value = null)
    {
        // is called on form view create after loadValuesForChoices of form create
        if ($this->choiceList instanceof ChoiceListInterface) {
            return $this->choiceList;
        }

        // if no values preset yet return empty list
        $this->choiceList = new ArrayChoiceList(array(), $value);

        return $this->choiceList;
    }

    /**
     * Loads the choices corresponding to the given values.
     *
     * The choices are returned with the same keys and in the same order as the
     * corresponding values in the given array.
     *
     * Optionally, a callable can be passed for generating the choice values.
     * The callable receives the choice as first and the array key as the second
     * argument.
     *
     * @param string[] $values An array of choice values. Non-existing
     *                              values in this array are ignored
     * @param null|callable $value The callable generating the choice values
     *
     * @return array An array of choices
     */
    public function loadChoicesForValues(array $values, $value = null)
    {
        if (empty($values)) {
            return array();
        }

        return $values;
    }

    /**
     * Loads the values corresponding to the given choices.
     *
     * The values are returned with the same keys and in the same order as the
     * corresponding choices in the given array.
     *
     * Optionally, a callable can be passed for generating the choice values.
     * The callable receives the choice as first and the array key as the second
     * argument.
     *
     * @param array $choices An array of choices. Non-existing choices in
     *                               this array are ignored
     * @param null|callable $value The callable generating the choice values
     *
     * @return string[] An array of choice values
     */
    public function loadValuesForChoices(array $choices, $value = null)
    {
        // load values
        $labeledValues = $this->loader->getCategories();

        // create internal choice list from loaded values
        $this->choiceList = new ArrayChoiceList($labeledValues, $value);

        return [];
    }
}