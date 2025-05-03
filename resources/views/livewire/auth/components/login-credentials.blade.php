<div class="form-floating mb-3">
    <input name="email" wire:model="email" type="email" class="form-control" placeholder="name@example.com">
    <label for="floatingInput">Email</label>

    @error('email')
        <span class="text-danger text-sm">{{ $message }}</span>
    @enderror
</div>

<div class="form-floating mb-3 w-100">
    <input name="password" wire:model="password" name="password" type="password" class="form-control" id="floatingInput"
        placeholder="name@example.com">
    <label for="floatingInput">Password</label>
    @error('password')
        <span class="text-danger text-sm">{{ $message }}</span>
    @enderror
</div>

<div class="form-floating mb-3 w-100">
    <input type="password" class="form-control" wire:model="confirmPassword" name="password_confirmation"
        id="floatingInput" placeholder="name@example.com">
    <label for="floatingInput">Confirm Password</label>
</div>
