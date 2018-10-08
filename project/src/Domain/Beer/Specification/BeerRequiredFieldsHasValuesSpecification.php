<?php

namespace Domain\Beer\Specification;

class BeerRequiredFieldsHasValuesSpecification
{
    public function isSatisfiedBy(array $beerData)
    {
        $attributes = [
            'name',
            'abv',
        ];

        foreach ($attributes as $attribute) {
            if (true === empty($beerData[$attribute])) {
                return false;
            }
        }
        return true;
    }
}
