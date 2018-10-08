<?php

declare(strict_types=1);

namespace Domain\Beer\Browse;

final class OrderByField
{
    /**
     * @var string
     */
    private $field;

    /**
     * @var string
     */
    private $order;

    public function __construct(
        string $field
    ) {
        if (
            strlen($field) > 0
            &&
            '-' === $field[0]
        ) {
            $this->order = 'DESC';
            $this->field = substr($field, 1);
        } else {
            $this->order = 'ASC';
            $this->field = $field;
        }
    }

    /**
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * @return string
     */
    public function getOrder(): string
    {
        return $this->order;
    }
}
