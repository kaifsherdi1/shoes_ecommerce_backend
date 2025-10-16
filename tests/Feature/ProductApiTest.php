<?php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Models\User;

class ProductApiTest extends TestCase
{
    public function test_can_list_products()
    {
        Product::factory()->count(3)->create();
        $res = $this->getJson('/api/v1/products');
        $res->assertStatus(200)->assertJsonStructure(['data','links','meta']);
    }

    public function test_admin_can_create_product()
    {
        $admin = User::factory()->admin()->create();
        $payload = ['name'=>'Test','description'=>'desc','price'=>100,'category_id'=>null];
        $token = $admin->createToken('test')->plainTextToken;
        $res = $this->withHeader('Authorization','Bearer '.$token)->postJson('/api/v1/products',$payload);
        $res->assertStatus(201);
    }
}
