@extends('layouts.app', ['title' => 'Profile - Admin'])

@section('content')
  <main class="flex-1 overflow-y-auto overflow-x-hidden bg-gray-300">
    <div class="container mx-auto px-6 py-8">

      @if (session('status'))
        <div class="mt-3 rounded-md bg-green-400 p-3 shadow-sm">
          @if (session('status') == 'profile-information-updated')
            Profile has been updated.
          @endif
          @if (session('status') == 'password-updated')
            Profile has been updated.
          @endif
          @if (session('status') == 'two-factor-authentication-disabled')
            Two factor authentication disabled.
          @endif
          @if (session('status') == 'two-factor-authentication-enabled')
            Two factor authentication enabled.
          @endif
          @if (session('status') == 'recovery-codes-generated')
            Recovery codes generated.
          @endif
        </div>
      @endif

      <div class="mt-4 grid grid-cols-1 gap-6 sm:grid-cols-2">
        <div>
          @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::twoFactorAuthentication()))
            <div class="rounded-md bg-white p-6 shadow-md">
              <h2 class="text-lg font-semibold capitalize text-gray-700">
                TWO-FACTOR AUTHENTICATION
              </h2>
              <hr class="mt-4">

              <div class="mt-4">
                @if (!auth()->user()->two_factor_secret)
                  {{-- Enable 2FA  --}}
                  <form action="{{ url('user/two-factor-authentication') }}" method="POST">
                    @csrf
                    <button type="submit"
                      class="rounded-md bg-gray-600 px-4 py-2 text-gray-200 hover:bg-gray-700 focus:bg-gray-700 focus:outline-none">
                      Enable Two-Factor
                    </button>
                  </form>
                @else
                  {{-- Disable 2FA  --}}
                  <form action="{{ url('user/two-factor-authentication') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                      class="rounded-md bg-red-900 px-4 py-2 text-gray-200 hover:bg-red-700 focus:bg-gray-700 focus:outline-none">
                      Disable Two-Factor
                    </button>
                  </form>

                  @if (session('status') == 'two-factor-authentication-enabled')
                    <div class="mt-4">
                      Otentikasi dua faktor sekarang diaktifkan. Pindai kode QR berikut menggunakan aplikasi pengaturan
                      ponsel anda.
                    </div>
                    <div class="mb-3 mt-4">
                      {!! auth()->user()->twoFactorQrCodeSvg() !!}
                    </div>
                  @endif

                  <div class="mt-4">
                    Simpan recovery code ini dengan aman. Ini dapat digunakan untuk memulihkan akses ke akun Anda jika
                    perangkat otentikasi dua faktor Anda hilang.
                  </div>

                  <div style="background: rgb(44, 44, 44); color: white" class="mb-2 mt-4 rounded p-3">
                    @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes), true) as $code)
                      <div>{{ $code }}</div>
                    @endforeach
                  </div>

                  <form action="{{ url('user/two-factor-recovery-codes') }}" method="POST" class="mt-4">
                    @csrf
                    <button type="submit"
                      class="rounded-md bg-gray-600 px-4 py-2 text-gray-200 hover:bg-gray-700 focus:bg-gray-700 focus:outline-none">
                      Regenerate Recovery Codes
                    </button>
                  </form>
                @endif
              </div>
            </div>
          @endif
        </div>

        <div>
          <div class="rounded-md bg-white p-6 shadow-md">
            <h2 class="text-lg font-semibold capitalize text-gray-700">EDIT PROFILE</h2>
            <hr class="mt-4">
            <form action="{{ route('user-profile-information.update') }}" class="mt-4" method="POST">
              @csrf
              @method('PUT')

              <div>
                <label for="" class="block">
                  <span class="text-sm text-gray-700">Nama Lengkap</span>
                  <input name="name" value="{{ old('name') ?? auth()->user()->name }}" type="text"
                    class="form-input mt-1 block w-full rounded-md" placeholder="Nama Lengkap">
                  @error('name')
                    <div class="mt-2 inline-flex w-full max-w-sm overflow-hidden rounded-md bg-red-200 shadow-sm">
                      <div class="px-4 py-2">
                        <p class="text-sm text-gray-600">{{ $message }}</p>
                      </div>
                    </div>
                  @enderror
                </label>
              </div>

              <div class="mt-4">
                <label for="" class="block">
                  <span class="text-sm text-gray-700">Alamat Email</span>
                  <input name="email" value="{{ old('email') ?? auth()->user()->email }}" type="email"
                    class="form-input mt-1 block w-full rounded-md" placeholder="Nama Lengkap">
                  @error('email')
                    <div class="mt-2 inline-flex w-full max-w-sm overflow-hidden rounded-md bg-red-200 shadow-sm">
                      <div class="px-4 py-2">
                        <p class="text-sm text-gray-600">{{ $message }}</p>
                      </div>
                    </div>
                  @enderror
                </label>
              </div>

              <div class="mt-4 flex justify-start">
                <button type="submit"
                  class="rounded-md bg-gray-600 px-4 py-2 text-gray-200 hover:bg-gray-700 focus:bg-gray-700 focus:outline-none">
                  UPDATE PROFILE
                </button>
              </div>
            </form>
          </div>

          <div class="mt-6 rounded-md bg-white p-6 shadow-md">
            <h2 class="text-lg font-semibold capitalize text-gray-700">UPDATE PASSWORD</h2>
            <hr class="mt-4">
            <form action="{{ route('user-password.update') }}" class="mt-4" method="POST">
              @csrf
              @method('PUT')

              <div>
                <label for="" class="block">
                  <span class="text-sm text-gray-700">Password Lama</span>
                  <input name="current_password" type="password" class="form-input mt-1 block w-full rounded-md"
                    placeholder="Password Lama">
                  @error('current_password')
                    <div class="mt-2 inline-flex w-full max-w-sm overflow-hidden rounded-md bg-red-200 shadow-sm">
                      <div class="px-4 py-2">
                        <p class="text-sm text-gray-600">{{ $message }}</p>
                      </div>
                    </div>
                  @enderror
                </label>
              </div>

              <div class="mt-4">
                <label for="" class="block">
                  <span class="text-sm text-gray-700">Password Baru</span>
                  <input name="password" type="password" class="form-input mt-1 block w-full rounded-md"
                    placeholder="Password Baru">
                  @error('password')
                    <div class="mt-2 inline-flex w-full max-w-sm overflow-hidden rounded-md bg-red-200 shadow-sm">
                      <div class="px-4 py-2">
                        <p class="text-sm text-gray-600">{{ $message }}</p>
                      </div>
                    </div>
                  @enderror
                </label>
              </div>

              <div class="mt-4">
                <label for="" class="block">
                  <span class="text-sm text-gray-700">Konfirmasi Password</span>
                  <input name="password_confirmation" type="password" class="form-input mt-1 block w-full rounded-md"
                    placeholder="Konfirmasi Password">
                  @error('password_confirmation')
                    <div class="mt-2 inline-flex w-full max-w-sm overflow-hidden rounded-md bg-red-200 shadow-sm">
                      <div class="px-4 py-2">
                        <p class="text-sm text-gray-600">{{ $message }}</p>
                      </div>
                    </div>
                  @enderror
                </label>
              </div>

              <div class="mt-4 flex justify-start">
                <button type="submit"
                  class="rounded-md bg-gray-600 px-4 py-2 text-gray-200 hover:bg-gray-700 focus:bg-gray-700 focus:outline-none">
                  UPDATE PASSWORD
                </button>
              </div>
            </form>
          </div>

        </div>

      </div>
    </div>
  </main>
@endsection
