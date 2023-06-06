<div class="modal-dialog">
    <form wire:submit.prevent="create">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('jetadmin::bap.create_permission') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('jetadmin::bap.close') }}"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label" for="name">{{ __('jetadmin::bap.name') }}</label>
                    <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="{{ __('jetadmin::bap.name') }}">
                    <small class="form-hint">{{ __('permissions.'.$name) }}</small>
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('jetadmin::bap.close') }}</button>
                <button type="submit" class="btn btn-primary">{{ __('jetadmin::bap.create') }}</button>
            </div>
        </div>
    </form>
</div>

