<?php

namespace App\Console\Commands;

use Cache;
use Illuminate\Console\Command;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

class TestPrepare extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:prepare';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Resets the database and inserts dummy data to the database for testing in local environment";

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->output->getFormatter()->setStyle('info', new OutputFormatterStyle('red'));

        if ($this->confirm("Are you sure ?")) {
            $this->output->getFormatter()->setStyle('info', new OutputFormatterStyle('blue'));

            $this->resetDatabase();
            $this->insertDummyData();
        }
    }

    private function resetDatabase()
    {
        $this->info('Resetting Database...');

        $this->info('Dropping tables and views...');
        $this->call('migrate:fresh', [
            '--drop-views' => 'default'
        ]);

        $this->info('Flusing Cache...');
        Cache::flush();

        $this->info('Migrating tables...');
        $this->call('migrate');

        $this->info('Creating tokens for laravel passport...\n');
        $this->call('passport:client', ['--personal' => true, '--name' => config('app.name') . ' Personal Access Client']);
        $this->call('passport:client', ['--password' => true, '--name' => config('app.name') . ' Password Grant Client']);

        $this->output->getFormatter()->setStyle('info', new OutputFormatterStyle('green'));
        $this->info('Resetting database complete!!');
    }

    private function insertDummyData()
    {
        $this->comment("\nInserting dummy data...\n");

        $totalProcesses = 2;

        $bar = $this->output->createProgressBar($totalProcesses);
        $bar->start();

        $this->comment(" -> Inserting dummy user");

        factory(\App\Models\User::class)->create([
            'email' => 'user@example.test',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);

        $bar->advance();
        $bar->display();

        $this->comment(" -> Inserting dummy cars");

        factory(\App\Models\Car::class, 50)->create();

        $bar->advance();
        $bar->display();

        $bar->finish();

        $this->comment(" -> All dummy data inserted completely!!");
    }
}


