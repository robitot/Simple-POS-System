<div class="">

    <div class="d-flex flex-column">

        <div class="form-floating mb-3 w-100">
            <input name="starting_cash" wire:model='starting_cash' type="number" class="form-control w-full" id="floatingInput"
                placeholder="name@example.com">
            <label for="floatingInput">Shift Cash</label>
            @error('starting_cash')
                <span class="text-danger text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="d-flex justify-content-end align-items-end  gap-4 w-100">

            <button class="btn btn-primary w-100" style="width: 206px" wire:click.prevent="startPOS" wire:loading.class="opacity-50" wire:loading.attr="disabled">
                Submit
            </button>

        </div>
    </div>

</div>


<script>
    function goBack() {
    window.history.back();
}

</script>
