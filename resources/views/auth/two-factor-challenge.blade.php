@extends('layouts.auth', ['title' => 'Two Factor Challenge - Admin'])

@section('content')
  <div class="flex h-screen items-center justify-center bg-gray-300 px-6">
    <div class="w-full max-w-sm rounded-md bg-white p-6 shadow-md">
      <div class="flex items-center justify-center">
        <span class="text-2xl font-semibold text-gray-700">TWO FACTOR CHALLENGE</span>
      </div>

      @if (session('status'))
        <div class="mt-3 rounded-md bg-green-500 p-3 shadow-sm">
          {{ session('status') }}
        </div>
      @endif

      <form action="{{ url('/two-factor-challenge') }}" class="mt-4" method="POST">
        @csrf
        <label class="block">
          <span class="text-sm text-gray-700">Code</span>
          <input type="text" name="code" value="{{ old('code') }}"
            class="form-input mt-1 block w-full rounded-md focus:outline-none" placeholder="Code">
          @error('code')
            <div class="mt-2 inline-flex w-full max-w-sm overflow-hidden rounded-md bg-red-200 shadow-sm">
              <div class="px-4 py-3">
                <p class="text-sm text-gray-600">
                  {{ $message }}
                </p>
              </div>
            </div>
          @enderror
        </label>

        <p class="text-gray-600">
          <i>Atau anda dapat memasukkan salah satu recovery code.</i>
        </p>

        <label class="block">
          <span class="text-sm text-gray-700">Recovery Code</span>
          <input type="text" name="recovery_code" class="form-input mt-1 block w-full rounded-md focus:outline-none"
            placeholder="Recovery Code">
          @error('code')
            <div class="mt-2 inline-flex w-full max-w-sm overflow-hidden rounded-md bg-red-200 shadow-sm">
              <div class="px-4 py-3">
                <p class="text-sm text-gray-600">
                  {{ $message }}
                </p>
              </div>
            </div>
          @enderror
        </label>

        <label class="mt-3 block">
          <span class="text-sm text-gray-700">Konfirmasi Password</span>
          <input type="password" name="password_confirmation"
            class="form-input mt-1 block w-full rounded-md focus:outline-none" placeholder="Konfirmasi Password">
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
            LOGIN
          </button>
        </div>
      </form>
    </div>
  </div>
@endsection
