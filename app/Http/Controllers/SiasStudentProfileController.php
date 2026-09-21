<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiasStudentProfileController extends Controller
{
    /**
     * Update personal information
     */
    public function updatePersonalInformation(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'birthdate' => 'nullable|date',
            'gender' => 'nullable|string',
            'civil_status' => 'nullable|string',
        ]);

        $user->update($validated);

        return redirect()->route('sias.student.profile.personal_information')
            ->with('success', 'Personal information updated successfully.');
    }

    /**
     * Update addresses and contacts
     */
    public function updateAddressesContacts(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'permanent_address' => 'nullable|string|max:500',
            'zip_code' => 'nullable|string|max:20',
            'mobile_number' => 'nullable|string|max:20',
            'contact_email' => 'nullable|email|max:255',
            'emergency_contact' => 'nullable|string|max:255',
        ]);

        $user->update($validated);

        return redirect()->route('sias.student.profile.addresses_contacts')
            ->with('success', 'Address and contact information updated successfully.');
    }

    /**
     * Update family background
     */
    public function updateFamilyBackground(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'guardian_name' => 'nullable|string|max:255',
            'guardian_relationship' => 'nullable|string|max:100',
            'guardian_contact' => 'nullable|string|max:20',
        ]);

        $user->update($validated);

        return redirect()->route('sias.student.profile.family_background')
            ->with('success', 'Family background updated successfully.');
    }

    /**
     * Update educational background
     */
    public function updateEducationalBackground(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'school_name' => 'nullable|string|max:255',
            'graduation_year' => 'nullable|integer|min:1900|max:2100',
            'course_strand' => 'nullable|string|max:255',
            'honors' => 'nullable|string|max:255',
        ]);

        $user->update($validated);

        return redirect()->route('sias.student.profile.educational_background')
            ->with('success', 'Educational background updated successfully.');
    }

    /**
     * Update religious background
     */
    public function updateReligiousBackground(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'religion' => 'nullable|string|max:255',
            'church' => 'nullable|string|max:255',
            'baptism_date' => 'nullable|date',
            'communion_date' => 'nullable|date',
        ]);

        $user->update($validated);

        return redirect()->route('sias.student.profile.religious_background')
            ->with('success', 'Religious background updated successfully.');
    }

    /**
     * Update medical information
     */
    public function updateMedicalInformation(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'blood_type' => 'nullable|string|max:10',
            'allergies' => 'nullable|string|max:500',
            'medical_conditions' => 'nullable|string|max:500',
            'medical_emergency_contact' => 'nullable|string|max:255',
        ]);

        $user->update($validated);

        return redirect()->route('sias.student.profile.medical_information')
            ->with('success', 'Medical information updated successfully.');
    }

    /**
     * Update employment records
     */
    public function updateEmploymentRecords(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'employer' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'employment_period' => 'nullable|string|max:100',
            'work_description' => 'nullable|string|max:500',
        ]);

        $user->update($validated);

        return redirect()->route('sias.student.profile.employment_records')
            ->with('success', 'Employment records updated successfully.');
    }

    /**
     * Update classifications and disabilities
     */
    public function updateClassificationsDisabilities(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'disability_classification' => 'nullable|string|max:100',
            'support_requirements' => 'nullable|string|max:500',
            'disability_notes' => 'nullable|string|max:1000',
        ]);

        $user->update($validated);

        return redirect()->route('sias.student.profile.classifications_disabilities')
            ->with('success', 'Classifications and disabilities information updated successfully.');
    }
}
