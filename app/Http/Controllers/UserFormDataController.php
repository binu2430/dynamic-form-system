<?php

namespace App\Http\Controllers;

use App\Models\UserFormData;
use App\Models\Form;
use Illuminate\Http\Request;

class UserFormDataController extends Controller
{
    public function edit(UserFormData $userFormData)
    {
        // Load the form with fields ordered correctly
        $form = $userFormData->form()->with(['fields' => function($query) {
            $query->orderBy('order');
        }])->first();
        
        // Get the field snapshot or current field config if snapshot is empty
        $fieldConfigs = [];
        foreach ($form->fields as $field) {
            $fieldConfigs[$field->name] = $userFormData->field_snapshot[$field->name] ?? [
                'label' => $field->label,
                'name' => $field->name,
                'type' => $field->type,
                'options' => $field->options,
                'is_required' => $field->is_required,
                'category' => $field->category,
                'order' => $field->order
            ];
        }
    
        return view('user-form-data.edit', [
            'form' => $form,
            'submission' => $userFormData,
            'data' => $userFormData->data,
            'fieldConfigs' => $fieldConfigs
        ]);
    }

    public function update(Request $request, UserFormData $userFormData)
    {
        $form = $userFormData->form;
        $fieldConfigs = $userFormData->field_snapshot ?: [];
        
        // Build validation rules based on original field configs
        $rules = [];
        $fieldNames = [];
        
        foreach ($form->fields as $field) {
            $config = $fieldConfigs[$field->name] ?? [
                'is_required' => $field->is_required,
                'type' => $field->type
            ];
            
            $rules[$field->name] = $config['is_required'] ? 'required' : 'nullable';
            $fieldNames[$field->name] = $config['label'] ?? $field->label;
            
            // Add type-specific validation
            switch ($config['type']) {
                case 'email':
                    $rules[$field->name] .= '|email';
                    break;
                case 'number':
                    $rules[$field->name] .= '|numeric';
                    break;
                case 'date':
                    $rules[$field->name] .= '|date';
                    break;
            }
        }
    
        $validatedData = $request->validate($rules, [], $fieldNames);
    
        // Update the submission data while preserving the original field config
        $userFormData->update([
            'data' => $validatedData
            // Keep the original field_snapshot
        ]);
    
        return redirect()->route('forms.show', $form)
            ->with('success', 'Submission updated successfully!');
    }
}