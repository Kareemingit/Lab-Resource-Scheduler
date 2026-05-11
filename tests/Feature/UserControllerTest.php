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


class UserControllerTest extends TestCase
{
    use RefreshDatabase;

}
// test('example', function () {
//     $response = $this->get('/');

//     $response->assertStatus(200);
// });
