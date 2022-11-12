<?php

namespace Jensramakers\LaravelMakeCrud\app\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AssignRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role:assign';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'set role to user';

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
        $roles = DB::table('roles')->get();

        $roleNames = [];
        foreach ($roles as $role) {
            $roleNames[] = $role->name;
        }
        if (empty($roleNames)) {
            $this->error('no roles to choose from, add some roles to database first');

            return 0;
        }

        $userEmailLike = $this->ask('user email');
        $users = User::where('email', 'like', '%'.$userEmailLike.'%')->get('email')->pluck('email')->toArray();

        $useremail = $this->choice('email', $users);
        $rolename = $this->choice('role name', $roleNames);

        $user = User::firstWhere('email', $useremail);
        if (!$user) {
            $this->error('no user found with email: '.$useremail);

            return 0;
        }

        try {
            $user->assignRole($rolename);
            $this->info('Role '.$rolename.' set to user '.$user->email);
        } catch (\Exception $exception) {
            $this->error('no role named '.$rolename);
        }

        return 0;
    }
}
