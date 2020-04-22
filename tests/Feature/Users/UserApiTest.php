<?php

namespace Tests\Feature\Users;

use Tests\TestCase;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class UserApiTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->make();
    }
    /** @test */
    /* public function it_can_register_user_from_api() {
        
        $response =$this->postJson("/api/register",['name' => $this->user->name,'email'=>$this->user->email,'password'=>$this->user->password]);
        $token = $this->user->createToken('token-name');

        $expected = ['user'=>[
                            'id'=>$this->user->id,
                            'name' => $this->user->name,
                            'email'=>$this->user->email,
                            'created_at' =>Carbon::parse($this->user['created_at'])->toISOString(),
                            'updated_at' => Carbon::parse($this->user['updated_at'])->toISOString(),
                    ],'token' =>$token->plainTextToken,
                    ];
                    

        $response->assertStatus(200)    
             ->assertJson(['data' => $expected,'errors' => null , 'code' => 201 ,'msg' =>"User registered successfully"]);
    } */
}
