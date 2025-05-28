@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Forms</h1>
        <a href="{{ route('forms.create') }}" class="btn btn-primary">Create </a>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Country</th>
                <th>Fields</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($forms as $form)
                <tr>
                    <td>{{ $form->id }}</td>
                    <td>{{ $form->name }}</td>
                    <td>{{ $form->country_code }}</td>
                    <td>{{ $form->fields->count() }}</td>
                    <td>{{ $form->is_active ? 'Active' : 'Inactive' }}</td>
                    <td>
                        <a href="{{ route('forms.edit', $form) }}" class="btn btn-sm btn-info">Edit</a>
                        <!-- <a href="{{ route('forms.show', $form) }}" class="btn btn-sm btn-secondary">View</a> -->
                        <form action="{{ route('forms.destroy', $form) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                        @if($form->fields->count() >0)
                        <a href="{{ route('forms.display', $form) }}" class="btn btn-sm btn-primary">Add Form data</a>
                    @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection