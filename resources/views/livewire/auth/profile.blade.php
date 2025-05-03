<div>

    @if ($isLoading)
        <p>loading</p>
    @else
        @include('components.page-main-title', [
            'title' => 'Profile',
            'subTitle' => 'You can edit your profile here',
            'isWithBtn' => false,
            'link' => 'profile',
        ])

        <form wire:submit.prevent="editProfile">

            <div style="background-color: white" class="p-4 rounded-3 d-flex flex-column gap-3 w-100 shadow-sm mb-4">

                @include('components.infor', ['title' => 'Personal information'])

                <div class="d-flex gap-4 w-100 justify-content-around flex-column flex-sm-row">

                    <div class="d-flex flex-column gap-2 justify-content-center align-items-center">
                        <img src="{{ Storage::url($avatar) }}" alt="img" width="200" height="200" class="rounded">
                        <div class="form-floating mb-3">
                            <input wire:model="newAvatar" name="newAvatar" type="file" class="form-control"
                                id="floatingInput" placeholder="name@example.com">
                            <label for="floatingInput">Upload avatar</label> @error('logo')
                                <span class="text-danger fs-6">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex flex-column gap-1 w-100">
                        <div class="form-floating mb-3">
                            <input wire:model="name" name="fullName" type="text" class="form-control"
                                placeholder="name@example.com">
                            <label for="floatingInput">Full name</label>
                            @error('name')
                                <span class="text-danger fs-6">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <input wire:model="address" name="address" type="text" class="form-control"
                                placeholder="name@example.com">
                            <label for="floatingInput">Address</label>
                            @error('address')
                                <span class="text-danger fs-6">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <input wire:model="phone" name="phone" type="text" class="form-control"
                                placeholder="name@example.com">
                            <label for="floatingInput">Phone no.</label>
                            @error('phone')
                                <span class="text-danger fs-6">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                </div>

                @include('components.infor', ['title' => 'Store information'])


                <div class="d-flex gap-4 w-100 justify-content-around flex-column flex-sm-row">

                    <div class="d-flex flex-column gap-2 justify-content-center align-items-center">
                        <img src="{{ Storage::url($logo) }}" alt="img" width="200" height="200" class="rounded">
                        <div class="form-floating mb-3">
                            <input wire:model="newLogo" name="newLogo" type="file" class="form-control"
                                id="floatingInput" placeholder="name@example.com">
                            <label for="floatingInput">Upload Logo</label> @error('logo')
                                <span class="text-danger fs-6">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex flex-column gap-1 w-100">
                        <div class="form-floating mb-3">
                            <input wire:model="storeName" name="storeName" type="text" class="form-control"
                                placeholder="name@example.com">
                            <label for="floatingInput">Store name</label>
                            @error('name')
                                <span class="text-danger fs-6">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                </div>

                @include('components.create-btn', ['btnTitle' => 'Edit'])


            </div>

        </form>
    @endif
</div>
