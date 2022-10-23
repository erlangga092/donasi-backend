@extends('layouts.app', ['title' => 'Kategori - Admin'])

@section('content')
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-300">
        <div class="container mx-auto px-6 py-8">
            <div class="flex items-center">

                <button class="text-white focus:outline-none bg-gray-700 px-4 py-2 shadow-sm rounded-md">
                    <a href="{{ route('admin.category.create') }}">TAMBAH</a>
                </button>

                <div class="relative mx-4">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
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

            <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overlow-x-auto">
                <div class="inline-block min-w-full shadow-sm rounded-md overflow-hidden">
                    <table class="min-w-full table-auto">
                        <thead class="justify-between">
                            <tr class="bg-gray-700 w-full">
                                <th class="px-16 py-3">
                                    <span class="text-white">IMAGE</span>
                                </th>
                                <th class="px-16 py-3 text-left">
                                    <span class="text-white">NAMA KATEGORI</span>
                                </th>
                                <th class="px-16 py-3">
                                    <span class="text-white">AKSI</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-gray-200">
                            @forelse ($categories as $category)
                                <tr class="border bg-white">
                                    <td class="px-16 py-3 flex justify-center">
                                        <img src="{{ $category->image }}" class="w-10 h-100 object-fit-cover rounded-full"
                                            alt="">
                                    </td>
                                    <td class="px-16 py-3">
                                        {{ $category->name }}
                                    </td>
                                    <td class="px-10 py-3 text-center">
                                        <a href=""
                                            class="bg-indigo-600 px-4 py-2 rounded shadow-sm text-xs text-white focus:outline-none mr-1">
                                            <i class="fa fa-pencil-alt mr-1"></i> EDIT
                                        </a>
                                        <button
                                            class="bg-red-600 px-4 py-2 rounded shadow-sm text-xs text-white focus:outline-none">
                                            <i class="fa fa-trash mr-1"></i> DELETE
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <div class="bg-red-500 text-white text-center p-3 rounded-sm shadow-md">
                                    Data Belum Tersedia!
                                </div>
                            @endforelse
                        </tbody>
                    </table>
                    @if ($categories->hasPages())
                        <div class="bg-white p-3">
                            {{ $categories->links('vendor.pagination.tailwind') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>
@endsection
