@extends("layouts.app")

@section('subtitle', 'Kategori')
@section('content_header_title', 'Kategori')
@section('content_header_subtitle', 'Create')

@section('content')
<div class="container">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Buat kategori baru</h3>
        </div>
        <form method="post" action="../kategori">
            <div class="card-body">
                <div class="form-group">
                    <label for="codekategori">Kode Kategori</label>
                    <input type="text" class="form-control" id="codekategori" name="codekategori" placeholder="Enter kode kategori">
                </div>
                <div class="form-group">
                    <label for="namakategori">Nama Kategori</label>
                    <input type="text" class="form-control" id="namakategori" name="namakategori" placeholder="Enter nama kategori">
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ url('/kategori/') }}" class="btn btn-secondary">Back</a>
            </div>
        </form>
    </div>
</div>
@endsection