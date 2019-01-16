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
            ['name' => 'Error','catA_id' => 1,'expiration' => 24],
            ['name' => 'Receipt printout','catA_id' => 1,'expiration' => 24],
            ['name' => 'Hardware','catA_id' => 1,'expiration' => 24],
            ['name' => 'Network/Sync','catA_id' => 1,'expiration' => 24],
            ['name' => 'License(POS)','catA_id' => 1,'expiration' => 24],
            ['name' => 'Virus/Malwares(POS)','catA_id' => 1,'expiration' => 24],
            ['name' => 'New Terminal','catA_id' => 1,'expiration' => 24],
            ['name' => 'User Access(POS)','catA_id' => 1,'expiration' => 48],
            ['name' => 'POS backup','catA_id' => 1,'expiration' => 24],
            ['name' => 'Price and Promotions','catA_id' => 3,'expiration' => 24],
            ['name' => 'Sales Reports','catA_id' => 3,'expiration' => 24],
            ['name' => 'Item Assignment','catA_id' => 3,'expiration' => 24],
            ['name' => 'Branch Agent/HQ Agent Error','catA_id' => 3,'expiration' => 24],
            ['name' => 'POS Agent Error','catA_id' => 3,'expiration' => 24],
            ['name' => 'User Access(RoyTec)','catA_id' => 3,'expiration' => 48],
            ['name' => 'Voice','catA_id' => 6,'expiration' => 72],
            ['name' => 'Data','catA_id' => 6,'expiration' => 72],
            ['name' => 'Both','catA_id' => 6,'expiration' => 72],
            ['name' => 'Network/Sync Issues','catA_id' => 2,'expiration' => 24],
            ['name' => 'Virus/Malwares(Server)','catA_id' => 2,'expiration' => 48],
            ['name' => 'Xampp control panel Issues','catA_id' => 2,'expiration' => 24],
            ['name' => 'BM Server Issues','catA_id' => 2,'expiration' => 24],
            ['name' => 'License(Server)','catA_id' => 2,'expiration' => 24],
            ['name' => 'Roytec Issues','catA_id' => 2,'expiration' => 24],
            ['name' => 'Server Backup (USB)','catA_id' => 2,'expiration' => 24],
            ['name' => 'EBS(PROD,UAT,DEV)','catA_id' => 4,'expiration' => 24],
            ['name' => 'BM Server','catA_id' => 4,'expiration' => 24],
            ['name' => 'Roytec','catA_id' => 4,'expiration' => 24],
            ['name' => 'POS','catA_id' => 4,'expiration' => 24],
            ['name' => 'POS Agent','catA_id' => 4,'expiration' => 24],
            ['name' => 'Branch Agent/HQ Agent','catA_id' => 4,'expiration' => 24],
            ['name' => 'Forticlient','catA_id' => 4,'expiration' => 48],
            ['name' => 'Improcurement','catA_id' => 5,'expiration' => 24],
            ['name' => 'Custom pages','catA_id' => 5,'expiration' => 24],
            ['name' => 'Inventory','catA_id' => 5,'expiration' => 24],
            ['name' => 'Order Management','catA_id' => 5,'expiration' => 24],
            ['name' => 'Purchasing','catA_id' => 5,'expiration' => 24],
            ['name' => 'LCM','catA_id' => 5,'expiration' => 24],
            ['name' => 'User Access(EBS)','catA_id' => 5,'expiration' => 48],
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
            ['name' => 'Fixed'],
            ['name' => 'Rejected']
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
        //    ProfPicTableSeeder::class,
            ContactsTableSeeder::class,
        //    CallersTableSeeder::class,
            //    ResolveTableSeeder::class,
        //    IncidentTableSeeder::class,
        //    TicketTableSeeder::class,
        //    MessageTableSeeder::class
        ]);

    }
}
