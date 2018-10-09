<?php

declare(strict_types=1);

namespace Application\Response;

final class Response
{
    /**
     * @var mixed
     */
    private $resource;

    /**
     * @var string[]
     */
    private $fields;

    /**
     * @param mixed $resource
     * @param string[] $fields
     */
    public function __construct(
        $resource,
        array $fields = []
    ) {
        $this->resource = $resource;
        $this->fields = $fields;
    }

    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @return string[]
     */
    public function getFields(): array
    {
        return $this->fields;
    }
}
