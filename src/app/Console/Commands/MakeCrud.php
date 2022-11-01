<?php

namespace Jensramakers\LaravelMakeCrud\app\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Pluralizer;

class MakeCrud extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:crud';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'make controller model migration request and route';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->ask('model name');

        if (!file_exists(base_path().'/routes/crud.php')) {
            file_put_contents(base_path().'/routes/crud.php', "<?php

use Illuminate\Support\Facades\Route;

/*
 * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
 * WARNING DO NOT EDIT MANUALLY THIS WILL BE GENERATED AND CHANGED DYNAMICALLY AUTOMATICALLY
 * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
 */
Route::prefix('/admin')->name('admin.')->group(function () {
});");
        }

        $contents = file_get_contents(base_path().'/routes/crud.php');

        $kebabCasePlural = Pluralizer::plural($this->camelCaseToKebabCase($name));
        $pluralName = Pluralizer::plural($name);
        $varName = lcfirst($name);
        $varNamePlural = Pluralizer::plural($varName);
        $snakeCase = $this->camelCaseToSnakeCase($name);
        $snakeCasePlural = Pluralizer::plural($snakeCase);

        $controllerNameSpace = 'App\Http\Controllers\Admin';
        $modelNameSpace = 'App\Models\Admin\\'.$name;
        $requestNameSpace = 'App\Http\Requests';
        $controllerDir = 'app/Http/Controllers/Admin';

        $route = "Route::resource('$kebabCasePlural', \\$controllerNameSpace\\".$name."Controller::class)->except(['show'])->parameters(['$kebabCasePlural' => '$varName']);";
        $result = $this->StrReplaceLastOccurrence('});', "\x20\x20\x20\x20".$route.PHP_EOL.'});', $contents);
        file_put_contents(base_path().'/routes/crud.php', $result);

        Artisan::call('make:model Admin/'.$name.' -m');
        $this->info('Model and Migration created successfully');
        Artisan::call('make:request Store'.$name.'Request');
        $this->info('Store'.$name.'Request created successfully');
        Artisan::call('make:request Update'.$name.'Request');
        $this->info('Update'.$name.'Request created successfully');

        $this->makeController($kebabCasePlural, $controllerNameSpace, $modelNameSpace, $requestNameSpace, $name, $varName, $varNamePlural, $controllerDir, $snakeCasePlural, $pluralName);
        $this->makeViewIndex($kebabCasePlural, $pluralName, $varName, $varNamePlural, $snakeCasePlural);
        $this->makeViewCreate($kebabCasePlural, $varName, $varNamePlural, $snakeCasePlural, $snakeCase);
        $this->makeViewEdit($kebabCasePlural, $varName, $varNamePlural, $snakeCasePlural, $snakeCase);

        return 0;
    }

    public function makeViewIndex($kebabCasePlural, $pluralName, $varName, $varNamePlural, $snakeCasePlural)
    {
        $contents = file_get_contents(base_path().'/stubs/view.index.stub');
        $contents = str_replace('{{{ pluralName }}}', $pluralName, $contents);
        $contents = str_replace('{{{ varName }}}', $varName, $contents);
        $contents = str_replace('{{{ varNamePlural }}}', $varNamePlural, $contents);
        $contents = str_replace('{{{ snakeCasePlural }}}', $snakeCasePlural, $contents);
        $contents = str_replace('{{{ kebabCasePlural }}}', $kebabCasePlural, $contents);
        if (!file_exists(base_path().'/resources/views/admin')) {
            mkdir(base_path().'/resources/views/admin', 0777, true);
        }
        if (!file_exists(base_path().'/resources/views/admin/'.$snakeCasePlural.'.blade.php')) {
            file_put_contents(base_path().'/resources/views/admin/'.$snakeCasePlural.'.blade.php', $contents);
            $this->info($snakeCasePlural.'.blade.php created successfully');
        } else {
            $this->error($snakeCasePlural.'.blade.php already exists!');
        }
    }

    public function makeViewCreate($kebabCasePlural, $varName, $varNamePlural, $snakeCasePlural, $snakeCase)
    {
        $contents = file_get_contents(base_path().'/stubs/view.create.stub');
        $contents = str_replace('{{{ varName }}}', $varName, $contents);
        $contents = str_replace('{{{ varNamePlural }}}', $varNamePlural, $contents);
        $contents = str_replace('{{{ snakeCase }}}', $snakeCase, $contents);
        $contents = str_replace('{{{ kebabCasePlural }}}', $kebabCasePlural, $contents);
        if (!file_exists(base_path().'/resources/views/admin')) {
            mkdir(base_path().'/resources/views/admin', 0777, true);
        }
        if (!file_exists(base_path().'/resources/views/admin/'.$snakeCasePlural.'_create.blade.php')) {
            file_put_contents(base_path().'/resources/views/admin/'.$snakeCasePlural.'_create.blade.php', $contents);
            $this->info($snakeCasePlural.'_create.blade.php created successfully');
        } else {
            $this->error($snakeCasePlural.'_create.blade.php already exists!');
        }
    }

    public function makeViewEdit($kebabCasePlural, $varName, $varNamePlural, $snakeCasePlural, $snakeCase)
    {
        $contents = file_get_contents(base_path().'/stubs/view.edit.stub');
        $contents = str_replace('{{{ varName }}}', $varName, $contents);
        $contents = str_replace('{{{ varNamePlural }}}', $varNamePlural, $contents);
        $contents = str_replace('{{{ snakeCase }}}', $snakeCase, $contents);
        $contents = str_replace('{{{ kebabCasePlural }}}', $kebabCasePlural, $contents);
        if (!file_exists('resources/views/admin')) {
            mkdir('resources/views/admin', 0777, true);
        }
        if (!file_exists(base_path().'/resources/views/admin/'.$snakeCasePlural.'_edit.blade.php')) {
            file_put_contents(base_path().'/resources/views/admin/'.$snakeCasePlural.'_edit.blade.php', $contents);
            $this->info($snakeCasePlural.'_edit.blade.php created successfully');
        } else {
            $this->error($snakeCasePlural.'_edit.blade.php already exists!');
        }
    }

    public function makeController($kebabCasePlural, $controllerNameSpace, $modelNameSpace, $requestNameSpace, $name, $varName, $varNamePlural, $controllerDir, $snakeCasePlural, $pluralName)
    {
        $contents = file_get_contents(base_path().'/stubs/custom.controller.model.stub');
        $contents = str_replace('{{{ namespace }}}', $controllerNameSpace, $contents);
        $contents = str_replace('{{{ namespacedModel }}}', $modelNameSpace, $contents);
        $contents = str_replace('{{{ namespacedRequests }}}', $requestNameSpace, $contents);
        $contents = str_replace('{{{ name }}}', $name, $contents);
        $contents = str_replace('{{{ varName }}}', $varName, $contents);
        $contents = str_replace('{{{ varNamePlural }}}', $varNamePlural, $contents);
        $contents = str_replace('{{{ snakeCasePlural }}}', $snakeCasePlural, $contents);
        $contents = str_replace('{{{ kebabCasePlural }}}', $kebabCasePlural, $contents);
        if (!file_exists($controllerDir)) {
            mkdir($controllerDir, 0777, true);
        }
        if (!file_exists($controllerDir.'/'.$name.'Controller.php')) {
            file_put_contents($controllerDir.'/'.$name.'Controller.php', $contents);
            $this->info($name.'Controller created successfully');
        } else {
            $this->error($name.'Controller already exists!');
        }
    }

    public function camelCaseToSnakeCase($input): string
    {
        return ltrim(strtolower(preg_replace('/[A-Z]([A-Z](?![a-z]))*/', '_$0', $input)), '_');
    }

    public function camelCaseToKebabCase($input): string
    {
        return ltrim(strtolower(preg_replace('/[A-Z]([A-Z](?![a-z]))*/', '-$0', $input)), '-');
    }

    public function StrReplaceLastOccurrence($search, $replace, $subject)
    {
        $pos = strrpos($subject, $search);

        if ($pos !== false) {
            $subject = substr_replace($subject, $replace, $pos, strlen($search));
        }

        return $subject;
    }
}
