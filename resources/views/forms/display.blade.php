@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>{{ $form->name }}</h2>
                    <p class="mb-0">Country: {{ config('countries')[$form->country_code] }}</p>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('forms.submit', $form) }}">
                        @csrf

                        @foreach($form->fields as $field)
                            <div class="mb-3">
                                <label for="{{ $field->name }}" class="form-label">
                                    {{ $field->label }}
                                    @if($field->is_required)
                                        <span class="text-danger">*</span>
                                    @endif
                                </label>

                                @if($field->type === 'select')
                                    <select class="form-control @error($field->name) is-invalid @enderror" 
                                            id="{{ $field->name }}" 
                                            name="{{ $field->name }}"
                                            {{ $field->is_required ? 'required' : '' }}>
                                        <option value="">Select an option</option>
                                        @foreach($field->options as $option)
                                            <option value="{{ $option }}" {{ old($field->name) == $option ? 'selected' : '' }}>
                                                {{ $option }}
                                            </option>
                                        @endforeach
                                    </select>
                                @elseif($field->type === 'textarea')
                                    <textarea class="form-control @error($field->name) is-invalid @enderror" 
                                              id="{{ $field->name }}" 
                                              name="{{ $field->name }}"
                                              rows="3"
                                              {{ $field->is_required ? 'required' : '' }}>{{ old($field->name) }}</textarea>
                                @else
                                    <input type="{{ $field->type }}" 
                                           class="form-control @error($field->name) is-invalid @enderror" 
                                           id="{{ $field->name }}" 
                                           name="{{ $field->name }}"
                                           value="{{ old($field->name) }}"
                                           {{ $field->is_required ? 'required' : '' }}>
                                @endif

                                @error($field->name)
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        @endforeach

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection