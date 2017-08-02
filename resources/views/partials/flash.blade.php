@if (session()->has('flash_message'))
    <script>
        Materialize.toast("{{session('flash_message.message')}}", 6000, "{{session('flash_message.class')}}");
    </script>
@endif
