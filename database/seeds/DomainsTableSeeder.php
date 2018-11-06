<?php

use Illuminate\Database\Seeder;

class DomainsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //adding popular domains

        $user = \App\Models\User::where('email', 'user@gmail.loc')->first();
        $popularDomainsName = ['facebook.com', 'youtube.com', 'github.com', 'google.com', 'yandex.ru', 'ebay.com', 'wikipedia.org', 'instagram.com'];
        $popularDomains = [];
        for ($i = 0; $i < count($popularDomainsName); $i++) {
            $popularDomains [] = [
                'domain' => $popularDomainsName[$i],
                'user_id' => $user->id,
                'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
            ];
        }
        \App\Models\Domain::insert($popularDomains);

        //adding dynamic domains

        $domains = [];
        $tld = ['com', 'org', 'net', 'ru', 'uk'];
        for ($i = 0; $i < 10; $i++) {
            $domains [] = [
                'domain' => substr(md5(microtime()), 0, rand(0, 10)) . $i . '.' . $tld[array_rand($tld)],
                'user_id' => $user->id,
                'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
            ];
        }
        \App\Models\Domain::insert($domains);
    }
}
