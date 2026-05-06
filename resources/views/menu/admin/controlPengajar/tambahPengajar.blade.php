@extends('layout.template.mainTemplate')

@section('container')
    @if (Auth()->user()->roles_id == 1)
        @include('menu.admin.adminHelper')
    @endif

    <div class="col-12 ps-4 pe-4 mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white">
                <li class="breadcrumb-item"><a href="{{ route('viewPengajar') }}">Data Pengajar</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah Pengajar</li>
            </ol>
        </nav>
    </div>

    <div class="ps-4 pe-4 mt-4 pt-4">
        <h2 class="display-6 fw-bold">
            <a href="{{ route('viewPengajar') }}">
                <button type="button" class="btn btn-outline-secondary rounded-circle">
                    <i class="fa-solid fa-arrow-left"></i>
                </button>
            </a>
            Tambah Pengajar
        </h2>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-light">
                <li class="breadcrumb-item text-info">Step 1</li>
                <li class="breadcrumb-item">Step 2</li>
                <li class="breadcrumb-item" aria-current="page">Step 3</li>
            </ol>
        </nav>
    </div>

    <div class="">
        <div class="ps-4 pe-4">
            <div class="row">
                <div class="col-12 col-lg-12">
                    <div class="p-4">
                        <h4 class="fw-bold text-primary"><i class="fa-solid fa-pen"></i> Data Pengajar</h4>
                        <form action="{{ route('validateDataPengajar') }}" method="POST">
                            @csrf
                            <div class="bg-white rounded-2 p-4">
                                {{-- Nama --}}
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama : </label>
                                    <input type="text" class="form-control" id="nama" name="nama"
                                        placeholder="Aditya Kesuma, S.H, M.Kom" value="{{ old('nama') }}" maxlength="30" required>
                                    <div class="errors text-danger" style="font-size: 14px" hidden id="namaError">
                                        Nama tidak boleh melebihi 30 karakter
                                    </div>
                                    @error('nama')
                                        <div class="text-danger small">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                {{-- Email --}}
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email : </label>
                                    <input type="text" class="form-control" id="email" name="email"
                                        placeholder="email@gmail.com" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="text-danger small">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                {{-- Nomor Telepon --}}
                                <div class="mb-3">
                                    <label for="noTelp" class="form-label">Nomor Telepon
                                        <span class="text-secondary small">(Optional)</span> : </label>
                                        <input type="text" class="form-control" id="noTelp" name="noTelp"
                                        placeholder="08xxxxxxx" value="{{ old('noTelp') }}" maxlength="14" required>
                                    <div class="errors text-danger" style="font-size: 14px" hidden id="noTelpError">
                                        Nomor telepon tidak boleh melebihi 14 karakter
                                    </div>
                                    @error('noTelp')
                                        <div class="text-danger small">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- NUPTK -->
                                <div class="mb-3">
                                    <label for="nuptk" class="form-label">NUPTK <span
                                            class="text-secondary small">(Optional)</span> : </label>
                                    <input type="text" class="form-control" id="nuptk" name="nuptk" placeholder=""
                                        value="{{ old('nuptk') }}" maxlength="16">
                                    <div class="errors text-danger" style="font-size: 14px" hidden id="nuptkError">
                                        NUPTK tidak boleh melebihi 16 karakter
                                    </div>
                                    @error('nuptk')
                                        <div class="text-danger small">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- NIK -->
                                <div class="mb-3">
                                    <label for="nik" class="form-label">NIK <span
                                            class="text-secondary small">(Optional)</span> : </label>
                                    <input type="text" class="form-control" id="nik" name="nik" placeholder=""
                                        value="{{ old('nik') }}" maxlength="16">
                                    <div class="errors text-danger" style="font-size: 14px" hidden id="nikError">
                                        NIK tidak boleh melebihi 16 karakter
                                    </div>
                                    @error('nik')
                                        <div class="text-danger small">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                {{-- Password --}}
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-6 mb-3">
                                            <div class="form-group">
                                                <label for="password">Password
                                                    <span class="text-secondary small">(Min : 8)</span> :
                                                </label>
                                                <input class="form-control" id="password" name="password" type="password"
                                                    placeholder="****">
                                                @error('password')
                                                    <div class="text-danger small">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-6 mb-3">
                                            <div class="form-group">
                                                <label for="confirm-password">Confirm Password : </label>
                                                <input class="form-control" id="confirm-password" name="confirm-password"
                                                    type="password" placeholder="****">
                                                @error('confirm-password')
                                                    <div class="text-danger small">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <p class="small">Password di atas diisi oleh admin dan ditujukan kepada Pengajar.
                                            Setelahnya pengajar dapat mengganti password mereka jika diperlukan.</p>
                                    </div>
                                </div>

                            </div>

                            <div class="">
                                <button type="submit" class="btn-lg btn btn-primary w-100">Simpan dan Lanjutkan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('input', function (event) {
            const target = event.target;
            let errorElement = null;
            let maxLength = 0;

            switch (target.id) {
                case 'nama':
                    errorElement = document.getElementById('namaError');
                    maxLength = 30;
                    break;
                case 'noTelp':
                    errorElement = document.getElementById('noTelpError');
                    maxLength = 14;
                    break;
                case 'nuptk':
                    errorElement = document.getElementById('nuptkError');
                    maxLength = 16;
                    break;
                case 'nik':
                    errorElement = document.getElementById('nikError');
                    maxLength = 16;
                    break;
            }

            if (errorElement) {
                if (target.value.length >= maxLength) {
                    errorElement.hidden = false;
                } else {
                    errorElement.hidden = true;
                }
            }
        });

        document.addEventListener('keydown', function (event) {
            const target = event.target;
            const isNumericField = target.id === 'noTelp' || target.id === 'nuptk' || target.id === 'nik';

            if (isNumericField && !event.key.match(/[0-9]/) && event.key !== 'Backspace' && event.key !== 'Tab' && event.key !== 'ArrowLeft' && event.key !== 'ArrowRight') {
                event.preventDefault();
            }
        });
    </script>
@endsection
