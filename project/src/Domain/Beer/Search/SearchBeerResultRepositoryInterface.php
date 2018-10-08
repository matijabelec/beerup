<?php

namespace Domain\Beer\Search;

interface SearchBeerResultRepositoryInterface
{
    public function search(SearchTerm $searchTerm): SearchBeerResult;
}
