    <div class="form-floating">
        <input step="0.01" min="0" wire:model="{{ $model }}" type="{{ $type }}" class="form-control"
            placeholder=""
            @if ($type === 'number') oninput="this.value = this.value.replace(/[^0-9.]/g, '')" @endif>


        <label>{{ $label }}</label>
        @error($model)
            <span class="text-danger fs-6">{{ $message }}</span>
        @enderror
    </div>
