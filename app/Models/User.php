<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\StudentProfile;
use App\Models\CompanyProfile;

class User extends Authenticatable
{
   use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }
    // One user has one student profile
public function studentProfile()
{
    return $this->hasOne(StudentProfile::class);
}

// One user has one company profile
public function companyProfile()
{
    return $this->hasOne(CompanyProfile::class);
}

public function internships()
{
    return $this->hasMany(Internship::class, 'company_id');
}

// Student's applications
public function applications()
{
    return $this->hasMany(Application::class, 'student_id');
}
}
