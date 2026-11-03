<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanyProfileController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();

        if ($user->role !== 'company') {
            return response()->json([
                'success' => false,
                'message' => 'Only company accounts can access this profile.',
            ], 403);
        }

        $profile = $user->companyProfile()->firstOrCreate([]);

        return response()->json([
            'success' => true,
            'data' => [
                'user' => $user,
                'profile' => $profile,
            ],
        ], 200);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        if ($user->role !== 'company') {
            return response()->json([
                'success' => false,
                'message' => 'Only company accounts can update this profile.',
            ], 403);
        }

        $validated = $request->validate([
            'company_name' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'description' => ['nullable', 'string'],
            'industry' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
        ]);

        $profile = $user->companyProfile()->updateOrCreate(
            ['user_id' => $user->id],
            $validated
        );

        return response()->json([
            'success' => true,
            'message' => 'Company profile updated successfully.',
            'data' => $profile,
        ], 200);
    }

    public function uploadLogo(Request $request)
    {
        $user = $request->user();

        if ($user->role !== 'company') {
            return response()->json([
                'success' => false,
                'message' => 'Only company accounts can upload a logo.',
            ], 403);
        }

        $validated = $request->validate([
            'logo' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $profile = $user->companyProfile()->firstOrCreate([]);

        if ($profile->logo_path) {
            Storage::disk('public')->delete($profile->logo_path);
        }

        $logoPath = $request->file('logo')->store('company-logos', 'public');

        $profile->update([
            'logo_path' => $logoPath,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Company logo uploaded successfully.',
            'logo_path' => $logoPath,
            'logo_url' => Storage::disk('public')->url($logoPath),
        ], 200);
    }
}
