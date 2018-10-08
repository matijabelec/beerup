<?php

namespace Domain\Beer\Specification;

class BeerDataIsValidSpecification
{
    /**
     * @var BeerRequiredFieldsHasValuesSpecification
     */
    private $beerRequiredFieldsHasValuesSpecification;

    /**
     * @var BeerNameIsAtLeastTwoCharactersLongSpecification
     */
    private $beerNameIsAtLeastTwoCharactersLongSpecification;

    public function __construct(
        BeerRequiredFieldsHasValuesSpecification $beerRequiredFieldsHasValuesSpecification,
        BeerNameIsAtLeastTwoCharactersLongSpecification $beerNameIsAtLeastTwoCharactersLongSpecification
    ) {
        $this->beerRequiredFieldsHasValuesSpecification = $beerRequiredFieldsHasValuesSpecification;
        $this->beerNameIsAtLeastTwoCharactersLongSpecification = $beerNameIsAtLeastTwoCharactersLongSpecification;
    }

    public function isSatisfiedBy(
        array $beerData
    ): bool {
        if (false === $this->beerRequiredFieldsHasValuesSpecification->isSatisfiedBy($beerData)) {
            return false;
        }

        if (false === $this->beerNameIsAtLeastTwoCharactersLongSpecification->isSatisfiedBy($beerData)) {
            return false;
        }

        return true;
    }
}
