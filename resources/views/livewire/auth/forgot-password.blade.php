<div>
    <div class="form-floating mb-3">

        @if ($page == 1)
            <input name="email" wire:model='email' type="email" class="form-control" id="floatingInput"
                placeholder="name@example.com">
            <label for="floatingInput">Email</label>
            @error('email')
                <span class="text-danger text-sm">{{ $message }}</span>
            @enderror
        @elseif($page == 2)
            <input name="code" wire:model='userCode' type="text" class="form-control" id="floatingInput"
                placeholder="code">
            <label for="floatingInput">Code</label>
            @error('code')
                <span class="text-danger text-sm">{{ $message }}</span>
            @enderror
        @elseif($page == 3)
            <div class="form-floating mb-3">
                <input name="password" wire:model='password' type="password" class="form-control" id="passwordInput"
                    placeholder="Password">
                <label for="passwordInput">Password</label>
                @error('password')
                    <span class="text-danger text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-floating mb-3">
                <input name="confirmPassword" wire:model='confirmPassword' type="password" class="form-control"
                    id="confirmPasswordInput" placeholder="Confirm Password">
                <label for="confirmPasswordInput">Confirm Password</label>
                @error('confirmPassword')
                    <span class="text-danger text-sm">{{ $message }}</span>
                @enderror
            </div>
        @endif


    </div>

    <div class="d-flex flex-column gap-2  ">

        @if ($page == 1)
            <button type="submit" class="btn btn-primary w-100" wire:loading.attr="disabled"
                wire:click.prevent="verifyEmail">

                <span wire:loading.remove>
                    Verify Email
                </span>

                <span wire:loading>
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </span>
            </button>
        @elseif($page == 2)
            <button type="submit" class="btn btn-primary w-100" wire:loading.attr="disabled"
                wire:click.prevent="verifyCode">

                <span wire:loading.remove>
                    Verify Code
                </span>

                <span wire:loading>
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </span>
            </button>
        @elseif($page == 3)
            <button type="submit" class="btn btn-primary w-100" wire:loading.attr="disabled"
                wire:click.prevent="changePassword">

                <span wire:loading.remove>
                    Change Password
                </span>

                <span wire:loading>
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </span>
            </button>
        @endif


        @if (session('success'))
            <span class="text-success text-center w-100">{{ session('success') }}</span>
        @elseif(session('error'))
            <span class="text-danger text-center w-100">{{ session('error') }}</span>
        @endif

    </div>

</div>
