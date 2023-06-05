<?php

namespace AliQasemzadeh\JetAdmin\Console\Commands\Install;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use RuntimeException;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Process\PhpExecutableFinder;
use Symfony\Component\Process\Process;

class InstallCommand extends Command
{
    protected $signature = "jetadmin:install";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the JetAdmin components and resources';

    /**
     * Execute the console command.
     *
     * @return int|null
     */
    public function handle()
    {

    }
}
