<div class="modal-dialog">
    <form wire:submit.prevent="edit">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('jetadmin::jetadmin.edit_faq') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('jetadmin::jetadmin.close') }}"></button>
            </div>
            <div class="modal-body">

                <div class="mb-3">
                    <label class="form-label" for="description">{{ __('jetadmin::jetadmin.question') }}</label>
                    <textarea wire:model="question" class="form-control @error('question') is-invalid @enderror" name="question"></textarea>
                    @error('question')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="description">{{ __('jetadmin::jetadmin.answer') }}</label>
                    <textarea wire:model="answer" class="form-control @error('answer') is-invalid @enderror" name="answer"></textarea>
                    @error('answer')
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

