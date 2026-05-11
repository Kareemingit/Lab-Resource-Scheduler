<?php

use Tests\TestCase;
use App\Models\User;
use App\Models\Researcher;
use App\Models\Project;
use App\Models\Grant;
use App\Models\Equipment;
use App\Models\Certification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;


class UserControllerTest extends TestCase{
    use RefreshDatabase;
    public function it_can_create_a_researcher_user_successfully()
    {
        $adminId = 1;
        $userData = [
            'username' => 'johndoe',
            'name'     => 'John Doe',
            'password' => 'password12345',
            'role'     => 'researcher'
        ];
        $response = $this->post(route('admin.user.create', ['id' => $adminId]), $userData);

        $this->assertDatabaseHas('user_infos', [
            'username' => 'johndoe',
            'name'     => 'John Doe',
            'role'     => 'researcher'
        ]);

        $user = User::where('username', 'johndoe')->first();
        $this->assertDatabaseHas('researchers', [
            'user_id' => $user->user_id
        ]);

        $this->assertTrue(Hash::check('password12345', $user->password));

        $response->assertRedirect(route('admin.users', ['id' => $adminId]));
    }

    /** @test */
    public function it_fails_to_create_user_with_short_password(){
        $adminId = 1;
        $invalidData = [
            'username' => 'shorty',
            'name'     => 'Short Password',
            'password' => '123', // Shorter than the required 12
            'role'     => 'researcher'
        ];

        $response = $this->post(route('user.create', ['id' => $adminId]), $invalidData);

        // Assert: It should have validation errors for the password
        $response->assertSessionHasErrors(['password']);
    }
}