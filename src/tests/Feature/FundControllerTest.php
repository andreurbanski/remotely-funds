<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FundControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic feature test example.
     */
    public function test_create_fund_201(): void
    {
        $manager = $this->post('/api/managers/store', ["name" => "John Doe"])->decodeResponseJson();

        $data = [
            "name" => "Black Rock",
            "aliases" => ["BR", "TESTBR"],
            "start_year" => 2024,
            "manager_id" => $manager['id']
        ];

        $response = $this->post('/api/funds/store', $data);

        $response->assertStatus(201);
    }

    /**
     * A basic feature test example.
     */
    public function test_show_fund_200(): void
    {
        $manager = $this->post('/api/managers/store', ["name" => "John Doe"])->decodeResponseJson();

        $data = [
            "name" => "Black Rock",
            "aliases" => ["BR", "TESTBR"],
            "start_year" => 2024,
            "manager_id" => $manager['id']
        ];

        $response = $this->post('/api/funds/store', $data)->decodeResponseJson();

        $response = $this->get("/api/funds/show/{$response['id']}");

        $response->assertStatus(200)->assertJson(['id' => $response['id']]);
    }

    /**
    * A basic feature test example.
    */
    public function test_create_fund_missing_parameter_422(): void
    {
        $data = [
            "name" => "",
        ];

        $response = $this->post('/api/funds/store', $data);

        $response->assertInvalid([
            'name' => 'The name is required.',
        ]);
    }

    /**
     * A basic feature test example.
     */
    public function test_updated_fund_200(): void
    {
        $manager = $this->post('/api/managers/store', ["name" => "John Doe"])->decodeResponseJson();

        $data = [
            "name" => "Black Rock",
            "aliases" => ["BR", "TESTBR"],
            "start_year" => 2024,
            "manager_id" => $manager['id']
        ];

        $response = $this->post('/api/funds/store', $data)->decodeResponseJson();

        $data = [
            "name" => "Black Rock Updated",
            "aliases" => ["BR", "TESTBR"],
        ];

        $response = $this->patch("/api/funds/update/{$response['id']}", $data);

        $response = $this->get("/api/funds/show/{$response['id']}");

        $response->assertJson(["name" => "Black Rock Updated"]);
    }
}
