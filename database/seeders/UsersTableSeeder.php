<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('users')->insert([
            'name'=> 'Abdelmonem Mohmed' ,
            'email'=> 'abdelmeenam@gmail.com' ,
            'password' =>Hash::make('password'),
            'created_at'=>now(),
            'updated_at'=>now(),
        ]);
    }
}
