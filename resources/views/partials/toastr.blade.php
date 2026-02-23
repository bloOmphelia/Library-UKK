<script>
@if(session('success'))
    toastr.success("{{ session('success') }}");
@endif

@if(session('error'))
    toastr.error("{{ session('error') }}");
@endif

@if ($errors->any())
    toastr.error("{{ $errors->first() }}");
@endif
</script>
