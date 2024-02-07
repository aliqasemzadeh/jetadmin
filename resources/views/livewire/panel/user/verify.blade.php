<div>
    <x-slot name="title">
        {{ __('jetadmin::jetadmin.account_verify') }}
    </x-slot>

    {{ $random_string }}
    <div class="row row-cards">
        <livewire:panel.user.verify.upload-id-card-file :random_string="$random_string"  />
        <livewire:panel.user.verify.upload-verify-file :random_string="$random_string" />
        <div class="col-md-6 col-xl-12">
            <form  wire:submit.prevent="verify_request" class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('jetadmin::jetadmin.personal_information') }}</h4>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">{{ __('jetadmin::jetadmin.first_name') }}</label>
                                <input type="text" class="form-control" name="example-text-input">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">{{ __('jetadmin::jetadmin.last_name') }}</label>
                                <input type="text" class="form-control" name="example-text-input">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">{{ __('jetadmin::jetadmin.national_code') }}</label>
                                <input type="text" class="form-control" name="example-text-input">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">{{ __('jetadmin::jetadmin.birth_at') }}</label>
                                <input type="text" class="form-control" name="example-text-input">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">{{ __('jetadmin::jetadmin.phone') }}</label>
                                <input type="text" class="form-control" name="example-text-input">
                            </div>
                        </div>

                        <div class="col-md-6"> </div>
                    </div>

                </div>
                <div class="card-footer">
                        <a href="#" class="btn btn-primary me-auto">{{ __('jetadmin::jetadmin.save') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
