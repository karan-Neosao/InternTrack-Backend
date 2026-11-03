<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Internship;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $industry = $request->input('industry');
        $location = $request->input('location');
        $verified = $request->input('verified');
        $status = $request->input('status');

        $companies = User::where('role', 'company')
            ->with('companyProfile')
            ->withCount('internships')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhereHas('companyProfile', function ($profileQuery) use ($search) {
                            $profileQuery->where('company_name', 'like', "%{$search}%")
                                ->orWhere('industry', 'like', "%{$search}%")
                                ->orWhere('location', 'like', "%{$search}%");
                        });
                });
            })
            ->when($industry, function ($query, $industry) {
                $query->whereHas('companyProfile', function ($q) use ($industry) {
                    $q->where('industry', $industry);
                });
            })
            ->when($location, function ($query, $location) {
                $query->whereHas('companyProfile', function ($q) use ($location) {
                    $q->where('location', 'like', "%{$location}%");
                });
            })
            ->when($verified !== null && $verified !== '', function ($query) use ($verified) {
                $query->whereHas('companyProfile', function ($q) use ($verified) {
                    $q->where('is_verified', $verified === '1' || $verified === 'verified');
                });
            })
            ->when($status !== null && $status !== '', function ($query) use ($status) {
                $query->where('is_active', $status === 'active' || $status === '1');
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $industries = DB::table('company_profiles')
            ->whereNotNull('industry')
            ->where('industry', '!=', '')
            ->distinct()
            ->pluck('industry');

        $metrics = [
            'total' => User::where('role', 'company')->count(),
            'verified' => DB::table('company_profiles')->where('is_verified', true)->count(),
            'active' => User::where('role', 'company')->where('is_active', true)->count(),
            'total_jobs' => Internship::count(),
        ];

        return view('admin.companies.index', compact('companies', 'search', 'industry', 'location', 'verified', 'status', 'industries', 'metrics'));
    }

    public function show($id)
    {
        $company = User::where('role', 'company')
            ->with(['companyProfile', 'internships' => function ($q) {
                $q->withCount('applications')->latest();
            }])
            ->findOrFail($id);

        $totalApplications = Application::whereIn(
            'internship_id',
            $company->internships->pluck('id')
        )->count();

        return view('admin.companies.show', compact('company', 'totalApplications'));
    }

    public function toggleVerify($id)
    {
        $company = User::where('role', 'company')->with('companyProfile')->findOrFail($id);

        $profile = $company->companyProfile;
        if (!$profile) {
            $profile = $company->companyProfile()->create([
                'company_name' => $company->name,
                'is_verified' => true,
            ]);
        } else {
            $profile->is_verified = !$profile->is_verified;
            $profile->save();
        }

        $statusText = $profile->is_verified ? 'verified' : 'unverified';

        return back()->with('success', "Company '{$company->name}' has been marked as {$statusText}.");
    }

    public function toggleStatus($id)
    {
        $company = User::where('role', 'company')->findOrFail($id);
        $company->is_active = !$company->is_active;
        $company->save();

        $statusText = $company->is_active ? 'activated' : 'deactivated';

        return back()->with('success', "Company account '{$company->name}' has been {$statusText}.");
    }

    public function destroy($id)
    {
        $company = User::where('role', 'company')->findOrFail($id);

        try {
            DB::transaction(function () use ($company) {
                // Remove logo if present
                if ($company->companyProfile && $company->companyProfile->logo_path) {
                    Storage::disk('public')->delete($company->companyProfile->logo_path);
                }

                // Delete company profile, internships, and user
                $company->companyProfile()?->delete();
                $company->internships()?->delete();
                $company->tokens()->delete();
                $company->delete();
            });

            return redirect()
                ->route('admin.companies')
                ->with('success', "Company '{$company->name}' and all associated internships were deleted successfully.");
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete company: ' . $e->getMessage());
        }
    }
}