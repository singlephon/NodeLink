<?php

namespace Singlephon\Nodelink\Commands;

use Singlephon\Nodelink\Service\Intentions\Version;

class ServiceRequestStub extends StubMaker
{
    protected string $belongs = 'ServiceRequest';

    public function __construct(protected string $name, private string $version)
    {
        parent::__construct('NodeLink', 'Requests/V' . Version::toDirectory($version), 'createservicerequest.stub');
    }

    public function replacements(): array
    {
        return [
            '{{ name }}' => $this->name,
            '{{ version }}' => Version::toDirectory($this->version),
        ];
    }
}
