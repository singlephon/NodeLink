<?php

namespace Singlephon\Nodelink;

use Illuminate\Http\Request;
use Symfony\Component\Console\Output\ConsoleOutput;

class NodelinkRegister
{
    public static function init(Request $request)
    {
        $output = new ConsoleOutput();
        $output->writeln($request);
        return response()->json(['sad' => 'nice']);
    }
}
