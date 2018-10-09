<?php

declare(strict_types=1);

namespace Infrastructure\Response;

use Application\Resource\ResourceInterface;
use LogicException;
use Symfony\Component\HttpFoundation\JsonResponse;

final class ApiResponseFactory
{
    /**
     * @var string[]
     */
    private $resourceMap;

    /**
     * @param string[] $resourceMap
     */
    public function __construct(
        array $resourceMap
    ) {
        $this->resourceMap = $resourceMap;
    }

    /**
     * @param mixed $resource
     * @param string[] $fields
     */
    public function createResourceResponse(
        $resource,
        array $fields = []
    ): JsonResponse {
        $document = [
            'data' => $this->encode($resource, $fields),
        ];

        return new JsonResponse($document);
    }

    public function createErrorResponse(
        int $status,
        string $title,
        string $detail
    ): JsonResponse {
        $document = [
            'errors' => [
                [
                    'status' => $status,
                    'title' => $title,
                    'detail' => $detail,
                ]
            ],
        ];

        return new JsonResponse($document, $status);
    }

    /**
     * @param mixed $resource
     * @param string[] $fields
     * @return mixed
     */
    private function encode(
        $resource,
        array $fields = []
    ) {
        if (is_array($resource)) {
            $collection = [];
            foreach ($resource as $res) {
                $collection[] = $this->encode($res, $fields);
            }

            return $collection;
        }

        if (true === isset($this->resourceMap[get_class($resource)])) {
            $resourceClass = $this->resourceMap[get_class($resource)];
            return $this->createResource(new $resourceClass($resource), $fields);
        }

        throw new LogicException('Resource does not exist');
    }

    /**
     * @param string[] $fields
     */
    private function createResource(
        ResourceInterface $resource,
        array $fields = []
    ): array {
        return [
            'type' => $resource->getType(),
            'id' => $resource->getId(),
            'attributes' => $resource->getAttributes($fields),
        ];
    }
}
