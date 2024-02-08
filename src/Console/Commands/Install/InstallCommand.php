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
        (new Filesystem)->copyDirectory(base_path('/vendor/aliqasemzadeh/jetadmin/resources/favicon'), resource_path('favicon'));

        (new Filesystem)->ensureDirectoryExists(resource_path('images'));
        (new Filesystem)->copyDirectory(base_path('/vendor/aliqasemzadeh/jetadmin/resources/images'), resource_path('images'));

        (new Filesystem)->ensureDirectoryExists(resource_path('js'));
        (new Filesystem)->copyDirectory(base_path('/vendor/aliqasemzadeh/jetadmin/resources/js'), resource_path('js'));

        (new Filesystem)->ensureDirectoryExists(resource_path('scss'));
        (new Filesystem)->copyDirectory(base_path('/vendor/aliqasemzadeh/jetadmin/resources/scss'), resource_path('scss'));

        (new Filesystem)->ensureDirectoryExists(resource_path('views/api'));
        (new Filesystem)->copyDirectory(base_path('/vendor/aliqasemzadeh/jetadmin/resources/views/api'), resource_path('views/api'));

        (new Filesystem)->ensureDirectoryExists(resource_path('views/auth'));
        (new Filesystem)->copyDirectory(base_path('/vendor/aliqasemzadeh/jetadmin/resources/views/auth'), resource_path('views/auth'));

        (new Filesystem)->ensureDirectoryExists(resource_path('views/profile'));
        (new Filesystem)->copyDirectory(base_path('/vendor/aliqasemzadeh/jetadmin/resources/views/profile'), resource_path('views/profile'));

        (new Filesystem)->ensureDirectoryExists(resource_path('views/layouts/custom'));
        (new Filesystem)->copyDirectory(base_path('/vendor/aliqasemzadeh/jetadmin/resources/views/layouts/custom'), resource_path('views/layouts/custom'));

        // Webpack Resources
        copy(base_path('/vendor/aliqasemzadeh/jetadmin/resources/webpack/package.json') , base_path('package.json'));
        copy(base_path('/vendor/aliqasemzadeh/jetadmin/resources/webpack/webpack.config.js') , base_path('webpack.config.js'));
        copy(base_path('/vendor/aliqasemzadeh/jetadmin/resources/webpack/webpack.mix.js') , base_path('webpack.mix.js'));

        return Command::SUCCESS;
    }

    /**
     * Configure the session driver for Jetstream.
     *
     * @return void
     */
    protected function configureSession()
    {
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

    /**
     * Install the middleware to a group in the application Http Kernel.
     *
     * @param  string  $after
     * @param  string  $name
     * @param  string  $group
     * @return void
     */
    protected function installMiddlewareAfter($after, $name, $group = 'web')
    {
        $httpKernel = file_get_contents(app_path('Http/Kernel.php'));

        $middlewareGroups = Str::before(Str::after($httpKernel, '$middlewareGroups = ['), '];');
        $middlewareGroup = Str::before(Str::after($middlewareGroups, "'$group' => ["), '],');

        if (! Str::contains($middlewareGroup, $name)) {
            $modifiedMiddlewareGroup = str_replace(
                $after.',',
                $after.','.PHP_EOL.'            '.$name.',',
                $middlewareGroup,
            );

            file_put_contents(app_path('Http/Kernel.php'), str_replace(
                $middlewareGroups,
                str_replace($middlewareGroup, $modifiedMiddlewareGroup, $middlewareGroups),
                $httpKernel
            ));
        }
    }

}
