<?php

namespace Singlephon\Nodelink\Commands;

use Illuminate\Console\Command;
use Singlephon\Nodelink\Common\Query\RegisterApplication;
use Singlephon\Nodelink\Service\Intentions\Common;
use Symfony\Component\Console\Output\ConsoleOutput;

class RegisterNodeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nodelink:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Register application to CoreLink (Only once)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $output = new ConsoleOutput();
        $req = Common::post(RegisterApplication::class, 'register');
    }
}
