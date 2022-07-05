const flashdataSukses = $(".flash-data").data('flashdata');

if (flashdataSukses) {
    Swal.fire(
        'Sukses',
        `${flashdataSukses}`,
        'success'
    )
}
const flashdataError = $(".flash-data-error").data('error');

if (flashdataError) {
    Swal.fire(
        'Gagal',
        `${flashdataError}`,
        'warning'
    )
}
