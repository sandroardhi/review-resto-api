<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

class AuthenticationTest extends TestCase
{
     // ini e jangan lupa di use jare mas donny, gaero gae opo
     use RefreshDatabase;


     public function test_user_can_login() 
     {
          $user = User::factory()->createOne();

          $data = [
               'email' => $user->email,
               'password' => 'password',
               'device_name' => 'testing'
          ];

          // ini bagian testing e
          $this->postJson(route('auth.login'), $data)
               // assertOk() itu buat mastiin kalo respon yang didapat 200
               ->assertOk()
               // assertJsonStructure() itu mastiin di responnya ada 'access_token', 'user' (paling se rodok ngarang)
               ->assertJsonStructure(['access_token', 'user']);
     }
     public function test_user_can_register() 
     {
          $data = [
               'name' => 'Tester',
               'email' => 'testing@gmail.com',
               'password' => 'password',
               'password_confirmation' => 'password',
          ];

          $this->postJson(route('auth.register'), $data)
               ->assertCreated()
               ->assertJsonFragment(['email' => $data['email']]);
          }
     public function test_user_can_see_ther_profile()  
     {
          $user = User::factory()->createOne();

          // ini kan ceritae kalo user mau liat profile harus login dulu kan baru bisa liat profilenya, nah Sanctum::actingAs($user) kyk nanti seolah olah $user ini login di app kita
          Sanctum::actingAs($user);

          $this->getJson(route('auth.profile'))
               ->assertOk()
               ->assertJsonFragment(['email' => $user->email]);
     }
     public function test_user_cant_see_ther_profile_when_unauthenticated()
     {
          // test ini kan ceritae buat mastiin user ga bisa lia profile mereka kalo belum login

          $this->getJson(route('auth.profile'))
               ->assertUnauthorized();
     }
     public function test_user_can_logout() 
     {
          $user = User::factory()->createOne();

          Sanctum::actingAs($user);

          $this->getJson(route('auth.logout'))->assertOk();
     }
}
