<?php

namespace App\Console\Commands;

use App\User;
use RuntimeException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateAdminUser extends Command
{
    /**
     * @var string
     */
    protected $signature = 'admin:create';

    /**
     * @var string
     */
    protected $description = 'Create admin user.';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     *
     */
    public function handle()
    {
        $name = $this->ask('Enter name:');
        $email = $this->ask('Enter email:');
        $password = $this->secret('Enter password(min: 8 symbols):');

        $data = [
            'name'     => $name,
            'email'    => $email,
            'password' => $password,
        ];

        if ( $this->validator($data) ) {
            $this->info('New admin user created.');
        } else {
            $this->error('Error ');
        }
    }

    protected function validator(array $data)
    {
        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if (!$validator->passes()) {
            throw new RuntimeException($validator->errors()->first());
        }

        return $this->create($data);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'is_admin' => true
        ]);
    }
}
