<script>
    const successTitle = @json($successTitle);
    const errorTitle = @json($errorTitle);

    const successTrigger = @json($successTrigger);
    const errorTrigger = @json($errorTrigger);

    window.addEventListener(successTrigger, event => {
        toastr.success(successTitle);
    });

    window.addEventListener(errorTrigger, event => {
        toastr.error(errorTitle);
    });
</script>