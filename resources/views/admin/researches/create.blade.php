@extends('admin.layouts.master')

@section('title', 'Add Research')

@section('content')
    <h3>Add New Research</h3>

    <form action="{{ route('admin.researches.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.researches.form')
        <button type="submit" class="btn btn-primary">Submit</button>


    </form>

    {{-- <script> $(document).ready(function() {
            $(".select2").select2();

});  </script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" />

    <script>
        $(document).ready(function() {
            $(".select2").select2();
        });

        // Disable Dropzone autodiscovery
        Dropzone.autoDiscover = false;

        const myDropzone = new Dropzone("#research-dropzone", {
            url: "{{ route('admin.researches.index') }}",
            paramName: "file",
            maxFilesize: 10, // MB
            acceptedFiles: ".pdf,.doc,.docx",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            addRemoveLinks: true,
            dictRemoveFile: "Remove",
            success: function(file, response) {
                // Store uploaded file path in hidden input
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'uploaded_file';
                input.value = response.file_path;
                document.querySelector('form').appendChild(input);
            },
            error: function(file, response) {
                console.log(response);
                alert("Upload failed: " + response.message);
            }
        });
    </script>


@endsection
