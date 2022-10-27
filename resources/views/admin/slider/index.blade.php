@extends('layouts.app', ['title' => 'Slider - Admin'])

@section('content')
  <main class="flex-1 overflow-y-auto overflow-x-hidden bg-gray-300">
    <div class="container mx-auto px-6 py-8">
      <div class="rounded-md bg-white p-6 shadow-md">
        <h2 class="text-lg font-semibold capitalize text-gray-700">UPLOAD SLIDER</h2>
        <hr class="mt-4">

        <form action="{{ route('admin.slider.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="mt-4 grid grid-cols-1 gap-6">
            <div>
              <label class="text-gray-700">IMAGE</label>
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

            <div>
              <label class="text-gray-700">LINK SLIDER</label>
              <input type="text" class="form-input mt-2 w-full rounded-md bg-gray-200 p-3 focus:bg-white"
                name="link" value="{{ old('link') }}" placeholder="Link Promo">
              @error('link')
                <div class="mt-2 w-full overflow-hidden rounded-md bg-red-200 shadow-sm">
                  <div class="px-4 py-2">
                    <p class="text-sm text-gray-600">{{ $message }}</p>
                  </div>
                </div>
              @enderror
            </div>
          </div>
          <div class="mt-4 flex justify-start">
            <button type="submit"
              class="rounded-md bg-gray-600 px-4 py-2 text-gray-200 hover:bg-gray-700 focus:bg-gray-700 focus:outline-none">UPLOAD</button>
          </div>
        </form>
      </div>

      <div class="overlow-x-auto -mx-4 px-4 py-4 sm:-mx-8 sm:px-8">
        <div class="inline-block min-w-full overflow-hidden rounded-md shadow-sm">
          <table class="min-w-full table-auto">
            <thead class="justify-between">
              <tr class="w-full border bg-gray-100">
                <th class="border px-5 py-3" style="width: 20%">
                  <span class="text-gray-700">GAMBAR</span>
                </th>
                <th class="border px-5 py-3">
                  <span class="text-gray-700">LINK PROMO</span>
                </th>
                <th class="border px-5 py-3">
                  <span class="text-gray-700">AKSI</span>
                </th>
              </tr>
            </thead>
            <tbody class="bg-gray-200">
              @forelse ($sliders as $key => $slider)
                <tr class="border bg-white">
                  <td class="flex justify-center border px-16 py-3">
                    <img src="{{ $slider->image }}" class="object-fit-cover h-8 rounded"">
                  </td>
                  <td class="border px-5 py-3">
                    {{ $slider->link }}
                  </td>
                  <td class="border px-5 py-1 text-center">
                    <button id="{{ $slider->id }}"
                      class="rounded bg-red-600 px-4 py-2 text-sm text-white shadow-sm focus:outline-none"
                      onclick="destroy(this.id)">
                      <i class="fa fa-trash"></i> DELETE
                    </button>
                  </td>
                </tr>
              @empty
                {{-- <div class="mb-3 rounded-sm bg-red-500 p-3 text-center text-white shadow-md">
                  Data Belum Tersedia!
                </div> --}}
              @endforelse
            </tbody>
          </table>
          @if ($sliders->hasPages())
            <div class="flex justify-end bg-white p-3">
              <div class="">
                {{ $sliders->links() }}
              </div>
            </div>
          @endif
        </div>
      </div>
    </div>
  </main>
@endsection
