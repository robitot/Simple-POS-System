<div class="rounded p-4 mb-5 d-flex flex-column gap-4" style="background-color:white;border:2px solid black!important">

    <div class="d-flex gap-2 align-items-center">
        <i class="fa-solid fa-circle-info"></i>

        <span>Edit Information</span>
    </div>

    <form wire:submit='edit' class="w-100 d-flex flex-column gap-2">

        <div class="d-flex justify-content-center gap-4">

            <div class="w-100 d-flex flex-column gap-2">
                @include('components.input', [
                    'model' => 'name',
                    'type' => 'text',
                    'label' => 'Name',
                ])

                @include('components.input', [
                    'model' => 'qty',
                    'type' => 'number',
                    'label' => 'Quantity',
                ])

                @include('components.input', [
                    'model' => 'price',
                    'type' => 'number',
                    'label' => 'Price',
                ])



                <div class="form-floating mb-3 mt-3">
                    <select  wire:model='uom' class="form-select"
                        aria-label="Default select example">
                        <option value="" selected>Select UOM</option>
                        <option value="KG">KG</option>
                        <option value="MG">MG</option>
                        <option value="PCS">PCS</option>
                        <option value="ML">ML</option>
                        <option value="LITERS">LITERS</option>
                    </select>
                    <label for="floatingInput">UOM</label> @error('newImg')
                        <span class="text-danger fs-6">{{ $message }}</span>
                    @enderror
                </div>

            </div>
        </div>


        @include('components.create-btn', [
            'btnTitle' => 'Edit',
        ])
    </form>


</div>
