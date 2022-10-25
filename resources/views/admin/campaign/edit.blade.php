@extends('layouts.app', ['title' => 'Tambah Campaign - Admin'])

@section('content')
  <main class="flex-1 overflow-y-auto overflow-x-hidden bg-gray-300">
    <div class="container mx-auto px-6 py-8">
      <div class="rounded-md bg-white p-6 shadow-md">
        <h2 class="text-lg font-semibold capitalize text-gray-700">
          TAMBAH KATEGORI
        </h2>
        <hr class="mt-4">

        <form action="{{ route('admin.campaign.update', $campaign->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="mt-4 grid grid-cols-1 gap-6">
            <div>
              <label for="" class="text-gray-700">IMAGE</label>
              <input type="file" class="form-input mt-2 w-full rounded-md bg-gray-200 p-3 focus:bg-white"
                name="image">
              @error('image')
                <div class="mt-2 w-full overflow-hidden rounded-md bg-red-200 shadow-sm">
                  <div class="px-4 py-2">
                    <p class="text-sm text-gray-600">{{ $message }}</p>
                  </div>
                </div>
              @enderror
            </div>

            <div class="">
              <label for="" class="text-gray-700">JUDUL CAMPAIGN</label>
              <input type="text" class="form-input mt-2 w-full rounded-md border bg-gray-200 p-3 focus:bg-white"
                name="title" placeholder="Judul Campaign" value="{{ old('title', $campaign->title) }}">
              @error('title')
                <div class="mt-2 w-full overflow-hidden rounded-md bg-red-200 shadow-sm">
                  <div class="px-4 py-2">
                    <p class="text-sm text-gray-600">{{ $message }}</p>
                  </div>
                </div>
              @enderror
            </div>

            <div class="">
              <label for="" class="text-gray-700">KATEGORI</label>
              <select name="category_id" class="w-full rounded border bg-gray-200 px-3 py-3 outline-none focus:bg-white">
                @foreach ($categories as $category)
                  <option value="{{ $category->id }}" class="py-1"
                    selected="{{ $category->id == $campaign->category_id ? 'true' : false }}">
                    {{ $category->name }}
                  </option>
                @endforeach
              </select>
              @error('category_id')
                <div class="mt-2 w-full overflow-hidden rounded-md bg-red-200 shadow-sm">
                  <div class="px-4 py-2">
                    <p class="text-sm text-gray-600">{{ $message }}</p>
                  </div>
                </div>
              @enderror
            </div>

            <div class="">
              <label for="" class="text-gray-700">DESKRIPSI</label> <br>
              <textarea name="description" rows="5" class="w-full">
                        {{ old('description', $campaign->description) }}
                        </textarea>
              @error('description')
                <div class="mt-2 w-full overflow-hidden rounded-md bg-red-200 shadow-sm">
                  <div class="px-4 py-2">
                    <p class="text-sm text-gray-600">{{ $message }}</p>
                  </div>
                </div>
              @enderror
            </div>

            <div class="">
              <label for="" class="text-gray-700">TARGET DONASI</label>
              <input type="number" class="form-input mt-2 w-full rounded-md border bg-gray-200 p-3 focus:bg-white"
                name="target_donation" placeholder="Target Donasi"
                value="{{ old('target_donation', $campaign->target_donation) }}">
              @error('target_donation')
                <div class="mt-2 w-full overflow-hidden rounded-md bg-red-200 shadow-sm">
                  <div class="px-4 py-2">
                    <p class="text-sm text-gray-600">{{ $message }}</p>
                  </div>
                </div>
              @enderror
            </div>

            <div class="">
              <label for="" class="text-gray-700">TANGGAL BERAKHIR</label>
              <input type="date" class="form-input mt-2 w-full rounded-md border bg-gray-200 p-3 focus:bg-white"
                name="max_date" placeholder="Tanggal Berakhir" value="{{ old('max_date', $campaign->max_date) }}">
              @error('max_date')
                <div class="mt-2 w-full overflow-hidden rounded-md bg-red-200 shadow-sm">
                  <div class="px-4 py-2">
                    <p class="text-sm text-gray-600">{{ $message }}</p>
                  </div>
                </div>
              @enderror
            </div>
          </div>

          <div class="mt-6 flex justify-start">
            <button type="submit"
              class="rounded-md bg-gray-600 px-4 py-2 text-gray-200 hover:bg-gray-700 focus:bg-gray-700 focus:outline-none">UPDATE</button>
          </div>
        </form>
      </div>
    </div>
  </main>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.7.0/tinymce.min.js"></script>
  <script>
    tinymce.init({
      selector: 'textarea'
    })
  </script>
@endsection
