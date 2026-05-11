<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\FinancialDepartment;
use App\Models\Project;
use App\Models\Researcher;
use App\Models\Certification;
use App\Models\Reservation;
use App\Models\Grant;
use App\Models\Equipment;
use App\Models\LabManager;
use App\Models\Supervisor;
use App\Http\Controllers\ReservationController;
use ReflectionMethod;

class ReservationControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_money_transfer_deducts_correct_amounts()
    {
        // Setup: Create a Grant with 1000 and a Project with 1000
        $grant = Grant::factory()->create(['fund' => 1000]);
        $project = Project::factory()->create(['balance' => 1000]);
        $user = User::factory()->create(['role' => 'researcher']);
        $researcher = Researcher::factory()->create([
            'user_id' => $user->user_id, 
            'project_id' => $project->project_id
        ]);

        // Action: Transfer 200
        $controller = new ReservationController();
        $method = new ReflectionMethod(ReservationController::class, 'moneyTransfer');
        $method->setAccessible(true);
        $method->invoke($controller, $grant->grant_id, $user->user_id, 200);

        // Assert: Funds are 800
        $this->assertEquals(800, $grant->fresh()->fund);
        $this->assertEquals(800, $project->fresh()->balance);
    }
}

// test('example', function () {
//     $response = $this->get('/');

//     $response->assertStatus(200);
// });
