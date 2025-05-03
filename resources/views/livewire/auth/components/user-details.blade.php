<div class="form-floating mb-3">
    <input wire:model="fullName" name="fullName" type="text" class="form-control"
        placeholder="name@example.com">
    <label for="floatingInput">Full name</label> @error('fullName')
        <span class="text-danger fs-6">{{ $message }}</span>
    @enderror

</div>

<div class="form-floating mb-3">
    <input wire:model="address" name="address" type="text" class="form-control" id="floatingInput"
        placeholder="name@example.com">
    <label for="floatingInput">Address</label> @error('address')
        <span class="text-danger fs-6">{{ $message }}</span>
    @enderror
</div>

<div class="form-floating mb-3">
    <input wire:model="phone" name="phone" type="text" class="form-control" id="floatingInput"
        placeholder="name@example.com">
    <label for="floatingInput">Phone no.</label> @error('phone')
        <span class="text-danger fs-6">{{ $message }}</span>
    @enderror
</div>
