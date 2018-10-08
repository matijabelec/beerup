<?php

namespace Application\Resource;

interface ResourceInterface
{
    public function getType(): string;

    public function getId(): string;

    /**
     * Return attributes with their values
     */
    public function getAttributes(): array;
}
