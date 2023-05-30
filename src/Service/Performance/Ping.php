<?php

namespace Singlephon\Nodelink\Service\Performance;

use Illuminate\Http\Request;
use Symfony\Component\Console\Output\ConsoleOutput;

class Ping
{

    /**
     * Simple ping pong response to Corelink
     * @param Request $request
     * @return bool
     */
    public function pong(): bool
    {
        return true;
    }

    /**
     * Primary test of application accessing by Corelink
     * @return bool
     */
    public function primary(): bool
    {
        /** TODO: Test necessary features */
        return true;
    }

    /**
     * Test of application (Unit, Feature, etc.)
     * @return bool
     */
    public function complex(): bool
    {
        return true;
    }

}
