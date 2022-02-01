<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Filesystem\Filesystem;

class EcommerceInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ecommerce:install {--force : Proceed without asking for user confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install dummy data for the application';

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
     * @return int
     */
    public function handle()
    {
        if ($this->option('force')) {
            $this->proceed();
        } else {
            if ($this->confirm('This will delete all your current data and install the default dummy data. Are you sure?')) {
                $this->proceed();
            }
        }
    }

    protected function proceed()
    {
        File::deleteDirectory(public_path('images/basic'));

        $filesystem = new Filesystem;
        $filesystem->cleanDirectory(public_path('images/products'));
        $filesystem->cleanDirectory(public_path('images/users'));


        $this->info('Installing dummy data...');

        $copySuccess = File::copyDirectory(public_path('images/basic_dummy'), public_path('images/basic'));
        if ($copySuccess) {
            $this->info('Default Images copied successfully.');
        }

        $this->call('migrate:fresh', [
            '--seed' => true
        ]);

        $this->info('Finished.');
    }
}
