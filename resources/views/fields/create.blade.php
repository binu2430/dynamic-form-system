@extends('layouts.app')

@section('content')
    <h1>Add Field to: {{ $form->name }}</h1>

    <form action="{{ route('forms.fields.store', $form) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="label" class="form-label">Label</label>
            <input type="text" class="form-control" id="label" name="label" required>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Field Name (snake_case)</label>
            <input type="text" class="form-control" id="name" name="name" required>
            <small class="text-muted">Only letters and underscores, no spaces</small>
        </div>
        <div class="mb-3">
            <label for="type" class="form-label">Field Type</label>
            <select class="form-select" id="type" name="type" required>
                @foreach($fieldTypes as $type)
                    <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3" id="options-container" style="display: none;">
            <label for="options" class="form-label">Options (comma separated)</label>
            <input type="text" class="form-control" id="options" name="options">
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select class="form-select" id="category" name="category" required>
                @foreach($categories as $category)
                    <option value="{{ $category }}">{{ ucfirst($category) }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="is_required" name="is_required">
            <label class="form-check-label" for="is_required">Required</label>
        </div>
        <div class="mb-3">
            <label for="order" class="form-label">Order</label>
            <input type="number" class="form-control" id="order" name="order" value="0">
        </div>
        <button type="submit" class="btn btn-primary">Add Field</button>
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