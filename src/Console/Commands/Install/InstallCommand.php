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
        (new Filesystem)->ensureDirectoryExists(resource_path('views'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/default/resources/views/api', resource_path('views'));

        copy(__DIR__.'/../../stubs/vite.config.js', base_path('vite.config.js'));
        copy(__DIR__.'/../../stubs/package.json', base_path('package.json'));
    }
}
