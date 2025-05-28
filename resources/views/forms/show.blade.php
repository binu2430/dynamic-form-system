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
        </div>
    </div>



    <!-- New submissions card -->
    
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
                                @foreach($form->fields as $field)
                                    <th>{{ $field->label }}</th>
                                @endforeach
                                <th>Submitted At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($form->submissions as $submission)
                                <tr>
                                    <td>
                                        {{ $submission->user ? $submission->user->name : 'Guest' }}
                                    </td>
                                    @foreach($form->fields as $field)
                                        <td>
                                            {{ $submission->data[$field->name] ?? '' }}
                                        </td>
                                    @endforeach
                                    <td>
                                        {{ $submission->created_at->format('Y-m-d H:i') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>


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
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection