<?php

namespace Jensramakers\LaravelMakeCrud\app\Console\Commands;

use Illuminate\Console\Command;

class MakeClass extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:class {classname}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new class file';

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
        $name = $this->argument('classname');
        if (!file_exists('app/Classes')) {
            mkdir('app/Classes', 0777, true);
        }
        if (!file_exists('app/Classes/'.$name.'.php')) {
            file_put_contents('app/Classes/'.$name.'.php', '<?php
namespace App\Classes;

class '.$name.'
{
    public function __construct()
    {
    }
}');
            $this->info('Class '.$this->argument('classname').' created successfully.');
        } else {
            $this->error('File already exists!');
        }
    }
}
