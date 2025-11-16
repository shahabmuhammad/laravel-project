<div class="container p-4">

    {{-- Title --}}
    <div class="mb-3">
        <label for="title" class="form-label fw-bold">Title</label>
        <input type="text" name="title" id="title" value="{{ old('title', $research->title ?? '') }}"
            class="form-control" style="height:40px; font-size:16px;" required>
    </div>

    {{-- Description --}}
    <div class="mb-3">
        <label for="description" class="form-label fw-bold">Description</label>
        <textarea name="description" id="description" class="form-control" rows="2" style="font-size:16px;" required>{{ old('description', $research->description ?? '') }}</textarea>
    </div>

    <div class="mb-3">
        <label for="keywords" class="form-label fw-bold">Keywords</label>
        <input type="text" name="keywords" id="keywords" value="{{ old('keywords', $research->keywords ?? '') }}"
            class="form-control" placeholder="e.g. AI, Education, Technology">
        <small class="text-muted">Separate multiple keywords with commas.</small>
    </div>

    {{-- Category --}}
    <div class="mb-3">
        <label for="category_id" class="form-label fw-bold">Category</label>
        <select class="form-control select2" data-placeholder="Select Category" id="category_id" name="category_id[]"
            multiple required style="height:auto; font-size:16px;">
            @foreach ($categories as $c)
                <option value="{{ $c->id }}"
                    {{ collect(old('category_id', $research->category_id ?? []))->contains($c->id) ? 'selected' : '' }}>
                    {{ $c->name }}
                </option>
            @endforeach
        </select>
    </div>
      <div class="row g-2 mt-2">
        {{-- Publisher --}}
        <div class="col-md-6">
            <label for="publisher_id" class="form-label fw-bold">Publisher</label>
            <select name="publisher_id" id="publisher_id" class="form-select" style="height:36px; font-size:16px;">
                <option value="">Select Publisher</option>
                @foreach ($publishers as $p)
                    <option value="{{ $p->id }}"
                        {{ old('publisher_id', $research->publisher_id ?? '') == $p->id ? 'selected' : '' }}>
                        {{ $p->name }}
                    </option>
                @endforeach
            </select>
        </div>
    {{-- Type & File --}}
    <div class="row g-2 mt-2">
        <div class="col-md-6">
            <label for="type_id" class="form-label fw-bold">Type</label>
            <select name="type_id" id="type_id" class="form-select" style="height:36px; font-size:16px;">
                <option value="">Select Type</option>
                @foreach ($types as $t)
                    <option value="{{ $t->id }}"
                        {{ old('type_id', $research->type_id ?? '') == $t->id ? 'selected' : '' }}>
                        {{ $t->type }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6">
            <label for="file_path" class="form-label fw-bold">Upload Research File (PDF/DOC)</label>

            <input type="file" name="uploaded_file" id="uploaded_file">
    
            <small class="text-muted d-block mt-1">Allowed: .pdf, .doc, .docx | Max 10 MB</small>
            @if(isset($research) && $research->hasMedia('research_files'))

        @php
            $file = $research->getFirstMedia('research_files');
        @endphp
        <div class="mb-3">
            <strong>Existing File:</strong>
            <a href="{{ asset('media/' . $file->id . '/' . $file->file_name) }}" target="_blank">
                View / Download
            </a>
        </div>
    @endif
        </div>
    </div>

    {{-- Status --}}
   
    <div class="mb-3 mt-2">
        <label for="status" class="form-label fw-bold">Status</label>
        <select name="status" id="status" class="form-select" style="height:36px; font-size:16px;">
            @if (auth()->user()->hasRole('Admin'))
                {{-- Admin can select all statuses --}}
                @foreach (['draft', 'submitted', 'published', 'rejected'] as $status)
                    <option value="{{ $status }}"
                        {{ old('status', $research->status ?? '') == $status ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            @else
                {{-- Author can only select submitted --}}
                <option value="submitted" selected>Submitted</option>
            @endif
        </select>
    </div>


    {{-- Buttons --}}
    <div class="d-flex justify-content-end mt-3 gap-2">
        <a href="{{ route('admin.researches.index') }}" class="btn btn-secondary px-3 py-1">Back</a>
       
    </div>

</div>
