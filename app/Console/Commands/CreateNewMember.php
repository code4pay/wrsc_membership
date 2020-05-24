<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateNewMember extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wrsc:member
                            {--F|firstName= : The first name of the new user}
                            {--L|lastName= : The last name of the new user}
                            {--M|member_number= : The user\'s member Number}
                            {--P|password= : User\'s password}
                            {--encrypt=true : Encrypt user\'s password if it\'s plain text ( true by default )}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Creating a new user');

        if (! $first_name = $this->option('firstName')) {
            $first_name = $this->ask('First Name');
        }
        if (! $last_name = $this->option('lastName')) {
            $last_name = $this->ask('Last Name');
        }

        if (! $email = $this->option('member_number')) {
            $member_number = $this->ask('Member Number');
        }

        if (! $password = $this->option('password')) {
            $password = $this->secret('Password');
        }

        if ($this->option('encrypt')) {
            $password = bcrypt($password);
        }

        $auth = config('backpack.base.user_model_fqn', 'App\User');
        $user = new $auth();
        $user->first_name = $first_name;
        $user->last_name = $last_name;
        $user->member_number= $member_number;
        $user->password = $password;

        if ($user->save()) {
            $this->info('Successfully created new user');
        } else {
            $this->error('Something went wrong trying to save your user');
        }
    }
}
