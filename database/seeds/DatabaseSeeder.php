<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        DB::table('departments')->insert([
            ['department' => 'IT'],
            ['department' => 'Accounting'],
            ['department' => 'Engineering']
        ]);

        DB::table('positions')->insert([
            ['position' => 'Web Developer','department_id' => 1],
            ['position' => 'Accountant','department_id' => 2],
            ['position' => 'Surveyor','department_id' => 3],
            ['position' => 'Support','department_id' => 1],
            ['position' => 'Technical','department_id' => 1]
        ]);

        DB::table('roles')->insert([
            ['role' => '1st Level Support'],
            ['role' => 'Tower'],
            ['role' => 'User'],
            ['role' => 'Admin']
        ]);

        DB::table('ticket_types')->insert([
            ['name' => 'Incident'],
            ['name' => 'Request'],
        ]);

        DB::table('priorities')->insert([
            ['name' => 'Low','order' => 1],
            ['name' => 'Normal','order' => 2],
            ['name' => 'High','order' => 3],
            ['name' => 'Urgent','order' => 4],
        ]);

        DB::table('categories')->insert([
            ['name' => 'Hardware'],
            ['name' => 'Software'],
        ]);

        DB::table('category_a')->insert([
            ['name' => 'POS'],
            ['name' => 'Server'],
            ['name' => 'RoyTech'],
            ['name' => 'Installations'],
            ['name' => 'EBS'],
            ['name' => 'Connection'],
        ]);

        DB::table('category_b')->insert([
            ['name' => 'Error','catA_id' => 1],
            ['name' => 'Price and Promotions','catA_id' => 3],
            ['name' => 'Voice','catA_id' => 6],
            ['name' => 'Network/Sync Issues','catA_id' => 2],
            ['name' => 'BM Server','catA_id' => 4],
            ['name' => 'Improcurement','catA_id' => 5],
        ]);

        DB::table('resolve_categories')->insert([
            ['name' => 'Patches/Software Update'],
            ['name' => 'Data correction'],
            ['name' => 'Re-installation'],
            ['name' => 'Compact & Repair'],
            ['name' => 'Resend by Transaction'],
            ['name' => 'Proper Execution'],
        ]);


        DB::table('ticket_status')->insert([
            ['name' => 'Open'],
            ['name' => 'Ongoing'],
            ['name' => 'Closed'],
        ]);

        DB::table('contact_types')->insert([
            ['name' => 'Telephone'],
            ['name' => 'Cell'],
        ]);

        DB::table('stores')->insert([
            ['store_name' => 'Bajada'],
            ['store_name' => 'Liloan'],
            ['store_name' => 'Matina'],
            ['store_name' => 'Naval'],
            ['store_name' => 'Oton']
        ]);

        $this->call([
            ProfPicTableSeeder::class,
            ContactsTableSeeder::class,
            CallersTableSeeder::class,
//            ResolveTableSeeder::class,
            TicketTableSeeder::class,
//            MessageTableSeeder::class
        ]);

    }
}
