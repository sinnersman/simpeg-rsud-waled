@extends('layouts.app', compact('title', 'breadcrumbs'))

@section('content')
@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Daftar Data Pegawai</h4>
                <p class="text-muted mb-3">Berikut adalah daftar semua data pegawai yang terdaftar.</p>
                
                <div class="table-responsive">
                    <div class="table dataTable">
                        {{ $dataTable->table() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- Create Account Modal -->
<div class="modal fade" id="createAccountModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createAccountModalLabel">Buat Akun Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" disabled></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info" role="alert">
                    Harap salin username dan password di bawah ini sebelum menutup modal.
                </div>
                <p>Username: <strong id="modal-username"></strong></p>
                <div class="mb-3">
                    <label for="modal-password" class="form-label">Password:</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="modal-password" readonly>
                        <button class="btn btn-outline-secondary" type="button" id="copyPasswordBtn">Salin</button>
                    </div>
                </div>
                <div id="account-creation-message" class="mt-3"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" disabled>Tutup</button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="{{ asset('/') }}assets/vendors/datatables.net-bs5/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap5.min.css">
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.5/css/buttons.bootstrap5.css"> --}}
@endpush

@push('scripts')
<script src="{{ asset('/') }}assets/vendors/jquery/jquery.min.js"></script>
<script src="{{ asset('/') }}assets/vendors/datatables.net/dataTables.js"></script>
<script src="{{ asset('/') }}assets/vendors/datatables.net-bs5/dataTables.bootstrap5.js"></script>

<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap5.min.js"></script>
{{ $dataTable->scripts() }}

<script>
    $(document).ready(function() {
        var table = $('#pegawai-table').DataTable();

        // Handle click on "Buat Akun" button
        $('#pegawai-table').on('click', '.create-account-btn', function() {
            var pegawaiId = $(this).data('pegawai-id');
            var pegawaiNip = $(this).data('pegawai-nip');
            var button = $(this); // Store the button element

            // Reset modal state
            $('#modal-username').text(pegawaiNip);
            $('#modal-password').val('');
            $('#account-creation-message').html('');
            $('#createAccountModal .btn-close').prop('disabled', true);
            $('#createAccountModal .modal-footer button').prop('disabled', true);

            // Show loading indicator or disable button
            button.prop('disabled', true).text('Membuat Akun...');

            // Make AJAX request to create account
            $.ajax({
                url: '/pegawai/' + pegawaiId + '/create-account',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        $('#modal-password').val(response.password);
                        $('#account-creation-message').html('<div class="alert alert-success">' + response.message + '</div>');
                        // Optionally, update the DataTable row to reflect account creation
                        table.ajax.reload(null, false); // Reload table data without resetting pagination
                    } else {
                        $('#account-creation-message').html('<div class="alert alert-danger">Gagal membuat akun: ' + (response.message || 'Terjadi kesalahan.') + '</div>');
                    }
                },
                error: function(xhr) {
                    var errorMessage = 'Terjadi kesalahan saat membuat akun.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    $('#account-creation-message').html('<div class="alert alert-danger">' + errorMessage + '</div>');
                },
                complete: function() {
                    button.prop('disabled', false).text('Buat Akun'); // Re-enable button
                    $('#createAccountModal').modal('show');
                }
            });
        });

        // Copy username and password to clipboard
        $('#copyPasswordBtn').on('click', function() {
            var username = $('#modal-username').text();
            var password = $('#modal-password').val();
            var credentialsToCopy = 'Username: ' + username + '\nPassword: ' + password;

            navigator.clipboard.writeText(credentialsToCopy).then(function() {
                var originalText = $('#copyPasswordBtn').text();
                $('#copyPasswordBtn').text('Disalin!').prop('disabled', true);

                // Enable modal closing after copy
                $('#createAccountModal .btn-close').prop('disabled', false);
                $('#createAccountModal .modal-footer button').prop('disabled', false);

                setTimeout(() => {
                    $('#copyPasswordBtn').text(originalText).prop('disabled', false);
                }, 2000);
            }).catch(function(err) {
                console.error('Could not copy text: ', err);
                alert('Gagal menyalin kredensial. Silakan salin secara manual.');
            });
        });

        // Clear modal content and reset state when closed
        $('#createAccountModal').on('hidden.bs.modal', function () {
            $('#modal-username').text('');
            $('#modal-password').val('');
            $('#account-creation-message').html('');
            // Re-disable close buttons for next time
            $('#createAccountModal .btn-close').prop('disabled', true);
            $('#createAccountModal .modal-footer button').prop('disabled', true);
        });
    });
</script>
@endpush