<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CompanyControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic feature test example.
     */
    public function test_create_company_201(): void
    {
        $data = [
            "name" => "Microsoft",
        ];

        $response = $this->post('/api/companies/store', $data);

        $response->assertStatus(201);
    }

    /**
     * A basic feature test example.
     */
    public function test_show_company_200(): void
    {
        $data = [
            "name" => "Microsoft",
        ];

        $response = $this->post('/api/companies/store', $data)->decodeResponseJson();

        $response = $this->get("/api/companies/show/{$response['id']}");

        $response->assertStatus(200)->assertJson(["name" => "Microsoft"]);
    }

    /**
    * A basic feature test example.
    */
    public function test_destroy_company_200(): void
    {
        $data = [
            "name" => "Microsoft",
        ];

        $response = $this->post('/api/companies/store', $data)->decodeResponseJson();

        $response = $this->delete("/api/companies/destroy/{$response['id']}");

        //dd($response->decodeResponseJson());

        $response->assertStatus(200);
    }

    /**
    * A basic feature test example.
    */
    public function test_create_company_missing_parameter_422(): void
    {
        $data = [
            "name" => "",
        ];

        $response = $this->post('/api/companies/store', $data);

        $response->assertInvalid([
            'name' => 'The company name is required.',
        ]);
    }

    /**
     * A basic feature test example.
     */
    public function test_updated_company_200(): void
    {
        $data = [
            "name" => "Microsoft",
        ];

        $response = $this->post('/api/companies/store', $data)->decodeResponseJson();

        $data = [
            "name" => "MS",
        ];

        $response = $this->patch("/api/companies/update/{$response['id']}", $data);

        $response = $this->get("/api/companies/show/{$response['id']}");

        $response->assertJson(["name" => "MS"]);
    }
}
