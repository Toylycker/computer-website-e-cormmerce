<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $obj = new User();
        $obj->name = 'Manager';
        $obj->username = 'admin';
        $obj->password = bcrypt('admin123');
        $obj->save();
    }
}
