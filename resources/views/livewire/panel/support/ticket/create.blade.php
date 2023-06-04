<div>
    <x-slot name="title">
        {{ __('jetadmin.create_ticket') }}
    </x-slot>
    <x-slot name="breadcrumb">
        <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
            <li class="breadcrumb-item"><a href="{{ route('panel.dashboard.index') }}">{{ __('jetadmin.dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('panel.support.ticket.index') }}">{{ __('jetadmin.tickets') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('panel.support.ticket.create') }}">{{ __('jetadmin.create_ticket') }}</a></li>
        </ol>
    </x-slot>

    <div class="row row-cards">
        <div class="col-12">
            <form wire:submit.prevent="create" class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('jetadmin.create_ticket') }}</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label" for="title">{{ __('jetadmin.title') }}</label>
                        <input type="text" wire:model="title" class="form-control @error('title') is-invalid @enderror" name="title" placeholder="{{ __('jetadmin.title') }}">
                        @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="category_id">{{ __('jetadmin.category') }}</label>

                            <select wire:model="category_id" class="form-control @error('category_id') is-invalid @enderror" name="category_id">
                                <option></option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                                @endforeach
                            </select>

                        @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="description">{{ __('jetadmin.body') }}</label>
                        <textarea wire:model="body" class="form-control @error('body') is-invalid @enderror" name="body"></textarea>
                        @error('body')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-label">{{ __('jetadmin.files') }}</div>
                        <input type="file" multiple wire:model="files" class="form-control @error('files') is-invalid @enderror" name="files">
                        @error('files')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
                <div class="card-footer text-end">
                    <div class="d-flex">
                        <button type="submit" class="btn btn-primary ms-auto">{{ __('jetadmin.create') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
