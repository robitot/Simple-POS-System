<div>

    @include('livewire.auth.components.register-sub-title')

    {{-- @if ($page === 1) --}}
        @include('livewire.auth.components.login-credentials')
    {{-- @elseif($page === 2) --}}
        @include('livewire.auth.components.user-details')
    {{-- @elseif($page === 3) --}}
        @include('livewire.auth.components.store-details')
    {{-- @endif --}}
    
    <div class="d-flex flex-column gap-2  ">
        @if ($page === 1)
            <div class="d-flex justify-content-end">
                <button class="btn btn-primary" wire:click.prevent='nextPage(true)'>
                    Next
                </button>
            </div>
        @elseif($page === 2)
            <div class="d-flex justify-content-between">
                <button class="btn btn-primary" wire:click.prevent='nextPage(false)'>
                    Back
                </button>
                <button class="btn btn-primary" wire:click.prevent='nextPage(true)'>
                    Next
                </button>
            </div>
        @elseif($page === 3)
            <div class="d-flex justify-content-between">
                <button class="btn btn-primary" wire:click.prevent='nextPage(false)'>
                    Back
                </button>
                <button wire:loading.attr="disbaled" wire:loading.class="opacity-50" wire:click.prevent="createAccount"
                    class="btn btn-primary  fw-bold">
                    <span wire:loading.remove>Register</span>
                    <div wire:loading class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </button>
            </div>
        @endif

        @if (session('success'))
            <span class="text-success text-center w-100">{{ session('success') }}</span>
        @endif

        <span class="mt-3">Already have an account? <a href="{{ route('login') }}" wire:navigate>Login here</a></span>
    </div>
</div>
