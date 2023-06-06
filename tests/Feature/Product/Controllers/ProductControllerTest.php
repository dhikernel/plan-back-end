<?php

namespace Tests\Feature\Product\Controllers;

use App\Domain\Product\Models\Product;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;

class ProductControllerTest extends TestCase
{
    protected string $repository;

    use WithoutMiddleware;

    private array $product;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();
        $this->route       = '/api/products/';
        $this->dataProduct = Product::factory();
    }

    private function prepareEnvironment(): void
    {
        $this->product = Product::factory()->create()->toArray();
    }

    private function getPayload(array $body = []): array
    {
        return array_merge(
            [
                'id' => $this->product['id'],
                'name' => $this->product['name'],
                'description' => $this->product['description'],
                'brand' => $this->product['brand'],
            ],
            $body
        );
    }

    public function testIndex()
    {
        $this->get($this->route . 'list')->assertStatus(Response::HTTP_OK);
    }

    public function testStore()
    {
        $dataProduct = $this->dataProduct->make()->toArray();
        $response = $this->post($this->route . 'create', $dataProduct);
        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function testUpdate()
    {
        $this->prepareEnvironment();
        $data = $this->getPayload();
        $response = $this->put($this->route. 'update/' . $data['id'], $data);
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function testDestroy()
    {
        $this->prepareEnvironment();
        $data = $this->getPayload();
        $response = $this->delete($this->route. 'delete/' . $data['id']);
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }
}
