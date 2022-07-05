<?= $this->extend('templates/index_retribusi'); ?>

<?= $this->section('content'); ?>
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Periode Retribusi Pasar & Parkir</h1>
<hr class="sidebar-divider d-none d-md-block">
<!-- DataTales Example -->
<!-- <div class="flash-data" data-flashdata="<?= session()->getFlashdata('pesan') ?>"></div> -->


<div class="row">
    <div class="col">
        <div class="data-periode"></div>
    </div>
</div>

<script>
    function dataPeriode() {
        $.ajax({
            type: "get",
            url: "<?= base_url('retribusi/data_periode') ?>",
            dataType: "json",
            success: function(response) {
                $(".data-periode").html(response.view);
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    $(document).ready(function() {
        dataPeriode();


        $("#tanggal").datepicker({
            altField: "#alternatif",
            altFormat: "yy-mm-dd",
            changeYear: true,
            changeMonth: true,
            dateFormat: "DD, dd MM yy",
            monthNames: ["Januari", "Februari", "Mart", "April", "Mai", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
            dayNames: ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"],
            dayNamesMin: ["Ming", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"],
            yearRange: "c-5:c+5"
        });

    });
</script>

<?= $this->endSection() ?>