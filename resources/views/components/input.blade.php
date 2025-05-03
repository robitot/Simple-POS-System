    <div class="form-floating">
    <input step="0.01" min="0" wire:model="{{ $model }}" type="{{ $type }}" class="form-control"
        placeholder="">
    <label>{{ $label }}</label>
    @error($model)
        <span class="text-danger fs-6">{{ $message }}</span>
    @enderror
</div>
