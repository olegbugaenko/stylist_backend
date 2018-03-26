<?php

use Illuminate\Database\Seeder;

use Illuminate\Database\Eloquent\Model;

use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        Model::unguard();

        DB::table('services')->delete();

        /*$users = array(
                ['name' => 'Ryan', 'last_name'=>'Chenkie', 'email' => 'ryanchenkie@gmail.com', 'password' => Hash::make('secret'),'salon_name'=>'Salon 1', 'salon_address'=>'Addr1','phonenumber'=>'+380987891020'],
                ['name' => 'Chris','last_name'=>'Sevilleja', 'email' => 'chris@scotch.io', 'password' => Hash::make('secret'),'salon_name'=>'Salon 1', 'salon_address'=>'Addr1','phonenumber'=>'+380987891026'],
                ['name' => 'Holly','last_name'=>'Lloyd', 'email' => 'holly@scotch.io', 'password' => Hash::make('secret'),'salon_name'=>'Salon 1', 'salon_address'=>'Addr1','phonenumber'=>'+380987891027'],
                ['name' => 'Adnan','last_name'=>'Kukic', 'email' => 'adnan@scotch.io', 'password' => Hash::make('secret'),'salon_name'=>'Salon 1', 'salon_address'=>'Addr1','phonenumber'=>'+380987891028'],
                ['name' => 'Oleh', 'last_name'=>'Buhajenko', 'email' => 'olegbugaenko@gmail.com', 'password' => Hash::make('12345678'),'salon_name'=>'Salon 1', 'salon_address'=>'Addr1','phonenumber'=>'+380987891029'],
        );*/

        // Loop through each user above and create the record for them in the database
        /*foreach ($users as $user)
        {
            User::create($user);
        }*/

        $services = [];

        for($i=0;$i<1000;$i++)
        {
            array_push($services, ['service_name'=>'Service '.$i]);
        }

        foreach ($services as $service_data) 
        {
            $service = App\Service::create($service_data);
        }

        //for($iu = 12)

        Model::reguard();
    }
}
