    <div class="d-flex justify-content-center">

        <div class="d-flex flex-column  justify-content-center align-items-center  w-100 rounded p-4"
          >

            <div class="form-floating mb-3 w-100">

                <input name="endingCash" wire:model='endingCash' type="number" class="form-control" id="floatingInput"
                    placeholder="name@example.com">
                <label for="floatingInput">Ending Cash</label>
                @error('endingCash')
                    <span class="text-danger text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="d-flex justify-content-end align-items-end  gap-4 w-100">

                <button class="btn btn-primary w-100" style="width: 206px" wire:click.prevent="endPOS"
                    wire:loading.class="opacity-50" wire:loading.attr="disabled">
                    Submit
                </button>

            </div>
            @if (session()->has('error'))
                <div class="alert alert-danger mt-5 fs-7">
                    {{ session('error') }}
                </div>
            @endif

        </div>

    </div>


    <script>
        function goBack() {
            window.history.back();
        }
    </script>
