@if (! empty(session('message')))
    @if (is_array(session('message')))
        <script>
            Swal.fire(
                '{!! session("message.title") !!}',
                '{!! session("message.content") !!}',
                'success'
            );
        </script>
    @else
        <script>
            Swal.fire(
                'Success',
                '{!! session("message") !!}',
                'success'
            );
        </script>
    @endif
@endif

@if (session()->has('status'))
    <script>
        Swal.fire(
            'Info',
            '{!! session()->get("status") !!}',
            'info'
        );
    </script>
@endif

@if (count($errors) > 0)
    @php
        $err_message = '';
        foreach ($errors->all() as $error){
            $err_message.=$error.', ';
        }
    @endphp

    <script>
        Swal.fire(
            'Error',
            '{{ $err_message }}',
            'error'
        );
    </script>
@endif
