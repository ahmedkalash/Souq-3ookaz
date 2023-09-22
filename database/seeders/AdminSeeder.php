<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::transaction(function (){
            $admin = User::query()->create([
                'first_name'=>'ahmed',
                'last_name'=>'kalash',
                'email'=>'kalash@admin.com',
                'password'=>Hash::make('ahmed')
            ]);
            $admin->assignRole('super-admin');
        });

    }
}
