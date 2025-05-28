@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2>Edit Submission</h2>
                    <a href="{{ route('forms.show', $submission->form) }}" class="btn btn-secondary">
                        Back to Form
                    </a>
                </div>

                <div class="card-body">
                    <p class="text-muted">
                        Editing submission from {{ $submission->created_at->format('M d, Y H:i') }}
                    </p>

                    <form method="POST" action="{{ route('user-form-data.update', $submission) }}">
                        @csrf
                        @method('PUT')

                        @foreach($form->fields as $field)
                            @php
                                $config = $fieldConfigs[$field->name] ?? null;
                                $currentValue = $data[$field->name] ?? null;
                            @endphp

                            @if($config)
                                <div class="mb-3">
                                    <label for="{{ $field->name }}" class="form-label">
                                        {{ $config['label'] }}
                                        @if($config['is_required'])
                                            <span class="text-danger">*</span>
                                        @endif
                                    </label>

                                    @if($config['type'] === 'select')
                                        <select class="form-control @error($field->name) is-invalid @enderror" 
                                                id="{{ $field->name }}" 
                                                name="{{ $field->name }}"
                                                {{ $config['is_required'] ? 'required' : '' }}>
                                            <option value="">Select an option</option>
                                            @foreach($config['options'] ?? [] as $option)
                                                <option value="{{ $option }}" 
                                                    {{ $currentValue == $option ? 'selected' : '' }}>
                                                    {{ $option }}
                                                </option>
                                            @endforeach
                                        </select>
                                    @elseif($config['type'] === 'textarea')
                                        <textarea class="form-control @error($field->name) is-invalid @enderror" 
                                                  id="{{ $field->name }}" 
                                                  name="{{ $field->name }}"
                                                  rows="3"
                                                  {{ $config['is_required'] ? 'required' : '' }}>{{ $currentValue }}</textarea>
                                    @else
                                        <input type="{{ $config['type'] }}" 
                                               class="form-control @error($field->name) is-invalid @enderror" 
                                               id="{{ $field->name }}" 
                                               name="{{ $field->name }}"
                                               value="{{ $currentValue }}"
                                               {{ $config['is_required'] ? 'required' : '' }}>
                                    @endif

                                    @error($field->name)
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            @endif
                        @endforeach

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Update Submission</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection