<?php

namespace AliQasemzadeh\JetAdmin\Console\Commands\Install;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;
use Symfony\Component\Console\Output\NullOutput;
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

        $this->callSilent('storage:link');

        $this->configureSession();

        (new Filesystem)->ensureDirectoryExists(resource_path('favicon'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../resources/favicon', resource_path('favicon'));

        (new Filesystem)->ensureDirectoryExists(resource_path('images'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../resources/images', resource_path('images'));

        (new Filesystem)->ensureDirectoryExists(resource_path('js'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../resources/js', resource_path('js'));

        (new Filesystem)->ensureDirectoryExists(resource_path('sass'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../resources/sass', resource_path('sass'));

        (new Filesystem)->ensureDirectoryExists(resource_path('views/api'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../resources/views/api', resource_path('views/api'));

        (new Filesystem)->ensureDirectoryExists(resource_path('views/auth'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../resources/views/auth', resource_path('views/auth'));

        (new Filesystem)->ensureDirectoryExists(resource_path('views/profile'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../resources/views/profile', resource_path('views/profile'));

        (new Filesystem)->ensureDirectoryExists(resource_path('views/layouts/custom'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../resources/views/layouts/custom', resource_path('views/layouts/custom'));

        copy(base_path('/vendor/aliqasemzadeh/jetadmin/resources/stubs/vite.config.js') , base_path('vite.config.js'));
        copy(base_path('/vendor/aliqasemzadeh/jetadmin/resources/stubs/package.json') , base_path('package.json'));

        return Command::SUCCESS;
    }

    /**
     * Configure the session driver for Jetstream.
     *
     * @return void
     */
    protected function configureSession()
    {
        if (! class_exists('CreateSessionsTable')) {
            try {
                $this->call('session:table');
            } catch (Exception $e) {
                //
            }
        }

        $this->replaceInFile("'SESSION_DRIVER', 'file'", "'SESSION_DRIVER', 'database'", config_path('session.php'));
        $this->replaceInFile('SESSION_DRIVER=file', 'SESSION_DRIVER=database', base_path('.env'));
        $this->replaceInFile('SESSION_DRIVER=file', 'SESSION_DRIVER=database', base_path('.env.example'));
    }

    /**
     * Replace a given string within a given file.
     *
     * @param  string  $search
     * @param  string  $replace
     * @param  string  $path
     * @return void
     */
    protected function replaceInFile($search, $replace, $path)
    {
        file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
    }


}
