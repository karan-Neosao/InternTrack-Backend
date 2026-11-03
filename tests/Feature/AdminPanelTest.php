<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Category;
use App\Models\Internship;
use App\Models\Application;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use DatabaseTransactions;

    protected User $admin;
    protected User $student;
    protected User $company;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::firstOrCreate(
            ['email' => 'admin_test@interntrack.com'],
            [
                'name' => 'Admin Tester',
                'password' => bcrypt('password123'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        $this->student = User::firstOrCreate(
            ['email' => 'student_test@example.com'],
            [
                'name' => 'Student Tester',
                'password' => bcrypt('password123'),
                'role' => 'student',
                'is_active' => true,
            ]
        );
        $this->student->studentProfile()->firstOrCreate([
            'college' => 'MIT',
            'course' => 'Computer Science',
            'graduation_year' => '2026',
            'skills' => 'Laravel, Flutter',
        ]);

        $this->company = User::firstOrCreate(
            ['email' => 'company_test@example.com'],
            [
                'name' => 'Company Tester',
                'password' => bcrypt('password123'),
                'role' => 'company',
                'is_active' => true,
            ]
        );
        $this->company->companyProfile()->firstOrCreate([
            'company_name' => 'TechCorp',
            'industry' => 'Software',
            'location' => 'San Francisco',
            'is_verified' => true,
        ]);
    }

    public function test_admin_can_view_login_page(): void
    {
        $response = $this->get(route('admin.login'));
        $response->assertStatus(200);
        $response->assertSee('InternTrack');
    }

    public function test_admin_can_login_with_valid_credentials(): void
    {
        $response = $this->post(route('admin.login.submit'), [
            'email' => $this->admin->email,
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($this->admin);
    }

    public function test_non_admin_cannot_login_to_admin_panel(): void
    {
        $response = $this->post(route('admin.login.submit'), [
            'email' => $this->student->email,
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_non_admin_cannot_access_admin_dashboard(): void
    {
        $response = $this->actingAs($this->student)->get(route('admin.dashboard'));
        $response->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_view_dashboard(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Dashboard Overview');
        $response->assertSee('TOTAL STUDENTS');
    }

    public function test_admin_can_view_students_list_and_details(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.students'));
        $response->assertStatus(200);
        $response->assertSee($this->student->name);

        $showResponse = $this->actingAs($this->admin)->get(route('admin.students.show', $this->student->id));
        $showResponse->assertStatus(200);
        $showResponse->assertSee($this->student->name);
        $showResponse->assertSee('Computer Science');
    }

    public function test_admin_can_toggle_student_status(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.students.toggle-status', $this->student->id));
        $response->assertRedirect();

        $this->student->refresh();
        $this->assertFalse($this->student->is_active);
    }

    public function test_admin_can_view_companies_and_toggle_verification(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.companies'));
        $response->assertStatus(200);
        $response->assertSee('TechCorp');

        $toggleResponse = $this->actingAs($this->admin)->post(route('admin.companies.toggle-verify', $this->company->id));
        $toggleResponse->assertRedirect();
    }

    public function test_admin_can_create_and_manage_internships(): void
    {
        $category = Category::firstOrCreate(['name' => 'Backend Development', 'slug' => 'backend-dev']);

        $response = $this->actingAs($this->admin)->post(route('admin.internships.store'), [
            'company_id' => $this->company->id,
            'category_id' => $category->id,
            'title' => 'Junior Laravel Developer',
            'description' => 'Great role for interns wanting hands-on PHP experience.',
            'work_type' => 'remote',
            'location' => 'Remote',
            'stipend' => 1200,
            'duration' => '3 Months',
            'deadline' => now()->addDays(30)->format('Y-m-d'),
            'status' => 'active',
            'skills' => 'PHP, Laravel, MySQL',
        ]);

        $response->assertRedirect(route('admin.internships'));
        $this->assertDatabaseHas('internships', [
            'title' => 'Junior Laravel Developer',
            'company_id' => $this->company->id,
        ]);
    }

    public function test_admin_can_manage_categories(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.categories.store'), [
            'name' => 'Cybersecurity Track',
            'description' => 'Security and ethical hacking',
            'is_active' => true,
        ]);

        $response->assertRedirect(route('admin.categories'));
        $this->assertDatabaseHas('categories', ['name' => 'Cybersecurity Track']);
    }

    public function test_admin_can_view_reports_and_export_csv(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.reports'));
        $response->assertStatus(200);
        $response->assertSee('Reports & Analytics');

        $csvResponse = $this->actingAs($this->admin)->get(route('admin.reports.export', 'students'));
        $csvResponse->assertStatus(200);
        $csvResponse->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
    }

    public function test_admin_can_update_profile_in_settings(): void
    {
        $viewResponse = $this->actingAs($this->admin)->get(route('admin.settings'));
        $viewResponse->assertStatus(200);
        $viewResponse->assertSee('Account & System Settings');

        $response = $this->actingAs($this->admin)->put(route('admin.settings.profile'), [
            'name' => 'Super Admin Updated',
            'email' => $this->admin->email,
        ]);

        $response->assertRedirect();
        $this->admin->refresh();
        $this->assertEquals('Super Admin Updated', $this->admin->name);
    }
}
