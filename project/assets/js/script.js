// Konfirmasi sebelum form hapus dikirim
document.querySelectorAll('.form-hapus').forEach(function (form) {
    form.addEventListener('submit', function (e) {
        if (!confirm('Data akan dihapus permanen. Lanjutkan?')) {
            e.preventDefault();
        }
    });
});
