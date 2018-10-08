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
     */
    public function createResourceResponse(
        $resource
    ): JsonResponse {
        $document = [
            'data' => $this->encode($resource),
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
     * @return mixed
     */
    private function encode($resource)
    {
        if (is_array($resource)) {
            $collection = [];
            foreach ($resource as $res) {
                $collection[] = $this->encode($res);
            }

            return $collection;
        }

        if (true === isset($this->resourceMap[get_class($resource)])) {
            $resourceClass = $this->resourceMap[get_class($resource)];
            return $this->createResource(new $resourceClass($resource));
        }

        throw new LogicException('Resource does not exist');
    }

    private function createResource(ResourceInterface $resource): array
    {
        return [
            'type' => $resource->getType(),
            'id' => $resource->getId(),
            'attributes' => $resource->getAttributes(),
        ];
    }
}
