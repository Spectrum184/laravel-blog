<?php

use App\User;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'user01',
            'role_id' => 2,
            'name' => 'User01',
            'email' => 'user01@gmail.com',
            'password' => bcrypt('user01')
        ]);

        User::create([
            'username' => 'spectrum184',
            'role_id' => 1,
            'name' => 'Thanh Nguyen',
            'email' => 'nvthanh1804@gmail.com',
            'password' => bcrypt('thanh1804')
        ]);
    }
}
