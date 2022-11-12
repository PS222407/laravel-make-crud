<?php

namespace Jensramakers\LaravelMakeCrud\app\Console\Commands;

use Illuminate\Console\Command;

class MakeEnum extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:enum {enumname}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new enum file';

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
        $name = $this->argument('enumname');
        if (!file_exists('app/Enums')) {
            mkdir('app/Enums', 0777, true);
        }
        if (!file_exists('app/Enums/'.$name.'.php')) {
            file_put_contents('app/Enums/'.$name.'.php', '<?php'.PHP_EOL.PHP_EOL.'namespace App\Enums;'.PHP_EOL.PHP_EOL.'enum '.$name.': int {'.PHP_EOL."\tcase FALSE = 0;".PHP_EOL."\tcase TRUE = 1;".PHP_EOL.'}');
            $this->info('Enum '.$this->argument('enumname').' created successfully.');
        } else {
            $this->error('File already exists!');
        }
    }
}
