@if($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach($errors->all() as $errors)
        <li>{{ $errors }}</li>
        @endforeach
    </ul>
</div>
@endif

<label for="kategori_kode">Kode Kategori</label>
 
<input id="kategori_kode"
    type="text"
    name="kategori_kode"
    class="@error('kategori_kode') is-invalid @enderror">
 
@error('kategori_kode')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror