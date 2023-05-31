<?php

namespace Singlephon\Nodelink\Service\Intentions;

abstract class Request
{
    public ?array $raw;
    public array $validated;

    public function __construct(array $data)
    {
        $this->raw = $this->rawBindings($data);
        $this->validated = $this->getBindings($data);
    }


    /**
     * Remove nulls and explode each item in array on two arrays
     * First array is primary or unique keys defined as #key_name => value
     * Second is what should be updated or created
     * Each item in array can be used for Model::updateOrCreate()
     *
     * @param array $data
     * @return array
     */
    private function getBindings(array $data): array
    {
        return array_explode_special_character(
            array_remove_null( $this->bindings((object) $data) )
        );
    }

    protected function rawBindings (array $data): array
    {
        return $data;
    }

    /**
     * Define CoreLink requests to update or create by [Model::class => @(array for upsert)].
     *
     * For nullable fields add (@) before value
     *
     * Primary or unique keys must be defined as #key_name => value
     *
     * Bindings::class available for model interaction like get values from previous model
     *
     * @param object $data
     * @return array
     */
    abstract protected function bindings(object $data): array;
}
