<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // New, the booking is just created
        Status::create(['key' => Status::NEW, 'name' => 'New']);

        // Accepted, the provider accepted this booking
        Status::create(['key' => Status::ACCEPTED, 'name' => 'Accepted']);

        // On the way, the provider started moving to the booking location
        Status::create(['key' => Status::ON_THE_WAY, 'name' => 'On the way']);

        // Arrived, the provide has arrived to the booking location
        Status::create(['key' => Status::ARRIVED, 'name' => 'Arrived']);

        // In progress, the provider has started working on the service
        Status::create(['key' => Status::IN_PROGRESS, 'name' => 'In progress']);

        // Pending approval, the provider has finished his work and waiting for the customer to approve this
        Status::create(['key' => Status::PENDING_APPROVAL, 'name' => 'Pending approval']);

        // Pending payment, the customer has approved the work and still didn't pay
        Status::create(['key' => Status::PENDING_PAYMENT, 'name' => 'Pending payment']);

        // Done, the customer has paid the service fees
        Status::create(['key' => Status::DONE, 'name' => 'Done']);

        // Reviewed, the customer has reviewed the service
        Status::create(['key' => Status::REVIEWED, 'name' => 'Reviewed']);

        // Canceled, the customer has canceled the request
        Status::create(['key' => Status::CANCELED, 'name' => 'Canceled']);
    }
}
