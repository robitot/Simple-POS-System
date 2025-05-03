<div class="w-100 d-flex justify-content-start align-items-center gap-2">
    {{-- <button onclick="goBack()" wire:navigate class="btn btn-outline-danger">
        Back
    </button> --}}
    <button type="submit" wire:loading.attr='disabled' wire:loading.class='opacity-50' class="btn btn-primary ">
        <span wire:loading.remove>{{$btnTitle}}</span>
        <div wire:loading class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </button>
</div>
    
<script>
    function goBack() {
    window.history.back();
}

</script>
