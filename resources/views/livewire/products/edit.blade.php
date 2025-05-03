@extends('components.container')

@section('section')
    @include('components.infor', ['title' => 'Edit the following'])

    <form wire:submit='edit' class="w-100 d-flex flex-column gap-4">

        <div class="d-flex flex-column gap-4">
            <div class="mb-3 d-flex justify-content-center align-items-center w-100">
                @if ($newImg)
                    <!-- Show temporary upload preview -->
                    <img wire:loading.remove src="{{ $newImg->temporaryUrl() }}" alt="New Image Preview" class="img-thumbnail"
                        style="max-width: 400px; max-height: 300px;">
                @elseif($image)
                    <!-- Show existing stored image -->
                    <img wire:loading.remove src="{{ Storage::url($image) }}" alt="Current Product Image"
                        class="img-thumbnail" style="max-width: 400px; max-height: 300px;">
                @else
                    <!-- Show placeholder -->
                    <img wire:loading.remove src="https://via.placeholder.com/300x200?text=No+Image" alt="Image Preview"
                        class="img-thumbnail" style="max-width: 400px; max-height: 300px;">
                @endif

                <div wire:loading wire:target="newImg" class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>

            <div class="form-floating">
                <input wire:model="newImg" name="newImg" type="file" class="form-control" id="floatingInput"
                    accept="image/*">
                <label for="floatingInput">Image</label>
                @error('newImg')
                    <span class="text-danger fs-6">{{ $message }}</span>
                @enderror
            </div>


        </div>

        <div class="d-flex flex-column gap-4 w-100 justify-content-between">
            <div class="d-flex flex-column gap-4 w-100">
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

                <div class="form-floating">
                    <select wire:model='categoryId' class="form-select fotm-control" aria-label="Default select example">
                        <option value="" selected>Select Category</option>

                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <label for="floatingInputDisabled">Category</label>
                </div>


                <div class="form-floating">
                    <textarea wire:model.defer="description" class="form-control" placeholder="Leave a comment here" id="floatingTextarea2"
                        style="height: 100px"></textarea>
                    <label for="floatingTextarea2">Description</label>
                    @error('description')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <div class="d-flex gap-4 form-control">
                        <div class="form-check">
                            <input wire:model="isActive" class="form-check-input bg-success border-success" type="radio"
                                name="exampleRadios" id="exampleRadios1" value="1">
                            <label class="form-check-label" for="exampleRadios1">
                                Active
                            </label>
                        </div>
                        <div class="form-check">
                            <input wire:model="isActive" class="form-check-input bg-danger border-danger" type="radio"
                                name="exampleRadios" id="exampleRadios2" value="0">
                            <label class="form-check-label" for="exampleRadios2">
                                Inactive
                            </label>
                        </div>

                    </div>
                    <label for="floatingInputDisabled">Status</label>
                </div>

                @include('components.create-btn', [
                    'btnTitle' => 'Edit',
                ])

            </div>


        </div>

    </form>

    <x-toast-2 successTitle="Product edited successfully" errorTitle="Product failed to edit"
        successTrigger="drink-edited-successfully" errorTrigger="drink-failed-to-edit" />
@endsection
