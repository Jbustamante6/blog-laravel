<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreatePost()
    {
        $response = $this->post('/api/admin/post', [ 'user_id'=>1 , 'title'=>'test']);
        $response->assertStatus(201);
    }

    public function testGetPost(){
        $response = $this->get('/api/post');

        $response->assertStatus(200);
    }
}
