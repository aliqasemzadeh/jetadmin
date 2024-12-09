<?php

namespace AliQasemzadeh\JetAdmin\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use function Laravel\Prompts\confirm;

class InstallCommand extends Command
{
    protected $signature = 'jetadmin:install';

    protected $description = 'Install the JetAdmin components and resources';

    public function handle(): void
    {
        // Node and Assets Configuration...
        copy(__DIR__.'/../../stubs/package.json', base_path('package.json'));
        copy(__DIR__.'/../../stubs/tailwind.config.js', base_path('tailwind.config.js'));
        copy(__DIR__.'/../../stubs/postcss.config.js', base_path('postcss.config.js'));
        copy(__DIR__.'/../../stubs/vite.config.js', base_path('vite.config.js'));

        $this->runDatabaseMigrations();

        $this->components->info('JetAdmin scaffolding installed successfully.');

    }

    /**
     * Run the database migrations.
     *
     * @return void
     */
    protected function runDatabaseMigrations()
    {
        if (confirm('New database migrations were added. Would you like to re-run your migrations?', true)) {
            (new Process([$this->phpBinary(), 'artisan', 'migrate:fresh', '--force'], base_path()))
                ->setTimeout(null)
                ->run(function ($type, $output) {
                    $this->output->write($output);
                });
        }
    }
}
