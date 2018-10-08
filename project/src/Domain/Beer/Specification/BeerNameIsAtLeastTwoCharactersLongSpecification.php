<?php

namespace Domain\Beer\Specification;

class BeerNameIsAtLeastTwoCharactersLongSpecification
{
    public function isSatisfiedBy(array $beerData)
    {
        $attribute = 'name';
        if (
            true === isset($beerData[$attribute])
            &&
            strlen($beerData[$attribute]) >= 2
        ) {
            return true;
        }
        return false;
    }
}
