<div class="modal-dialog modal-xl">
    <form wire:submit.prevent="create">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('jetadmin::jetadmin.create_carousel') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('jetadmin::jetadmin.close') }}"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">

                        <div class="mb-3">
                            <label class="form-label" for="title">{{ __('jetadmin::jetadmin.title') }}</label>
                            <input type="text" wire:model="title" class="form-control @error('title') is-invalid @enderror" name="title" placeholder="{{ __('jetadmin::jetadmin.title') }}">
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-label">{{ __('jetadmin::jetadmin.image') }}</div>
                            <input type="file" wire:model="image" class="form-control @error('image') is-invalid @enderror" name="image">
                            @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="type">{{ __('jetadmin::jetadmin.language') }}</label>
                            <select wire:model="language" class="form-control @error('language') is-invalid @enderror" name="language">
                                <option></option>
                                @foreach(config('laravellocalization.supportedLocales') as $key => $value)
                                    <option value="{{ $key }}">{{ config('laravellocalization.supportedLocales.'.$key.'.name') }}</option>
                                @endforeach
                            </select>
                            @error('language')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="description">{{ __('jetadmin::jetadmin.description') }}</label>
                            <textarea wire:model="description" class="form-control @error('description') is-invalid @enderror" name="description"></textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="title">{{ __('jetadmin::jetadmin.link') }}</label>
                            <input type="text" wire:model="link" class="form-control @error('link') is-invalid @enderror" name="link" placeholder="{{ __('jetadmin::jetadmin.link') }}">
                            @error('link')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('jetadmin::jetadmin.close') }}</button>
                <button type="submit" class="btn btn-primary">{{ __('jetadmin::jetadmin.create') }}</button>
            </div>
        </div>
    </form>
</div>

