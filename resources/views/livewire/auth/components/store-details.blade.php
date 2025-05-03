<div class="form-floating mb-3">
    <input wire:model="register.storeName" name="storeName" type="email" class="form-control" id="floatingInput"
        placeholder="name@example.com">
    <label for="floatingInput">Store name</label> @error('register.storeName')
        <span class="text-danger fs-6">{{ $message }}</span>
    @enderror

</div>

<div class="form-floating mb-3">
    <input wire:model="register.logo" name="logo" type="file" class="form-control" id="floatingInput"
        placeholder="name@example.com">
    <label for="floatingInput">Logo</label> @error('register.logo')
        <span class="text-danger fs-6">{{ $message }}</span>
    @enderror
</div>