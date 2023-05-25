<?php

namespace Singlephon\Nodelink\Service\Intentions;

abstract class Insertion extends CommonStatus implements InsertionInterface
{

    protected array $successful = [];
    protected array $data = [];
    protected array $errors = [];

    public function __construct(Request $data)
    {
        $this->setData($data->validated);
        $this->updateOrCreate();
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getSuccessful(): array
    {
        return $this->successful;
    }

    public function setSuccessful(string $model, array $info): void
    {
        $this->successful[] = [
            'message' => 'Successfully updated/created',
            'model' => $model,
            'data' => $info
        ];
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    public function setError(string $message, string $model, array $resource, string $code = '0001'): void
    {
        $this->errors[] = [
            'error' => 'Insertion error',
            'code' => $code,
            'message' => $message,
            'insertion' => [
                'model' => $model,
                'resource' => array_merge(...$resource)
            ]
        ];
    }



    abstract public function updateOrCreate(): static;
}
