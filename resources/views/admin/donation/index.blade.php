@extends('layouts.app', ['title' => 'Donasi - Admin'])

@section('content')
  <main class="flex-1 overflow-y-auto overflow-x-hidden bg-gray-300">
    <div class="container mx-auto px-6 py-8">

      <form action="{{ route('admin.campaign.index') }}" method="GET">
        <div class="flex gap-6">
          <div class="flex-auto">
            <label class="text-gray-700" for="name">TANGGAL AWAL</label>
            <input class="form-input mt-2 w-full rounded-md bg-white p-3 shadow-md" type="date" name="date_from"
              value="{{ old('start_date') ?? request()->query('start_date') }}">
            @error('start_date')
              <div class="mt-2 w-full overflow-hidden rounded-md bg-red-200 shadow-sm">
                <div class="px-4 py-2">
                  <p class="text-sm text-gray-600">{{ $message }}</p>
                </div>
              </div>
            @enderror
          </div>

          <div class="flex-auto">
            <label class="text-gray-700" for="name">TANGGAL AKHIR</label>
            <input class="form-input mt-2 w-full rounded-md bg-white p-3 shadow-md" type="date" name="date_to"
              value="{{ old('end_date') ?? request()->query('end_date') }}">
            @error('end_date')
              <div class="mt-2 w-full overflow-hidden rounded-md bg-red-200 shadow-sm">
                <div class="px-4 py-2">
                  <p class="text-sm text-gray-600">{{ $message }}</p>
                </div>
              </div>
            @enderror
          </div>

          <div class="flex-1">
            <button
              class="mt-8 w-full rounded-md bg-gray-600 p-3 text-gray-200 shadow-md hover:bg-gray-700 focus:bg-gray-700 focus:outline-none">
              FILTER
            </button>
          </div>

        </div>
      </form>

      @if ($donations ?? '')
        @if (count($donations) > 0)
          <div class="overlow-x-auto -mx-4 mt-2 px-4 py-4 sm:-mx-8 sm:px-8">
            <div class="inline-block min-w-full overflow-hidden rounded-md shadow-sm">
              <table class="min-w-full table-auto">
                <thead class="justify-between">
                  <tr class="w-full border bg-gray-100">
                    <th class="border px-5 py-3">
                      <span class="text-gray-700">NAMA DONATUR</span>
                    </th>
                    <th class="border px-5 py-3">
                      <span class="text-gray-700">CAMPAIGN</span>
                    </th>
                    <th class="border px-5 py-3">
                      <span class="text-gray-700">TANGGAL</span>
                    </th>
                    <th class="border px-5 py-3">
                      <span class="text-gray-700">JUMLAH DONASI</span>
                    </th>
                  </tr>
                </thead>
                <tbody class="bg-gray-200">
                  @forelse ($donations as $donation)
                    <tr class="border bg-white">
                      <td class="border px-5 py-3">
                        {{ $donation->donatur->name }}
                      </td>
                      <td class="border px-5 py-3">
                        {{ $donation->campaign->title }}
                      </td>
                      <td class="border px-5 py-3">
                        {{ $donation->created_at }}
                      </td>
                      <td class="border px-5 py-3">
                        {{ formatPrice($donation->amount) }}
                      </td>
                    </tr>
                  @empty
                  @endforelse
                  <tr class="border bg-gray-600 font-bold text-white">
                    <td colspan="3" class="justify-center px-5 py-2">
                      TOTAL DONASI
                    </td>
                    <td colspan="3" class="px-5 py-2 text-right">
                      {{ formatPrice($total) }}
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        @endif
      @endif
    </div>
  </main>
@endsection
