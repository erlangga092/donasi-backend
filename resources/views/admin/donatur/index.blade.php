@extends('layouts.app', ['title' => 'Kategori - Admin'])

@section('content')
  <main class="flex-1 overflow-y-auto overflow-x-hidden bg-gray-300">
    <div class="container mx-auto px-6 py-8">
      <div class="flex items-center">

        <div class="relative">
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
                  <span class="text-gray-700">NAMA</span>
                </th>
                <th class="border px-5 py-3">
                  <span class="text-gray-700">EMAIL</span>
                </th>
              </tr>
            </thead>
            <tbody class="bg-gray-200">
              @forelse ($donaturs as $key => $donatur)
                <tr class="border bg-white">
                  <td class="border px-5 py-3">
                    {{ $donatur->name }}
                  </td>
                  <td class="border px-5 py-3">
                    {{ $donatur->email }}
                  </td>
                </tr>
              @empty
                {{-- <div class="mb-3 rounded-sm bg-red-500 p-3 text-center text-white shadow-md">
                  Data Belum Tersedia!
                </div> --}}
              @endforelse
            </tbody>
          </table>
          @if ($donaturs->hasPages())
            {{-- <div class="flex justify-end bg-white p-3">
              <div class="">
                {{ $categories->links() }}
              </div>
            </div> --}}
            <div class="bg-white p-3">
              {{ $cdonaturs->links('vendor.pagination.tailwind') }}
            </div>
          @endif
        </div>
      </div>
    </div>
  </main>
@endsection
