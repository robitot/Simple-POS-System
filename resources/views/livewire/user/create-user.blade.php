<div>

    <div style="background-color: white;border:2px solid black" class="p-4 rounded-3 d-flex flex-column gap-3 w-100 shadow-sm mb-4">
        @include('components.infor', ['title' => 'Fill up the following details'])

        <form wire:submit='create'>

            @include('livewire.auth.components.login-credentials')

            <div class="form-floating mb-3">

                <select style="padding-top:.625rem" wire:model='role' class="form-select"
                    aria-label="Default select example">
                    <option value="" selected>Select Role</option>
                    <option value="cashier">Cashier</option>
                    <option value="admin">Admin</option>
                </select>

                @error('role')
                    <span class="text-danger text-sm">{{ $message }}</span>
                @enderror
            </div>

            @include('livewire.auth.components.user-details')

            @include('components.create-btn', [
                'btnTitle' => 'Create',
            ])

        </form>

    </div>

    <x-toast-2 successTitle="User created successfully" errorTitle="User failed to create"
        successTrigger="user-successfully-successfully" errorTrigger="user-failed-to-create" />
</div>
