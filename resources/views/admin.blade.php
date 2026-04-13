<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') &mdash; CV Lisan</title>

    @include('template/assets/admin/default/header')
    @include('template/assets/admin/table/header')
    @include('template/assets/admin/extra/header')

</head>

<body>

    <div class="main-wrapper">
        @include('template/admin/sidebar')

        <div class="page-wrapper">
            @include('template/admin/navbar')

            <div class="page-content container-xxl">
                @yield('content')
            </div>

            @include('template/admin/footer')
        </div>
    </div>

    @include('template/assets/admin/default/footer')
    @include('template/assets/admin/table/footer')
    @include('template/assets/admin/extra/footer')

    <script>
        // SCRIPT GLOBAL: Biar semua halaman bisa pake Ajax yang sama
        $(document).on('submit', '.ajax-form', function(e) {
            e.preventDefault();
            let form = $(this);
            let formData = new FormData(this);
            let modalId = form.data('modal-id');

            $.ajax({
                url: form.attr('action'),
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        // 1. MUNCULIN ALERT
                        if (typeof showSwal === 'function') {
                            showSwal('custom-position');
                            setTimeout(function() {
                                Swal.close();
                            }, 1500);
                        } else {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            });
                        }

                        // 2. TUTUP MODAL (Kuncinya di sini)
                        if (modalId) {
                            $(modalId).modal('hide'); // Tutup cara halus

                            // Proteksi jika modal masih bandel
                            setTimeout(function() {
                                if ($(modalId).hasClass('show')) {
                                    $(modalId).removeClass('show');
                                    $('.modal-backdrop').remove();
                                    $('body').removeClass('modal-open').css('overflow', 'auto');
                                }
                            }, 500);
                        }

                        // 3. RELOAD & RESET
                        if (typeof table !== 'undefined') table.ajax.reload();
                        form[0].reset();
                        $('#previewGambar').hide(); // Reset preview gambar kalau ada
                    }
                },
                error: function(xhr) {
                    Swal.fire("Error", "Cek kembali inputan anda", "error");
                }
            });
        });

        // FUNGSI HAPUS GLOBAL
        function globalDelete(id, url, title = "Data") {
            Swal.fire({
                title: 'Yakin hapus ' + title + '?',
                text: "Data tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire('Terhapus!', 'Data berhasil dihapus.', 'success');
                            if (typeof table !== 'undefined') table.ajax.reload();
                        }
                    });
                }
            });
        }
    </script>

    @yield('scripts')

</body>

</html>
