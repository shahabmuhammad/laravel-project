@extends('admin.layouts.master')

@section('title', 'Edit Research')

@section('content')
<h3>Edit Research</h3>

<form action="{{ route('admin.researches.update', Crypt::encrypt($research->id)) }}" method="POST" enctype="multipart/form-data" class="m-0">
        @csrf
        @method('PUT')
        @include('admin.researches.form', ['research' => $research])
        <button type="submit" class="btn btn-primary">Update</button>
    </form>

<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css"/>

<script>
    $(document).ready(function () {
        $(".select2").select2();
    });

    // Disable Dropzone autodiscovery
    Dropzone.autoDiscover = false;

    const myDropzone = new Dropzone("#research-dropzone", {
        url: "{{ route('admin.researches.index') }}",
        paramName: "file",
        maxFilesize: 10, // MB
        acceptedFiles: ".pdf,.doc,.docx",
        headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
        addRemoveLinks: true,
        dictRemoveFile: "Remove",
        success: function (file, response) {
            // Store uploaded file path in hidden input
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'uploaded_file';
            input.value = response.file_path;
            document.querySelector('form').appendChild(input);
        },
        error: function (file, response) {
            console.log(response);
            alert("Upload failed: " + response.message);
        }
    });
</script>

@endsection
