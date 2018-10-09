<?php

namespace Application\Resource;

interface ResourceInterface
{
    public function getType(): string;

    public function getId(): string;

    /**
     * Return attributes with their values
     * @param string[] $fileds
     */
    public function getAttributes(array $fields = []): array;
}
