<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Internship;
use App\Models\Application;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class FlutterApiCompatibilityTest extends TestCase
{
    use DatabaseTransactions;

    public function test_student_registration_api(): void
    {
        $payload = [
            'name' => 'API Student Test',
            'email' => 'api_student_' . uniqid() . '@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/api/register', $payload);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'user' => ['id', 'name', 'email', 'role'],
                'token',
            ],
        ]);
    }

    public function test_company_registration_api(): void
    {
        $payload = [
            'name' => 'API Company Test',
            'email' => 'api_company_' . uniqid() . '@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'company_name' => 'Innovate Corp',
            'website' => 'https://innovate.test',
            'industry' => 'Tech',
            'location' => 'Seattle',
        ];

        $response = $this->postJson('/api/register-company', $payload);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'user' => ['id', 'name', 'email', 'role'],
                'token',
            ],
        ]);
    }

    public function test_api_login(): void
    {
        $email = 'api_login_' . uniqid() . '@example.com';
        $user = User::create([
            'name' => 'Login User',
            'email' => $email,
            'password' => bcrypt('password123'),
            'role' => 'student',
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $email,
            'password' => 'password123',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'user',
                'token',
            ],
        ]);
    }

    public function test_public_internships_api(): void
    {
        $response = $this->getJson('/api/internships');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data',
        ]);
    }

    public function test_student_can_fetch_and_update_profile_api(): void
    {
        $student = User::create([
            'name' => 'Profile Student',
            'email' => 'student_prof_' . uniqid() . '@example.com',
            'password' => bcrypt('password123'),
            'role' => 'student',
        ]);
        $token = $student->createToken('test-token')->plainTextToken;

        // Fetch profile
        $getResponse = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/student/profile');
        $getResponse->assertStatus(200);
        $getResponse->assertJson(['success' => true]);

        // Update profile
        $updateResponse = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->putJson('/api/student/profile', [
                'phone' => '1234567890',
                'college' => 'Stanford University',
                'course' => 'BSc Computer Science',
                'graduation_year' => 2026,
                'skills' => 'Flutter, Dart, Firebase',
            ]);
        $updateResponse->assertStatus(200);
        $updateResponse->assertJson(['success' => true]);
    }

    public function test_admin_api_endpoints(): void
    {
        $admin = User::create([
            'name' => 'API Admin User',
            'email' => 'admin_api_' . uniqid() . '@example.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);
        $token = $admin->createToken('admin-test-token')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/admin/dashboard');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'total_students',
                'total_companies',
                'total_internships',
                'active_internships',
                'total_applications',
            ],
        ]);
    }

    public function test_company_internship_and_application_lifecycle_api(): void
    {
        // 1. Company creates internship
        $company = User::create([
            'name' => 'Lifecycle Company',
            'email' => 'comp_life_' . uniqid() . '@example.com',
            'password' => bcrypt('password123'),
            'role' => 'company',
        ]);

        \Laravel\Sanctum\Sanctum::actingAs($company, ['*']);

        $createResponse = $this->postJson('/api/internships', [
            'title' => 'Flutter Mobile Developer Intern',
            'description' => 'Build high-performance mobile apps with Flutter.',
            'skills' => 'Flutter, Dart, REST API',
            'location' => 'Remote',
            'work_type' => 'remote',
            'stipend' => 1500,
            'duration' => '3 Months',
        ]);

        $createResponse->assertStatus(201);
        $createResponse->assertJson(['success' => true]);
        $internshipId = $createResponse->json('data.id');

        // 2. Student applies for internship
        $student = User::create([
            'name' => 'Lifecycle Student',
            'email' => 'stud_life_' . uniqid() . '@example.com',
            'password' => bcrypt('password123'),
            'role' => 'student',
        ]);

        \Laravel\Sanctum\Sanctum::actingAs($student, ['*']);

        $applyResponse = $this->postJson("/api/internships/{$internshipId}/apply", [
            'cover_letter' => 'I am excited about this Flutter internship.',
        ]);

        $applyResponse->assertStatus(201);
        $applyResponse->assertJson(['success' => true]);
        $applicationId = $applyResponse->json('data.id');

        // 3. Student views my-applications
        $myAppsResponse = $this->getJson('/api/my-applications');
        $myAppsResponse->assertStatus(200);
        $myAppsResponse->assertJson(['success' => true]);

        // 4. Company views applicants
        \Laravel\Sanctum\Sanctum::actingAs($company, ['*']);
        $applicantsResponse = $this->getJson('/api/company/applicants');
        $applicantsResponse->assertStatus(200);
        $applicantsResponse->assertJson(['success' => true]);

        // 5. Company updates application status to accepted
        $statusResponse = $this->patchJson("/api/company/applications/{$applicationId}/status", [
            'status' => 'accepted',
        ]);
        $statusResponse->assertStatus(200);
        $statusResponse->assertJson(['success' => true]);
    }
}
