<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManagerControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic feature test example.
     */
    public function test_create_manager_201(): void
    {
        $data = [
            "name" => "John Doe",
        ];

        $response = $this->post('/api/managers/store', $data);

        $response->assertStatus(201);
    }

    /**
     * A basic feature test example.
     */
    public function test_show_manager_200(): void
    {
        $data = [
            "name" => "John Doe",
        ];

        $response = $this->post('/api/managers/store', $data)->decodeResponseJson();

        $response = $this->get("/api/managers/show/{$response['id']}");

        $response->assertStatus(200);
    }

    /**
    * A basic feature test example.
    */
    public function test_create_manager_missing_parameter_422(): void
    {
        $data = [
            "name" => "",
        ];

        $response = $this->post('/api/managers/store', $data);

        $response->assertInvalid([
            'name' => 'The manager name is required.',
        ]);
    }

    /**
     * A basic feature test example.
     */
    public function test_updated_manager_200(): void
    {
        $data = [
            "name" => "John Doe",
        ];

        $response = $this->post('/api/managers/store', $data)->decodeResponseJson();

        $data = [
            "name" => "Phillip Morris",
        ];

        $response = $this->patch("/api/managers/update/{$response['id']}", $data);

        $response = $this->get("/api/managers/show/{$response['id']}");

        $response->assertJson(["name" => "Phillip Morris"]);
    }
}
