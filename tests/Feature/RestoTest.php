<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Resto;

class RestoTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_list_all_resto()
    {
        $count = 5;

        Resto::factory()->count($count)->create();

        $this->getJson(route('restos.index'))
            ->assertOk()
            ->assertJsonCount($count);
    }
    public function test_user_can_create_resto()
    {
        // make one ini nanti ga masuk database datanya
        $data = Resto::factory()->makeOne()->toArray();

        $this->postJson(route('restos.store'), $data)
            ->assertCreated();
    }
    public function test_user_can_show_resto() 
    {
        $data = Resto::factory()->createOne();

        $this->getJson(route('restos.show', $data))
            ->assertOk()
            ->assertJsonStructure(['name', 'description', 'address']);
    }
    public function test_user_can_edit_resto()
    {
          // makeOne() kan ga masuk database ya, tapi data nya ada, lek createOne() kan masuk database, jadi nanti data yang di database itu di edit pake data yang di makeOne()
        $updatedData = Resto::factory()->makeOne()->toArray();
        $data = Resto::factory()->createOne();

        $this->patchJson(route('restos.update', $data), $updatedData)
            ->assertOk()
            ->assertJsonStructure(['name', 'description', 'address']);
    }
    public function test_user_can_delete_resto() 
    {
        $data = Resto::factory()->createOne();

        $this->deleteJson(route('restos.destroy', $data))
            ->assertOk()
            ->assertJsonStructure(['name', 'description', 'address']);
    }
}
