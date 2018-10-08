<?php

namespace Application\Request;

class RequestContentValidator
{
    public function validateData(
        string $content,
        array $requiredFields = []
    ): array {
        $array = json_decode($content, true);

        if (false === is_array($array)) {
            throw new \Exception('Request content is not valid json', 1000);
        }

        $data = $array['data'] ?? null;

        if (null === $data) {
            throw new \Exception('Request content must contain "data" key', 1000);
        }

        if (count($data) !== count($requiredFields)) {
            throw new \Exception(
                sprintf('Required fields missing, required fields: "%s"', implode('", "', $requiredFields)),
                1000
            );
        }

        foreach ($requiredFields as $requiredField) {
            if (false === array_key_exists($requiredField, $data)) {
                throw new \Exception(
                    sprintf('Required field missing: "%s"', $requiredField),
                    1000
                );
            }
        }

        return $data;
    }
}
