<div class="modal-dialog">
    <form wire:submit.prevent="ban">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('jetadmin.ban') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('jetadmin.close') }}"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label" for="comment">{{ __('jetadmin.comment') }}</label>
                    <input type="comment" wire:model="comment" class="form-control @error('comment') is-invalid @enderror" name="comment" placeholder="{{ __('jetadmin.comment') }}">
                    @error('comment')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="expire">{{ __('jetadmin.expire') }}</label>
                    <input type="date" wire:model="expire" class="form-control @error('expire') is-invalid @enderror" name="expire" placeholder="{{ __('jetadmin.expire') }}">
                    @error('expire')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="permanent">{{ __('jetadmin.permanent') }}</label>
                    <input type="checkbox" wire:model="expire" class="@error('permanent') is-invalid @enderror" name="permanent" placeholder="{{ __('jetadmin.permanent') }}">
                    @error('permanent')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('jetadmin.close') }}</button>
                @if($user->isNotBanned())
                    <button type="submit" class="btn btn-primary">{{ __('jetadmin.ban') }}</button>
                @endif
                @if($user->isBanned())
                    <button type="button" wire:click="unban()" class="btn btn-success">{{ __('jetadmin.unban') }}</button>
                @endif
            </div>
        </div>
    </form>
</div>
