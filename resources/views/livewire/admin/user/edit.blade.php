<div class="modal-dialog">
    <form wire:submit.prevent="edit">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('jetadmin::bap.edit_user') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('jetadmin::bap.close') }}"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label" for="email">{{ __('jetadmin::bap.email') }}</label>
                    <input type="email" wire:model="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="{{ __('jetadmin::bap.email') }}">
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="first_name">{{ __('jetadmin::bap.first_name') }}</label>
                    <input type="text" wire:model="first_name" class="form-control @error('first_name') is-invalid @enderror" name="first_name" placeholder="{{ __('jetadmin::bap.first_name') }}">
                    @error('first_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="last_name">{{ __('jetadmin::bap.last_name') }}</label>
                    <input type="text" wire:model="last_name" class="form-control @error('last_name') is-invalid @enderror" name="last_name" placeholder="{{ __('jetadmin::bap.last_name') }}">
                    @error('last_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="title">{{ __('jetadmin::bap.title') }}</label>
                    <input type="text" wire:model="title" class="form-control @error('title') is-invalid @enderror" name="title" placeholder="{{ __('jetadmin::bap.title') }}">
                    @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="password">{{ __('jetadmin::bap.password') }}</label>
                    <input type="password" wire:model="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="{{ __('jetadmin::bap.password') }}">
                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('jetadmin::bap.close') }}</button>
                <button type="submit" class="btn btn-primary">{{ __('jetadmin::bap.edit') }}</button>
            </div>
        </div>
    </form>
</div>

