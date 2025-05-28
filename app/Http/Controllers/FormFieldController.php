<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\FormField;
use Illuminate\Http\Request;

class FormFieldController extends Controller
{
    public function create(Form $form)
    {
        $fieldTypes = ['text', 'number', 'date', 'select', 'email', 'tel', 'textarea'];
        $categories = ['general', 'identity', 'bank'];
        
        return view('fields.create', compact('form', 'fieldTypes', 'categories'));
    }

    public function store(Request $request, Form $form)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'name' => 'required|string|max:255|regex:/^[a-zA-Z_]+$/',
            'type' => 'required|string|in:text,number,date,select,email,tel,textarea',
            'options' => 'nullable|string', // Comma-separated for select
            'is_required' => 'boolean',
            'category' => 'required|in:general,identity,bank',
            'order' => 'integer',
        ]);

        // Convert options to array if it's a select field
        if ($validated['type'] === 'select' && !empty($validated['options'])) {
            $validated['options'] = array_map('trim', explode(',', $validated['options']));
        } else {
            $validated['options'] = null;
        }

        $form->fields()->create($validated);

        return redirect()->route('forms.edit', $form)->with('success', 'Field added successfully!');
    }

    public function edit(Form $form, FormField $field)
    {
        $fieldTypes = ['text', 'number', 'date', 'select', 'email', 'tel', 'textarea'];
        $categories = ['general', 'identity', 'bank'];
        
        return view('fields.edit', compact('form', 'field', 'fieldTypes', 'categories'));
    }

    public function update(Request $request, Form $form, FormField $field)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'type' => 'required|string|in:text,number,date,select,email,tel,textarea',
            'options' => 'nullable|string',
            'is_required' => 'boolean',
            'category' => 'required|in:general,identity,bank',
            'order' => 'integer',
        ]);

        if ($validated['type'] === 'select' && !empty($validated['options'])) {
            $validated['options'] = array_map('trim', explode(',', $validated['options']));
        } else {
            $validated['options'] = null;
        }

        $field->update($validated);

        return redirect()->route('forms.edit', $form)->with('success', 'Field updated successfully!');
    }

    public function destroy(Form $form, FormField $field)
    {
        $field->delete();
        return redirect()->route('forms.edit', $form)->with('success', 'Field deleted successfully!');
    }
}