@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>View Form: {{ $form->name }}</h1>
        <div>
            <a href="{{ route('forms.index') }}" class="btn btn-secondary me-2">Back to Forms</a>
        </div>

    </div>

    <div class="card mb-4">
        <div class="card-header">
            Form Details
        </div>
        <div class="card-body">
            <p><strong>Name:</strong> {{ $form->name }}</p>
            <p><strong>Country:</strong> {{ config('countries')[$form->country_code] }} ({{ $form->country_code }})</p>
            <p><strong>Status:</strong> {{ $form->is_active ? 'Active' : 'Inactive' }}</p>
            <p><strong>Created:</strong> {{ $form->created_at->format('m/d/Y H:i') }}</p>
            <p><strong>Last Updated:</strong> {{ $form->updated_at->format('m/d/Y H:i') }}</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Submitted Data</h3>
        </div>
        <div class="card-body">
            @if($form->submissions->isEmpty())
                <p>No submissions yet.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>User</th>
                                <!-- @foreach($form->fields as $field)
                                    <th>{{ $field->label }}</th>
                                @endforeach -->
                                <th>Submitted At</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($form->submissions as $submission)
    <tr>
        <td>{{ $submission->user->name ?? 'Guest' }}</td>
        
        @foreach($form->fields as $field)
            <!-- <td>
                @php
                    // Try to get field config from snapshot first, then current form
                    $fieldConfig = $submission->field_snapshot[$field->name] ?? null;
                    $currentType = $fieldConfig['type'] ?? $field->type;
                    $value = $submission->data[$field->name] ?? null;
                @endphp
                
                @if($value !== null)
                    @if(($fieldConfig['type'] ?? $field->type) === 'select')
                        {{-- Display selected option --}}
                        {{ $value }}
                    @else
                        {{-- Display raw value --}}
                        {{ $value }}
                    @endif
                @else
                    <span class="text-muted">N/A</span>
                @endif
            </td> -->
        @endforeach
        
        <td>{{ $submission->created_at->format('Y-m-d H:i') }}</td>
        <td><a href="{{ route('user-form-data.edit', $submission) }}" class="btn btn-sm btn-primary">
    Edit
</a></td>
    </tr>
@endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>


    <a href="{{ route('forms.fields.create', $form) }}" class="btn btn-success">Add New Field</a>

    <div class="card">
        <div class="card-header">
            Form Fields

        </div>
        <div class="card-body">

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Label</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Category</th>
                        <th>Required</th>
                        <th>Order</th>
                        <th>Actions</th> <!-- New column for Edit button -->
                    </tr>
                </thead>
                <tbody>
                    @foreach($form->fields as $field)
                        <tr>
                            <td>{{ $field->label }}</td>
                            <td>{{ $field->name }}</td>
                            <td>{{ $field->type }}</td>
                            <td>{{ ucfirst($field->category) }}</td>
                            <td>{{ $field->is_required ? 'Yes' : 'No' }}</td>
                            <td>{{ $field->order }}</td>
                            <td>
                                <!-- Edit Field Button -->
                                <a href="{{ route('forms.fields.edit', [$form, $field]) }}" 
                                   class="btn btn-sm btn-info">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection