<div class="modal-dialog">
    <form wire:submit.prevent="create">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('jetadmin.create_category') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('jetadmin.close') }}"></button>
            </div>
            <div class="modal-body">

                <div class="mb-3">
                    <label class="form-label" for="title">{{ __('jetadmin.title') }}</label>
                    <input type="text" wire:model="title" class="form-control @error('title') is-invalid @enderror" name="title" placeholder="{{ __('jetadmin.title') }}">
                    @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="type">{{ __('jetadmin.type') }}</label>
                    <select wire:model="type" class="form-control @error('type') is-invalid @enderror" name="type">
                        <option></option>
                        @foreach(__('jetadmin.category_types') as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    @error('type')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="type">{{ __('jetadmin.language') }}</label>
                    <select wire:model="language" class="form-control @error('language') is-invalid @enderror" name="language">
                        <option></option>
                        @foreach(config('laravellocalization.supportedLocales') as $key => $value)
                            <option value="{{ $key }}">{{ config('laravellocalization.supportedLocales.'.$key.'.name') }}</option>
                        @endforeach
                    </select>
                    @error('type')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="description">{{ __('jetadmin.description') }}</label>
                    <textarea wire:model="description" class="form-control @error('description') is-invalid @enderror" name="description"></textarea>
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('jetadmin.close') }}</button>
                <button type="submit" class="btn btn-primary">{{ __('jetadmin.create') }}</button>
            </div>
        </div>
    </form>
</div>

