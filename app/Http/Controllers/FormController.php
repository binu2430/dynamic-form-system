<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\UserFormData;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function index()
    {
        $forms = auth()->user()->forms()
        ->withCount('fields')
        ->latest()
        ->get();
        return view('forms.index', compact('forms'));
    }

    public function create()
    {
        $countries = config('countries');
        return view('forms.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'country_code' => 'required|string|max:2',
        ]);

        $form = $request->user()->forms()->create($validated);

        return redirect()->route('forms.index')->with('success', 'Form created successfully!');
    }

    public function show(Form $form)
    {
        $form->load(['fields' => function($query) {
            $query->orderBy('order');
        }, 'submissions.user']);
    
        return view('forms.show', compact('form'));
    }

    public function edit(Form $form)
    {
        $countries = config('countries');
        return view('forms.edit', compact('form', 'countries'));
    }

    public function update(Request $request, Form $form)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'country_code' => 'required|string|max:2',
            'is_active' => 'boolean',
        ]);

        $form->update($validated);

        return redirect()->route('forms.index')->with('success', 'Form updated successfully!');
    }

    public function destroy(Form $form)
    {
        $form->delete();
        return redirect()->route('forms.index')->with('success', 'Form deleted successfully!');
    }

    public function display(Form $form)
{
    // Eager load fields with ordering
    $form->load(['fields' => function($query) {
        $query->orderBy('order');
    }]);
    
    return view('forms.display', compact('form'));
}

public function submit(Request $request, Form $form)
{
    // Load fields with proper ordering
    $form->load(['fields' => function($query) {
        $query->orderBy('order');
    }]);

    // Build validation rules and collect field metadata
    $rules = [];
    $fieldSnapshot = [];
    
    foreach ($form->fields as $field) {
        $rules[$field->name] = $field->is_required ? 'required' : 'nullable';
        
        // Store field configuration
        $fieldSnapshot[$field->name] = [
            'label' => $field->label,
            'name' => $field->name,
            'type' => $field->type,
            'options' => $field->options,
            'is_required' => $field->is_required,
            'category' => $field->category,
            'order' => $field->order
        ];
        
        // Add type-specific validation
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
        }
    }
    $validatedData = $request->validate($rules);

    // Store with both data and field configuration
    UserFormData::create([
        'user_id' => auth()->id(),
        'form_id' => $form->id,
        'data' => $validatedData,
        'field_snapshot' => $fieldSnapshot // This was missing
    ]);
    return redirect()->route('forms.edit', $form)->with('success', 'Form submitted successfully!');

    //return redirect()->back()->with('success', 'Form submitted successfully!');
}
}