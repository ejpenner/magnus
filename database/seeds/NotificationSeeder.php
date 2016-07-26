<?php

use Illuminate\Database\Seeder;
use Magnus\Notification;
use Magnus\User;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        
        factory(Notification::class, 'opus', 10)->create()->each(function ($notification) use ($users) {
            echo $notification."\n";
            foreach($users as $user) {
                $user->notifications()->attach($notification->id);
            }
        });

        factory(Notification::class, 'comment', 10)->create()->each(function ($notification) use ($users) {
            echo $notification."\n";
            foreach($users as $user) {
                $user->notifications()->attach($notification->id);
            }
        });
    }
}
