<script src="{{ asset('assets/admin/vendors/sweetalert2/sweetalert2.min.js') }}"></script>
<script>
    function formatRupiah(angka) {
        if (!angka) return 'Rp 0';
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(angka);
    }
</script>
