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

//        DB::table('departments')->insert([
//            ['department' => 'IT'],
//            ['department' => 'Accounting'],
//            ['department' => 'Engineering']
//        ]);

        DB::table('ticket_groups')->insert([
            ['name' => 'Support'],
            ['name' => 'Technical'],
        ]);

//        DB::table('positions')->insert([
//            ['position' => 'Web Developer','department_id' => 1],
//            ['position' => 'Accountant','department_id' => 2],
//            ['position' => 'Surveyor','department_id' => 3],
//            ['position' => 'Support','department_id' => 1],
//            ['position' => 'Technical','department_id' => 1]
//        ]);

        DB::table('roles')->insert([
            ['role' => '1st Level Support'],
            ['role' => 'Tower'],
            ['role' => 'User'],
            ['role' => 'Admin'],
            ['role' => 'Treasury 1'],
            ['role' => 'Treasury 2'],
            ['role' => 'Gov. Compliance'],
            ['role' => 'Approver']
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
            ['name' => 'Connection']
        ]);

        DB::table('category_a')->insert([
            ['name' => 'POS'],
            ['name' => 'Server'],
            ['name' => 'RoyTech'],
            ['name' => 'Installations'],
            ['name' => 'EBS'],
            ['name' => 'Connection'],
        ]);

//        DB::table('stores')->insert([
//            ['store_name' => 'Bajada'],
//            ['store_name' => 'Liloan'],
//            ['store_name' => 'Matina'],
//            ['store_name' => 'Naval'],
//            ['store_name' => 'Oton']
//        ]);

        DB::table('expirations')->insert([
            ['expiration' => 24],
            ['expiration' => 48],
            ['expiration' => 72],
        ]);

        DB::table('category_b')->insert([
            ['name' => 'Error','catA_id' => 1,'expiration' => 1],
            ['name' => 'Receipt printout','catA_id' => 1,'expiration' => 1],
            ['name' => 'Hardware','catA_id' => 1,'expiration' => 1],
            ['name' => 'Network/Sync','catA_id' => 1,'expiration' => 1],
            ['name' => 'License(POS)','catA_id' => 1,'expiration' => 1],
            ['name' => 'Virus/Malwares(POS)','catA_id' => 1,'expiration' => 1],
            ['name' => 'New Terminal','catA_id' => 1,'expiration' => 1],
            ['name' => 'User Access(POS)','catA_id' => 1,'expiration' => 2],
            ['name' => 'POS backup','catA_id' => 1,'expiration' => 1],
            ['name' => 'Price and Promotions','catA_id' => 3,'expiration' => 1],
            ['name' => 'Sales Reports','catA_id' => 3,'expiration' => 1],
            ['name' => 'Item Assignment','catA_id' => 3,'expiration' => 1],
            ['name' => 'Branch Agent/HQ Agent Error','catA_id' => 3,'expiration' => 1],
            ['name' => 'POS Agent Error','catA_id' => 3,'expiration' => 1],
            ['name' => 'User Access(RoyTec)','catA_id' => 3,'expiration' => 2],
            ['name' => 'Voice','catA_id' => 6,'expiration' => 3],
            ['name' => 'Data','catA_id' => 6,'expiration' => 3],
            ['name' => 'Both','catA_id' => 6,'expiration' => 3],
            ['name' => 'Network/Sync Issues','catA_id' => 2,'expiration' => 1],
            ['name' => 'Virus/Malwares(Server)','catA_id' => 2,'expiration' => 2],
            ['name' => 'Xampp control panel Issues','catA_id' => 2,'expiration' => 1],
            ['name' => 'BM Server Issues','catA_id' => 2,'expiration' => 1],
            ['name' => 'License(Server)','catA_id' => 2,'expiration' => 1],
            ['name' => 'Roytec Issues','catA_id' => 2,'expiration' => 1],
            ['name' => 'Server Backup (USB)','catA_id' => 2,'expiration' => 1],
            ['name' => 'EBS(PROD,UAT,DEV)','catA_id' => 4,'expiration' => 1],
            ['name' => 'BM Server','catA_id' => 4,'expiration' => 1],
            ['name' => 'Roytec','catA_id' => 4,'expiration' => 1],
            ['name' => 'POS','catA_id' => 4,'expiration' => 1],
            ['name' => 'POS Agent','catA_id' => 4,'expiration' => 1],
            ['name' => 'Branch Agent/HQ Agent','catA_id' => 4,'expiration' => 1],
            ['name' => 'Forticlient','catA_id' => 4,'expiration' => 2],
            ['name' => 'Improcurement','catA_id' => 5,'expiration' => 1],
            ['name' => 'Custom pages','catA_id' => 5,'expiration' => 1],
            ['name' => 'Inventory','catA_id' => 5,'expiration' => 1],
            ['name' => 'Order Management','catA_id' => 5,'expiration' => 1],
            ['name' => 'Purchasing','catA_id' => 5,'expiration' => 1],
            ['name' => 'LCM','catA_id' => 5,'expiration' => 1],
            ['name' => 'User Access(EBS)','catA_id' => 5,'expiration' => 2],
        ]);

        DB::table('category_c')->insert([
            ['name' => 'No dial tone','catB' => '16'],
            ['name' => 'Humming tone','catB' => '16'],
            ['name' => 'Damage telephone','catB' => '16'],
            ['name' => 'No VPN connection','catB' => '17'],
            ['name' => 'Intermittent connection','catB' => '17'],
            ['name' => 'no internet connection','catB' => '17'],
            ['name' => 'No dial tone and no VPN connection','catB' => '18'],
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
            ['name' => 'Rejected'],
            ['name' => 'Expired']
        ]);




        DB::table('contact_types')->insert([
            ['name' => 'Telephone'],
            ['name' => 'Cell'],
        ]);

        DB::table('app_her_groups')->insert([
            ['group' => 'Group A', 'approver1'=> 1, 'approver2'=> 2, 'approver3' => 3, 'approver4'=> 4, 's_hierarchy' => 'a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}'],
            ['group' => 'Group B', 'approver1'=> 3, 'approver2'=> 4, 'approver3' => null, 'approver4'=> null, 's_hierarchy' => 'a:2:{i:0;i:3;i:1;i:4;}'],
            ['group' => 'Group C', 'approver1'=> 1, 'approver2'=> 2, 'approver3' => 4, 'approver4'=> null, 's_hierarchy' => 'a:3:{i:0;i:1;i:1;i:2;i:2;i:4;}'], 
        ]);


        $this->call([
            //    ProfPicTableSeeder::class,
            //  ContactsTableSeeder::class,
            //    CallersTableSeeder::class,
            //    ResolveTableSeeder::class,
            //    IncidentTableSeeder::class,
            //    TicketTableSeeder::class
            //    MessageTableSeeder::class
        ]);

    }
}
