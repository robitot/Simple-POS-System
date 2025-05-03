@extends('components.container')

@section('section')
    @include('components.infor', ['title' => 'Fill up the following'])

    <form wire:submit='create' class="w-100 d-flex flex-column gap-4">

        <div class="d-flex flex-column gap-2">
            <div class="mb-3 d-flex justify-content-center align-items-center w-100">
                @if ($image)
                    <img wire:loading.remove src="{{ $image->temporaryUrl() }}" alt="Image Preview" class="img-thumbnail"
                        style="max-width: 400px; max-height: 300px;">
                    <div wire:loading class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                @else
                    <img wire:loading.remove
                        src="https://static.vecteezy.com/system/resources/thumbnails/008/695/917/small_2x/no-image-available-icon-simple-two-colors-template-for-no-image-or-picture-coming-soon-and-placeholder-illustration-isolated-on-white-background-vector.jpg"
                        alt="Image Preview" class="img-thumbnail" style="max-width: 400px; max-height: 300px;">
                    <div wire:loading class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                @endif
            </div>

            <div class="form-floating">
                <input wire:model="image" name="image" type="file" class="form-control" id="floatingInput"
                    placeholder="name@example.com">
                <label for="floatingInput">Image</label> @error('image')
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

                <select style="padding-top:.625rem" wire:model='categoryId' class="form-select"
                    aria-label="Default select example">
                    <option value="{{ null }}" selected>Select Category</option>

                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach

                </select>

                <div class="form-floating">
                    <textarea wire:model.defer="description" class="form-control" placeholder="Leave a comment here" id="floatingTextarea2"
                        style="height: 100px"></textarea>
                    <label for="floatingTextarea2">Description</label>
                    @error('description')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            @include('components.create-btn', [
                'btnTitle' => 'Create',
            ])

        </div>

    </form>

    <x-toast-2 successTitle="Product created successfully" errorTitle="Product failed to create"
        successTrigger="drink-successfully-successfully" errorTrigger="drink-failed-to-create" />
@endsection
