<?php

namespace Tests\Feature;

use App\Models\Products;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_displays_products()
    {
        $user = User::factory()->create();
        $products = Products::factory()->count(15)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('products.index'));

        $response->assertStatus(200);
        $response->assertViewIs('products.index');
        $response->assertViewHas('products');
    }

    public function test_index_filters_products()
    {
        $user = User::factory()->create();
        Products::factory()->create(['name' => 'Test Product', 'user_id' => $user->id]);
        Products::factory()->create(['name' => 'Another Product', 'user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('products.index', ['search' => 'Test']));

        $response->assertStatus(200);
        $response->assertSee('Test Product');
        $response->assertDontSee('Another Product');
    }

    public function test_index_sorts_products_by_name()
    {
        $user = User::factory()->create();
        Products::factory()->create([
            'user_id' => $user->id,
            'name' => 'B Product',
            'quantity' => 10,
            'cost' => 100
        ]);
        Products::factory()->create([
            'user_id' => $user->id,
            'name' => 'A Product',
            'quantity' => 20,
            'cost' => 200
        ]);

        $response = $this->actingAs($user)->get(route('products.index', ['sort' => 'name', 'direction' => 'asc']));

        $response->assertStatus(200);
        $response->assertSeeInOrder(['A Product', 'B Product']);
    }

    public function test_index_sorts_products_by_user()
    {
        $user1 = User::factory()->create(['name' => 'User A']);
        $user2 = User::factory()->create(['name' => 'User B']);
        Products::factory()->create([
            'user_id' => $user2->id,
            'name' => 'Product B',
            'quantity' => 10,
            'cost' => 100
        ]);
        Products::factory()->create([
            'user_id' => $user1->id,
            'name' => 'Product A',
            'quantity' => 20,
            'cost' => 200
        ]);

        $response = $this->actingAs($user1)->get(route('products.index', ['sort' => 'user', 'direction' => 'asc']));

        $response->assertStatus(200);
        $response->assertSeeInOrder(['Product A', 'Product B']);
    }

    public function test_index_paginates_products()
    {
        $user = User::factory()->create();
        Products::factory()->count(15)->create([
            'user_id' => $user->id,
            'name' => 'Test Product',
            'quantity' => 10,
            'cost' => 100
        ]);

        $response = $this->actingAs($user)->get(route('products.index'));

        $response->assertStatus(200);
        $response->assertViewHas('products');
        $this->assertEquals(10, $response->viewData('products')->count());
        $response->assertSee('Next');
    }

    public function test_create_displays_form()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('products.create'));

        $response->assertStatus(200);
        $response->assertViewIs('products.create');
    }

    public function test_store_creates_new_product()
    {
        $user = User::factory()->create();
        $productData = Products::factory()->make(['user_id' => $user->id])->toArray();

        $response = $this->actingAs($user)->post(route('products.store'), $productData);

        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseHas('products', $productData);
    }

    public function test_show_displays_product()
    {
        $user = User::factory()->create();
        $product = Products::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('products.show', $product));

        $response->assertStatus(200);
        $response->assertViewIs('products.show');
        $response->assertViewHas('product', $product);
    }

    public function test_edit_displays_form()
    {
        $user = User::factory()->create();
        $product = Products::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('products.edit', $product));

        $response->assertStatus(200);
        $response->assertViewIs('products.edit');
        $response->assertViewHas('product', $product);
    }

    public function test_update_modifies_product()
    {
        $user = User::factory()->create();
        $product = Products::factory()->create(['user_id' => $user->id]);
        $updatedData = ['name' => 'Updated Product Name', 'quantity' => 50, 'cost' => 200];

        $response = $this->actingAs($user)->put(route('products.update', $product), $updatedData);

        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseHas('products', $updatedData);
    }

    public function test_destroy_deletes_product()
    {
        $user = User::factory()->create();
        $product = Products::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete(route('products.destroy', $product));

        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    public function test_user_cannot_delete_product_not_owned()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $product = Products::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->actingAs($user)->delete(route('products.destroy', $product));

        $response->assertStatus(403);
        $this->assertDatabaseHas('products', ['id' => $product->id]);
    }

    public function test_non_owner_cannot_access_edit_form()
    {
        $owner = User::factory()->create();
        $nonOwner = User::factory()->create();
        $product = Products::factory()->create(['user_id' => $owner->id]);

        $response = $this->actingAs($nonOwner)->get(route('products.edit', $product));

        $response->assertStatus(403);
    }

    public function test_non_owner_cannot_update_product()
    {
        $owner = User::factory()->create();
        $nonOwner = User::factory()->create();
        $product = Products::factory()->create(['user_id' => $owner->id]);
        $updatedData = ['name' => 'Updated Product Name', 'quantity' => 50, 'cost' => 200];

        $response = $this->actingAs($nonOwner)->put(route('products.update', $product), $updatedData);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('products', $updatedData);
    }

    public function test_non_owner_can_access_show_page()
    {
        $owner = User::factory()->create();
        $nonOwner = User::factory()->create();
        $product = Products::factory()->create(['user_id' => $owner->id]);

        $response = $this->actingAs($nonOwner)->get(route('products.show', $product));

        $response->assertStatus(200);
        $response->assertViewIs('products.show');
        $response->assertViewHas('product', $product);
    }

    public function test_edit_button_not_visible_for_non_owner()
    {
        $owner = User::factory()->create();
        $nonOwner = User::factory()->create();
        $product = Products::factory()->create(['user_id' => $owner->id]);

        $response = $this->actingAs($nonOwner)->get(route('products.show', $product));

        $response->assertStatus(200);
        $response->assertDontSee('Editar');
    }
}
