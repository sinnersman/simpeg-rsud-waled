@extends('layouts.app', compact('title', 'breadcrumbs'))

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Form Tambah Data Pengguna</h4>
                <p class="text-muted mb-3">Isi semua kolom yang diperlukan untuk menambahkan data pengguna baru.</p>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="user-create-form" method="POST" action="{{ route('users.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Tipe Pengguna:</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="user_type" id="user_type_new" value="new" {{ count($availablePegawai) == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="user_type_new">
                                Buat Pengguna Baru
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="user_type" id="user_type_pegawai" value="pegawai" {{ count($availablePegawai) > 0 ? 'checked' : '' }} {{ count($availablePegawai) == 0 ? 'disabled' : '' }}>
                            <label class="form-check-label" for="user_type_pegawai">
                                Buat Akun untuk Pegawai yang Belum Memiliki Akun
                            </label>
                        </div>
                    </div>

                    <div id="new_user_fields">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-control" id="role" name="role" required>
                                <option value="">Pilih Role</option>
                                @foreach ($roles as $roleOption)
                                    <option value="{{ $roleOption->name }}" {{ old('role') == $roleOption->name ? 'selected' : '' }}>{{ $roleOption->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div id="pegawai_fields" style="display: none;">
                        @if (count($availablePegawai) > 0)
                            <div class="mb-3">
                                <label for="pegawai_id" class="form-label">Pilih Pegawai</label>
                                <select class="form-control" id="pegawai_id" name="pegawai_id">
                                    <option value="">Pilih Pegawai</option>
                                    @foreach ($availablePegawai as $pegawai)
                                        <option value="{{ $pegawai->id }}" data-nip="{{ $pegawai->nip }}" data-nama="{{ $pegawai->nama_lengkap }}" data-email="{{ $pegawai->email }}">{{ $pegawai->nama_lengkap }} (NIP: {{ $pegawai->nip }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="button" id="generate_pegawai_account_btn" class="btn btn-success me-2" disabled>Generate Akun Pegawai</button>
                        @else
                            <div class="alert alert-info">
                                Tidak ada pegawai yang belum memiliki akun. Silakan <a href="{{ route('pegawai.create') }}">tambah pegawai baru</a> terlebih dahulu.
                            </div>
                        @endif
                    </div>

                    <div class="mt-4" id="submit_buttons">
                        <button type="submit" class="btn btn-primary me-2">Simpan Data</button>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
<script src="{{ asset('/') }}assets/vendors/jquery/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize Select2
        $('#pegawai_id').select2({
            placeholder: "Pilih Pegawai",
            allowClear: true
        });

        function toggleUserTypeFields() {
            var userType = $('input[name="user_type"]:checked').val();

            if (userType === 'new') {
                $('#new_user_fields').show().find('input, select').prop('required', true);
                $('#pegawai_fields').hide();
                $('#pegawai_id').prop('required', false);
                $('#submit_buttons').show();
            } else if (userType === 'pegawai') {
                $('#new_user_fields').hide().find('input, select').prop('required', false);
                $('#pegawai_fields').show();
                $('#pegawai_id').prop('required', true);
                $('#submit_buttons').hide(); // Hide default submit buttons
            }
            // Trigger change on pegawai_id to update button state
            $('#pegawai_id').trigger('change');
        }

        // Initial state
        toggleUserTypeFields();

        // Handle radio button change
        $('input[name="user_type"]').change(function() {
            toggleUserTypeFields();
        });

        // Handle pegawai selection to enable/disable generate button
        $('#pegawai_id').change(function() {
            if ($(this).val()) {
                $('#generate_pegawai_account_btn').prop('disabled', false);
            } else {
                $('#generate_pegawai_account_btn').prop('disabled', true);
            }
        });

        // Handle generate pegawai account button click
        $('#generate_pegawai_account_btn').on('click', function() {
            var pegawaiId = $('#pegawai_id').val();
            var button = $(this);

            if (!pegawaiId) {
                Swal.fire('Peringatan', 'Silakan pilih pegawai terlebih dahulu.', 'warning');
                return;
            }

            button.prop('disabled', true).text('Membuat Akun...');

            $.ajax({
                url: '{{ route('users.generatePegawaiAccount') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    pegawai_id: pegawaiId
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: 'Akun Berhasil Dibuat!',
                            html: `
                                <p>Username: <strong>${response.username}</strong></p>
                                <p>Password: <strong>${response.password}</strong></p>
                                <button id="copyCredentialsBtn" class="btn btn-primary mt-2">Salin Username & Password</button>
                            `,
                            icon: 'success',
                            showConfirmButton: true,
                            confirmButtonText: 'Tutup',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            didOpen: () => {
                                $('#copyCredentialsBtn').on('click', function() {
                                    var credentialsToCopy = `Username: ${response.username}\nPassword: ${response.password}`;
                                    // Fallback copy function
                                    if (!navigator.clipboard || !navigator.clipboard.writeText) {
                                        var tempTextArea = document.createElement('textarea');
                                        tempTextArea.value = credentialsToCopy;
                                        document.body.appendChild(tempTextArea);
                                        tempTextArea.select();
                                        document.execCommand('copy');
                                        document.body.removeChild(tempTextArea);
                                        Swal.getConfirmButton().textContent = 'Disalin!';
                                        Swal.getConfirmButton().disabled = false; // Enable close button
                                        setTimeout(() => {
                                            Swal.getConfirmButton().textContent = 'Tutup';
                                        }, 2000);
                                    } else {
                                        navigator.clipboard.writeText(credentialsToCopy).then(function() {
                                            Swal.getConfirmButton().textContent = 'Disalin!';
                                            Swal.getConfirmButton().disabled = false; // Enable close button
                                            setTimeout(() => {
                                                Swal.getConfirmButton().textContent = 'Tutup';
                                            }, 2000);
                                        }).catch(function(err) {
                                            console.error('Could not copy text: ', err);
                                            alert('Gagal menyalin kredensial. Silakan salin secara manual.');
                                        });
                                    }
                                });
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Reload the page or update the table
                                window.location.href = '{{ route('users.index') }}';
                            }
                        });
                    } else {
                        Swal.fire('Gagal', response.message || 'Terjadi kesalahan saat membuat akun.', 'error');
                    }
                },
                error: function(xhr) {
                    var errorMessage = 'Terjadi kesalahan saat membuat akun.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    Swal.fire('Error', errorMessage, 'error');
                },
                complete: function() {
                    button.prop('disabled', false).text('Generate Akun Pegawai');
                }
            });
        });

        // If user_type_pegawai is disabled, select new_user_type
        if ($('#user_type_pegawai').is(':disabled')) {
            $('#user_type_new').prop('checked', true).change();
        }
    });
</script>
@endpush
