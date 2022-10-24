@extends('layouts.app', ['title' => 'Edit Kategori - Admin'])

@section('content')
  <main class="flex-1 overflow-y-auto overflow-x-hidden bg-gray-300">
    <div class="container mx-auto px-6 py-8">
      <div class="rounded-md bg-white p-6 shadow-md">
        <h2 class="text-lg font-semibold capitalize text-gray-700">
          EDIT KATEGORI
        </h2>
        <hr class="mt-4">

        <form action="{{ route('admin.category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
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
              <label for="" class="text-gray-700">NAMA KATEGORI</label>
              <input type="text" class="borde form-input mt-2 w-full rounded-md bg-gray-200 p-3 focus:bg-white"
                name="name" placeholder="Nama Kategori" value="{{ old('name', $category->name) }}">
              @error('name')
                <div class="mt-2 w-full overflow-hidden rounded-md bg-red-200 shadow-sm">
                  <div class="px-4 py-2">
                    <p class="text-sm text-gray-600">{{ $message }}</p>
                  </div>
                </div>
              @enderror
            </div>
          </div>

          <div class="mt-6 flex justify-start">
            <button
              class="rounded-md bg-gray-600 px-4 py-2 text-gray-200 hover:bg-gray-700 focus:bg-gray-700 focus:outline-none">UPDATE</button>
          </div>
        </form>
      </div>
    </div>
  </main>
@endsection
