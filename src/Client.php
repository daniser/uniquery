<?php

declare(strict_types=1);

namespace TTBooking\UniQuery;

use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface as HttpClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\BackedEnumNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Client implements ClientInterface
{
    protected HttpClientInterface $httpClient;

    protected RequestFactoryInterface $requestFactory;

    protected StreamFactoryInterface $streamFactory;

    protected ValidatorInterface $validator;

    protected SerializerInterface $serializer;

    /**
     * @param array<string, mixed> $defaultContext
     */
    public function __construct(
        protected string $baseUri,
        protected array $defaultContext = [],
        ?HttpClientInterface $httpClient = null,
        ?RequestFactoryInterface $requestFactory = null,
        ?StreamFactoryInterface $streamFactory = null,
        ?ValidatorInterface $validator = null,
        ?SerializerInterface $serializer = null,
    ) {
        $this->baseUri = rtrim($baseUri, '/');
        $this->httpClient = $httpClient ?? Psr18ClientDiscovery::find();
        $this->requestFactory = $requestFactory ?? Psr17FactoryDiscovery::findRequestFactory();
        $this->streamFactory = $streamFactory ?? Psr17FactoryDiscovery::findStreamFactory();
        $this->validator = $validator ?? static::createDefaultValidator();
        $this->serializer = $serializer ?? static::createDefaultSerializer();
    }

    public function query(QueryInterface $query): ResultInterface
    {
        $query = (clone $query)->withBaseUri($this->baseUri)->withContext($this->defaultContext);

        try {
            return $this->serializer->deserialize(
                (string) $this->httpClient->sendRequest($this->makeRequest($query))->getBody(),
                $query->getResultType(),
                $query->getContext(),
            );
        } catch (ClientExceptionInterface $e) {
            throw new ClientException('Query failed.', $e->getCode(), $e);
        }
    }

    /**
     * @template TResult of ResultInterface
     * @template TQuery of QueryInterface<TResult>
     *
     * @phpstan-param TQuery $query
     */
    protected function makeRequest(QueryInterface $query): RequestInterface
    {
        return $this->prepareRequest(
            $query->getEndpoint(),
            $query->getMethod(),
            $query->getHeaders(),
            $this->serializer->serialize($this->validate($query->getPayload()), $query->getContext())
        );
    }

    /**
     * @template T
     *
     * @param T $entity
     *
     * @return T
     */
    protected function validate(mixed $entity): mixed
    {
        $violations = $this->validator->validate($entity);

        if (count($violations)) {
            throw new ValidationFailedException($entity, $violations);
        }

        return $entity;
    }

    /**
     * @param array<string, string>        $headers
     * @param array<string, string>|string $body
     */
    protected function prepareRequest(string $endpoint, string $method = 'GET', array $headers = [], array|string $body = ''): RequestInterface
    {
        $request = $this->requestFactory->createRequest($method, "$this->baseUri/$endpoint");

        foreach ($headers as $header => $value) {
            $request = $request->withHeader($header, $value);
        }

        if ($body) {
            $stream = $this->streamFactory->createStream(is_array($body) ? http_build_query($body) : $body);
            $request = $request->withBody($stream);
        }

        return $request;
    }

    protected static function createDefaultSerializer(): SerializerInterface
    {
        return new SerializerWrapper(new Serializer(
            [new BackedEnumNormalizer, new DateTimeNormalizer, new ArrayDenormalizer, new PropertyNormalizer],
            [new JsonEncoder]
        ));
    }

    protected static function createDefaultValidator(): ValidatorInterface
    {
        return Validation::createValidatorBuilder()->enableAttributeMapping()->getValidator();
    }
}
