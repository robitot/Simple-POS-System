<script>
    // Pass PHP variables to JavaScript
    const successTitle = @json($successTitle);
    const errorTitle = @json($errorTitle);

    // Listen for success event
    window.addEventListener('success', event => {
        toastr.success(successTitle);
    });

    // Listen for error event
    window.addEventListener('error', event => {
        toastr.error(errorTitle);
    });
</script>