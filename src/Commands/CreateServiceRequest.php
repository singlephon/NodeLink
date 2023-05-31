<?php

namespace Singlephon\Nodelink\Commands;

use Illuminate\Support\Facades\File;
use Singlephon\Nodelink\Service\Intentions\Version;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class CreateServiceRequest
{
    protected string $requestFolder = 'App/NodeLink/Requests';
    public function __construct(private string $name, private ?string $version = null)
    {
        $this->version = $this->version ?? env('NODELINK_SERVICE_APP_VERSION');
        $this->path = $this->requestFolder . '/V' . Version::toDirectory($this->version);
        if (!File::exists($this->path))
        {
            File::makeDirectory($this->path, 0777, true);
        }
    }

    public function makeFile ()
    {
        $file = $this->path . '/' . $this->name . 'ServiceRequest.php';
        if (!File::exists($file))
        {
            (new ServiceRequestStub($this->name, $this->version))->make();
            return File::exists($file);
        }
        else throw (new FileException("File $file already exist"));
    }
}
