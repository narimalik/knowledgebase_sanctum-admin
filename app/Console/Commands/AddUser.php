<?php

namespace App\Console\Commands;

use App\Http\Controllers\UserController;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Http\Request;

class AddUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a user with email, password and get token back';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->ask('Enter full name: ');
        $username = $this->ask('Enter user name: ');
        $email = $this->ask('Enter user email: ');
        $password = $this->ask('Enter password: ');
        $password_confirmation = $this->ask('Enter re-password: ');

        # $this->info('You entered name: '.$name.' , '.'Email: '.$email. ' , '. 'Password : '. $password);

        $userController = new UserController();
        $reqest = new Request([
            'name' => $name,
            'email' => $email,
            'username' => $username,
            'password' => $password,
            'password_confirmation' =>$password_confirmation]);

            try{
                $user = $userController->register($reqest);
                $this->info("User Created!");
                print($user);
            }
            catch(Exception $e){
                print($e->getMessage());
            }
            

    }
}
