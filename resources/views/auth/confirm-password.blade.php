@extends('layouts.auth', ['title' => 'Confirm Password - Admin'])

@section('content')
  <div class="flex h-screen items-center justify-center bg-gray-300 px-6">
    <div class="w-full max-w-sm rounded-md bg-white p-6 shadow-md">
      <div class="flex items-center justify-center">
        <span class="text-2xl font-semibold text-gray-700">CONFIRM PASSWORD</span>
      </div>

      @if (session('status'))
        <div class="mt-3 rounded-md bg-green-500 p-3 shadow-sm">
          {{ session('status') }}
        </div>
      @endif

      <form action="{{ route('password.confirm') }}" class="mt-4" method="POST">
        @csrf
        <label class="mt-3 block">
          <span class="text-sm text-gray-700">Password</span>
          <input type="password" name="password" class="form-input mt-1 block w-full rounded-md focus:outline-none"
            placeholder="Password">
          @error('password')
            <div class="mt-2 inline-flex w-full max-w-sm overflow-hidden rounded-md bg-red-200 shadow-sm">
              <div class="px-4 py-3">
                <p class="text-sm text-gray-600">
                  {{ $message }}
                </p>
              </div>
            </div>
          @enderror
        </label>

        <div class="mt-6">
          <button type="submit"
            class="w-full rounded-md bg-indigo-600 py-2 px-4 text-center text-sm text-white hover:bg-indigo-500 focus:outline-none">
            CONFIRM PASSWORD
          </button>
        </div>
      </form>
    </div>
  </div>
@endsection
