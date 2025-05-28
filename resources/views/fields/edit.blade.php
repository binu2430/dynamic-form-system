@extends('layouts.app')

@section('content')
    <h1>Edit Field: {{ $field->label }}</h1>

    <form action="{{ route('forms.fields.update', [$form, $field]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="label" class="form-label">Label</label>
            <input type="text" class="form-control" id="label" name="label" value="{{ $field->label }}" required>
        </div>
        <div class="mb-3">
            <label for="type" class="form-label">Field Type</label>
            <select class="form-select" id="type" name="type" required>
                @foreach($fieldTypes as $type)
                    <option value="{{ $type }}" {{ $field->type === $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3" id="options-container" style="{{ $field->type === 'select' ? 'display: block;' : 'display: none;' }}">
            <label for="options" class="form-label">Options (comma separated)</label>
            <input type="text" class="form-control" id="options" name="options" 
                   value="{{ $field->type === 'select' && $field->options ? implode(',', $field->options) : '' }}">
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select class="form-select" id="category" name="category" required>
                @foreach($categories as $category)
                    <option value="{{ $category }}" {{ $field->category === $category ? 'selected' : '' }}>{{ ucfirst($category) }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="is_required" name="is_required" {{ $field->is_required ? 'checked' : '' }}>
            <label class="form-check-label" for="is_required">Required</label>
        </div>
        <div class="mb-3">
            <label for="order" class="form-label">Order</label>
            <input type="number" class="form-control" id="order" name="order" value="{{ $field->order }}">
        </div>
        <button type="submit" class="btn btn-primary">Update Field</button>
    </form>

    @push('scripts')
        <script>
            document.getElementById('type').addEventListener('change', function() {
                const optionsContainer = document.getElementById('options-container');
                optionsContainer.style.display = this.value === 'select' ? 'block' : 'none';
            });
        </script>
    @endpush
@endsection