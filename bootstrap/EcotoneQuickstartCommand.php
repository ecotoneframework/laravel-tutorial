<?php

namespace Bootstrap;

use App\EcotoneQuickstart;
use Illuminate\Console\Command;

class EcotoneQuickstartCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ecotone:quickstart';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs Ecotone Laravel test command';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(EcotoneQuickstart $ecotoneQuickstart)
    {
        $this->output->writeln("<comment>Running example...</comment>");
        $ecotoneQuickstart->run();
        $this->output->writeln("\n<info>Good job, scenario ran with success!</info>");

        return 0;
    }
}