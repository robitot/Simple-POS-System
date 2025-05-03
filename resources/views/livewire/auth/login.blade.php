<div>
    <div class="form-floating mb-3">
        <input name="email" wire:model='email' type="email" class="form-control" id="floatingInput"
            placeholder="name@example.com">
        <label for="floatingInput">Email</label>
        @error('email')
            <span class="text-danger text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-floating mb-3">
        <input name="password" wire:model='password' type="password" class="form-control" id="floatingInput"
            placeholder="name@example.com">
        <label for="floatingInput">Password</label>
        @error('password')
            <span class="text-danger text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div class="d-flex flex-column gap-2  ">
        <button wire:loading.attr='disabled' wire:loading.class='opacity-50' wire:click.prevent='authenticate' class="btn btn-primary w-100 fw-bold">
            <span wire:loading.remove>Log in</span>
            <div wire:loading class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
        </button>
        @if (session('success'))
            <span class="text-success text-center w-100">{{ session('success') }}</span>
        @elseif(session('error'))
            <span class="text-danger text-center w-100">{{ session('error') }}</span>
        @endif
        {{-- <span>Don't have an account? <a href="{{ route('register') }}" wire:navigate>Create here</a></span>
        <span>Forgot password? <a href="#">Click here</a></span> --}}
    </div>

</div>
