@extends('layouts.app')

@section('content')
    <h1>Create New Form</h1>

    <form action="{{ route('forms.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Form Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="country_code" class="form-label">Country</label>
            <select class="form-select" id="country_code" name="country_code" required>
                @foreach($countries as $code => $name)
                    <option value="{{ $code }}">{{ $name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Create Form</button>
    </form>
@endsection