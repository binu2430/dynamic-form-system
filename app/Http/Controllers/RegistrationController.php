<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\UserFormData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    public function showRegistrationForm($countryCode)
    {
        $form = Form::with('fields')
            ->where('country_code', $countryCode)
            ->where('is_active', true)
            ->firstOrFail();

        // Check if user already has submitted data
        $userData = null;
        if (Auth::check()) {
            $userData = UserFormData::where('user_id', Auth::id())
                ->where('form_id', $form->id)
                ->first();
        }

        return view('registration.form', compact('form', 'userData'));
    }

    public function submitRegistrationForm(Request $request, $countryCode)
    {
        $form = Form::with('fields')
            ->where('country_code', $countryCode)
            ->where('is_active', true)
            ->firstOrFail();

        // Build validation rules based on form fields
        $rules = [];
        foreach ($form->fields as $field) {
            $rules[$field->name] = $field->is_required ? 'required' : 'nullable';
            
            switch ($field->type) {
                case 'email':
                    $rules[$field->name] .= '|email';
                    break;
                case 'number':
                    $rules[$field->name] .= '|numeric';
                    break;
                case 'date':
                    $rules[$field->name] .= '|date';
                    break;
                // Add more type validations as needed
            }
        }

        $validatedData = $request->validate($rules);

        // Save or update user form data
        $userData = [
            'user_id' => Auth::id(),
            'form_id' => $form->id,
            'data' => $validatedData,
        ];

        $existingData = UserFormData::where('user_id', Auth::id())
            ->where('form_id', $form->id)
            ->first();

        if ($existingData) {
            $existingData->update($userData);
        } else {
            UserFormData::create($userData);
        }

        return redirect()->back()->with('success', 'Form submitted successfully!');
    }
}