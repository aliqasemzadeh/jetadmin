<div class="modal-dialog">
    <form wire:submit.prevent="edit">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('jetadmin::jetadmin.edit_role') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('jetadmin::jetadmin.close') }}"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label" for="name">{{ __('jetadmin::jetadmin.name') }}</label>
                    <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="{{ __('jetadmin::jetadmin.name') }}">
                    <small class="form-hint">{{ __('jetadmin::jetadmin.roles.'.$name) }}</small>
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('jetadmin::jetadmin.close') }}</button>
                <button type="submit" class="btn btn-primary">{{ __('jetadmin::jetadmin.edit') }}</button>
            </div>
        </div>
    </form>
</div>

