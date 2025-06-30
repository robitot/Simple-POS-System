<div class="form-floating">
    <input
        step="1"
        min="0"
        wire:model="{{ $model }}"
        type="{{ $type }}"
        class="form-control"
        placeholder=""
        @if ($type === 'number')
            oninput="this.value = this.value.replace(/\D/g, '')"
        @endif
    >

    <label>{{ $label }}</label>

    @error($model)
        <span class="text-danger fs-6">{{ $message }}</span>
    @enderror
</div>
