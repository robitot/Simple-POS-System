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
        <button type="submit" class="btn btn-primary w-100" wire:loading.attr="disabled"
            wire:click.prevent="authenticate" @if ($cooldownUntil) disabled @endif>

            <span wire:loading.remove>
                @if ($cooldownUntil)
                    Try again in <span id="cooldown-timer">{{ $remainingSeconds }}</span>s
                @else
                    Login
                @endif
            </span>

            <span wire:loading>
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </span>
        </button>
        @if (session('success'))
            <span class="text-success text-center w-100">{{ session('success') }}</span>
        @elseif(session('error'))
            <span class="text-danger text-center w-100">{{ session('error') }}</span>
        @endif
        <span style="color:White">Forgot password? <a href="{{route('forgotPassword')}}">Click here</a></span>
    </div>
    <script>
        document.addEventListener('livewire:init', () => {
            setInterval(() => {
                const timerEl = document.getElementById('cooldown-timer');
                if (timerEl) {
                    const current = parseInt(timerEl.textContent);
                    if (current > 0) {
                        timerEl.textContent = current - 1;
                    } else if (@this.cooldownUntil) {
                        @this.checkCooldown();
                    }
                }
            }, 1000);
        });
    </script>
</div>
