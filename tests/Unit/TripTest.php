<?php

namespace Tests\Unit;

use Tests\TestCase;

use Faker\Factory as Faker;

use App\Models\City;
use App\Models\TripType;
use App\Models\Trip;

class TripTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_get_trip_without_apikey()
    {
        $response = $this->get('/api/trip');

        $response->assertStatus(401);
    }

    public function test_get_trip_with_apikey()
    {
        $apikey = "yDw02nZaXMb95eHjqmmrAh00B52XoaaehjP7v9j7jOx2EbzoANSWJyBeUInYmcfu";

        $response = $this->withHeaders([
            'X-Authorization' => $apikey
        ])->get('/api/trip');

        $response->assertStatus(200);
    }

    public function test_insert_trip_without_apikey()
    {
        $faker = Faker::create('id_ID');

        $origin = City::inRandomOrder()->first();
        $destination = City::inRandomOrder()->first();
        $trip_types = TripType::inRandomOrder()->first();

        $response = $this->post('/api/trip', [
            'title' => $faker->text($maxNbChars = 100),
            'origin_id' => $origin->id,
            'destination_id' => $destination->id,
            'start_date' => $faker->dateTime(),
            'end_date' => $faker->dateTime(),
            'trip_types_id' => $trip_types->id,
            'description' => $faker->sentence()
        ]);

        $response->assertStatus(401);
    }

    public function test_insert_trip_with_blank_field()
    {
        $faker = Faker::create('id_ID');

        $origin = City::inRandomOrder()->first();
        $destination = City::inRandomOrder()->first();
        $trip_types = TripType::inRandomOrder()->first();

        $response = $this->post('/api/trip', [
            'title' => "",
            'origin_id' => $origin->id,
            'destination_id' => $destination->id,
            'start_date' => $faker->dateTime(),
            'end_date' => $faker->dateTime(),
            'trip_types_id' => $trip_types->id,
            'description' => $faker->sentence()
        ]);

        $response->assertStatus(401);
    }

    public function test_insert_trip_with_apikey_and_complete_field()
    {
        $faker = Faker::create('id_ID');

        $origin = City::inRandomOrder()->first();
        $destination = City::inRandomOrder()->first();
        $trip_types = TripType::inRandomOrder()->first();

        $apikey = "yDw02nZaXMb95eHjqmmrAh00B52XoaaehjP7v9j7jOx2EbzoANSWJyBeUInYmcfu";

        $response = $this->withHeaders([
            'X-Authorization' => $apikey
        ])->post('/api/trip', [
            'title' => $faker->text($maxNbChars = 100),
            'origin_id' => $origin->id,
            'destination_id' => $destination->id,
            'start_date' => $faker->dateTime(),
            'end_date' => $faker->dateTime(),
            'trip_types_id' => $trip_types->id,
            'description' => $faker->sentence()
        ]);

        $response->assertStatus(200);
    }

    public function test_update_trip_without_id()
    {
        $faker = Faker::create('id_ID');

        $trip = Trip::inRandomOrder()->first();
        $origin = City::inRandomOrder()->first();
        $destination = City::inRandomOrder()->first();
        $trip_types = TripType::inRandomOrder()->first();

        $response = $this->put('/api/trip/', [
            'title' => $faker->text($maxNbChars = 100),
            'origin_id' => $origin->id,
            'destination_id' => $destination->id,
            'start_date' => $faker->dateTime(),
            'end_date' => $faker->dateTime(),
            'trip_types_id' => $trip_types->id,
            'description' => $faker->sentence()
        ]);

        $response->assertStatus(405);
    }

    public function test_update_trip_without_apikey()
    {
        $faker = Faker::create('id_ID');

        $trip = Trip::inRandomOrder()->first();
        $origin = City::inRandomOrder()->first();
        $destination = City::inRandomOrder()->first();
        $trip_types = TripType::inRandomOrder()->first();

        $response = $this->put('/api/trip/'.$trip->id, [
            'title' => $faker->text($maxNbChars = 100),
            'origin_id' => $origin->id,
            'destination_id' => $destination->id,
            'start_date' => $faker->dateTime(),
            'end_date' => $faker->dateTime(),
            'trip_types_id' => $trip_types->id,
            'description' => $faker->sentence()
        ]);

        $response->assertStatus(401);
    }

    public function test_update_trip_with_blank_field()
    {
        $faker = Faker::create('id_ID');

        $trip = Trip::inRandomOrder()->first();
        $origin = City::inRandomOrder()->first();
        $destination = City::inRandomOrder()->first();
        $trip_types = TripType::inRandomOrder()->first();

        $response = $this->put('/api/trip/'.$trip->id, [
            'title' => "",
            'origin_id' => $origin->id,
            'destination_id' => $destination->id,
            'start_date' => $faker->dateTime(),
            'end_date' => $faker->dateTime(),
            'trip_types_id' => $trip_types->id,
            'description' => $faker->sentence()
        ]);

        $response->assertStatus(401);
    }

    public function test_update_trip_with_apikey_and_complete_field()
    {
        $faker = Faker::create('id_ID');

        $trip = Trip::inRandomOrder()->first();
        $origin = City::inRandomOrder()->first();
        $destination = City::inRandomOrder()->first();
        $trip_types = TripType::inRandomOrder()->first();

        $apikey = "yDw02nZaXMb95eHjqmmrAh00B52XoaaehjP7v9j7jOx2EbzoANSWJyBeUInYmcfu";

        $response = $this->withHeaders([
            'X-Authorization' => $apikey
        ])->put('/api/trip/'.$trip->id, [
            'title' => $faker->text($maxNbChars = 100),
            'origin_id' => $origin->id,
            'destination_id' => $destination->id,
            'start_date' => $faker->dateTime(),
            'end_date' => $faker->dateTime(),
            'trip_types_id' => $trip_types->id,
            'description' => $faker->sentence()
        ]);

        $response->assertStatus(200);
    }

    public function test_delete_trip_without_id()
    { 
        $response = $this->delete('api/trip/');

        $response->assertStatus(405);
    }

    public function test_delete_trip_without_apikey()
    {
        $trip = Trip::inRandomOrder()->first();    

        $response = $this->put('api/trip/'.$trip->id);

        $response->assertStatus(401);
    }

    public function test_delete_trip_with_apikey_and_complete_field()
    {
        $apikey = "yDw02nZaXMb95eHjqmmrAh00B52XoaaehjP7v9j7jOx2EbzoANSWJyBeUInYmcfu";

        $trip = Trip::inRandomOrder()->first();      
        
        $response = $this->withHeaders([
            'X-Authorization' => $apikey
        ])->delete('api/trip/'.$trip->id);

        $response->assertStatus(200);
    }
}
