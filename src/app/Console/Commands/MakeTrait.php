<?php

namespace Jensramakers\LaravelMakeCrud\app\Console\Commands;

use Illuminate\Console\Command;

class MakeTrait extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:trait {traitname}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new trait file';

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
        $name = $this->argument('traitname');
        if (!file_exists('app/Traits')) {
            mkdir('app/Traits', 0777, true);
        }
        if (!file_exists('app/Traits/'.$name.'.php')) {
            file_put_contents('app/Traits/'.$name.'.php', '<?php

namespace App\Traits;

trait '.$name.'
{
    public static function someStaticFunction()
    {

    }
}');
            $this->info('Trait '.$this->argument('traitname').' created successfully.');
        } else {
            $this->error('File already exists!');
        }
    }
}
