@extends('layouts.app', ['title' => 'Kategori - Admin'])

@section('content')
  <main class="flex-1 overflow-y-auto overflow-x-hidden bg-gray-300">
    <div class="container mx-auto px-6 py-8">
      <div class="flex items-center">

        <button class="rounded-md bg-gray-700 px-4 py-2 text-white shadow-sm focus:outline-none">
          <a href="{{ route('admin.category.create') }}">
            <i class="fa fa-plus-square mr-1"></i> TAMBAH
          </a>
        </button>

        <div class="relative mx-4">
          <span class="absolute inset-y-0 left-0 flex items-center pl-3">
            <svg class="h-5 w-5 text-gray-500" viewBox="0 0 24 24" fill="none">
              <path
                d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </span>
          <form action="{{ route('admin.category.index') }}" method="GET">
            <input type="text" class="form-input w-full rounded-lg pl-10 pr-4" name="q"
              value="{{ request()->query('q') }}" placeholder="Search">
          </form>
        </div>
      </div>

      <div class="overlow-x-auto -mx-4 mt-2 px-4 py-4 sm:-mx-8 sm:px-8">
        <div class="inline-block min-w-full overflow-hidden rounded-md shadow-sm">
          <table class="min-w-full table-auto">
            <thead class="justify-between">
              <tr class="w-full border bg-gray-100">
                <th class="border px-5 py-3">
                  <span class="text-gray-700">IMAGE</span>
                </th>
                <th class="border px-5 py-3">
                  <span class="text-gray-700">NAMA KATEGORI</span>
                </th>
                <th class="border px-5 py-3">
                  <span class="text-gray-700">AKSI</span>
                </th>
              </tr>
            </thead>
            <tbody class="bg-gray-200">
              @forelse ($categories as $key => $category)
                <tr class="border bg-white">
                  <td class="flex justify-center px-16 py-3">
                    <img src="{{ $category->image }}" class="object-fit-cover h-8 rounded-full" alt="">
                  </td>
                  <td class="border px-5 py-3">
                    {{ $category->name }}
                  </td>
                  <td class="border px-10 py-1 text-center">
                    <a href="{{ route('admin.category.edit', $category->id) }}"
                      class="mr-1 inline-block h-full rounded bg-indigo-600 px-4 py-2 text-sm text-white shadow-sm focus:outline-none">
                      <i class="fa fa-pencil-alt mr-1"></i> EDIT
                    </a>
                    <button id="{{ $category->id }}" onclick="destroy(this.id);"
                      class="rounded bg-red-600 px-4 py-2 text-sm text-white shadow-sm focus:outline-none">
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
          @if ($categories->hasPages())
            <div class="flex justify-end bg-white p-3">
              <div class="">
                {{ $categories->links() }}
              </div>
            </div>
          @endif
        </div>
      </div>
    </div>
  </main>
  <script>
    function destroy(id) {
      const ID = id
      const token = $("meta[name='csrf-token']").attr('content')

      Swal.fire({
        title: 'APAKAH KAMU YAKIN ?',
        text: 'INGIN MENGHAPUS DATA INI!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'BATAL',
        confirmButtonText: 'YA, HAPUS!'
      }).then(result => {
        if (result.isConfirmed) {
          jQuery.ajax({
            url: `/admin/category/${id}`,
            data: {
              "id": ID,
              "_token": token
            },
            type: "DELETE",
            success: function(response) {
              if (response.status == "success") {
                Swal.fire({
                  title: 'BERHASIL',
                  text: 'DATA BERHASIL DIHAPUS!',
                  icon: 'success',
                  showConfirmButton: false,
                  timer: 1000
                }).then(function() {
                  location.reload()
                })
              } else {
                console.log(response.status)
                Swal.fire({
                  title: 'GAGAL',
                  text: 'DATA GAGAL DIHAPUS!',
                  icon: 'error',
                  showConfirmButton: false,
                  timer: 1000
                }).then(function() {
                  location.reload()
                })
              }
            },
            error: function(err) {
              console.log(err.responseJSON.message)
              Swal.fire({
                title: 'GAGAL',
                text: err.responseJSON.message,
                icon: 'error',
                showConfirmButton: false,
                timer: 3000
              }).then(function() {
                location.reload()
              })
            }
          })
        }
      })
    }
  </script>
@endsection
