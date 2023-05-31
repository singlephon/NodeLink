<?php

namespace Singlephon\Nodelink\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class CreateServiceRequestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nodelink:make {name} {version?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a NodeLink request class(es)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $version = $this->argument('version');

        $serviceRequest = (new CreateServiceRequest($name, $version))->makeFile();
        $this->info($serviceRequest ? 'File created successfully' : 'Something went wrong');

        return CommandAlias::SUCCESS;
    }


}
