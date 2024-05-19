<?= $this->include('template/navigation_bar'); ?>

<title>Form Paletization</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Form Paletization</h1>
    </div>
    <div>
        <div class="card">
            <div class="card-header">
                <b>Form Paletization</b>
            </div>
            <div class="card-body">
                <form action="/submit_form_identitas_pallet" method="post">
                    <div class="row">
                        <div class="col-sm-12 mb-2">
                            <div>
                                <label>Nomor GR : </label>
                                <select name="nomor_gr" id="nomor_gr" class="form-control">
                                    <option value="" selected disabled>--- Cek Nomor GR ----</option>
                                    <?php foreach ($master_gr as $gr): ?>
                                        <option value="<?= $gr['nomor_gr'] ?>"><?= $gr['nomor_gr']; ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-1" id="barang_container">
                        </div>
                    </div>
                    <br>
                    <button class="btn btn-primary" type="submit" id="submitButton">Generate to Palletization</button>
                <div id="additional_forms_container"></div>
            </div>
        </form>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $('#supplier').select2();
        $('#nomor_gr').select2();

       
        $('#paletizationForm').submit(function (event) {
            event.preventDefault(); 
            $.ajax({
                url: '/submit_form_identitas_pallet', 
                method: 'POST', 
                data: $(this).serialize(),
                dataType: 'JSON',
                success: function (response) {
                    if (response.success) {
                    
                        $.each(response.kode_pallets, function (index, kode_pallet) {
                            $('#nilai_konversi_' + index).val(kode_pallet);
                        });
                    } else {
                        // Handle error or other conditions
                        console.log('Error:', response.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });


    $('#nomor_gr').on('change', function () {
    var nomor_gr = $(this).val();
    $.ajax({
        url: '<?= site_url('/ajax_get_nomor_gr') ?>',
        method: 'GET',
        data: { nomor_gr: nomor_gr },
        dataType: 'JSON',
        success: function (response) {
            $('#barang_container').empty();
            $('#additional_forms_container').empty();

            $.each(response.data, function (index, row) {
                var fieldHtml = '<div class="row">';

                var NamaBarang = '<div class="col-sm-4 mb-4"><label>Nama Barang ' + (index + 1) + ' : </label><input name="nama_barang[]" class="form-control" value="' + row.nama_barang + '" readonly></div>';
                fieldHtml += NamaBarang;

                var QtyBarang = '<div class="col-sm-4 mb-4"><label>Jumlah Qty Barang ' + (index + 1) + ' : </label><input name="qty_dtg[]" class="form-control qty" value="' + row.qty_dtg + '" readonly></div>';
                fieldHtml += QtyBarang;

                var SatuanBerat = '<div class="col-sm-4 mb-4"><label>Satuan Berat Barang ' + (index + 1) + ' : </label><input name="satuan_berat[]" class="form-control qty" value="' + row.satuan + '" readonly></div>';
                fieldHtml += SatuanBerat;
                
                var convertedValue = convertAndAppend(index, row.satuan, row.qty_dtg);


                var NilaiKonversi = '<div class="col-sm-4 mb-4"><label>Nilai Hasil Konversi Ke Pallet ' + (index + 1) + ' : </label><input type="text" id="nilai_konversi_' + index + '" name="nilai_konversi[]" class="form-control nilai_konversi" value="' + convertedValue + '" readonly></div>';
                fieldHtml += NilaiKonversi;

                // var SisaBarangPallet = '<div class="col-sm-4 mb-4"><label>Nilai Sisa Barang : ' + (index + 1) + ' : </label><input type="text" id="nilai_konversi_' + index + '" name="nilai_konversi[]" class="form-control nilai_konversi" value="' + parseFloat(convertedValue) + '" readonly></div>';
                // fieldHtml += SisaBarangPallet;

                var nilai_konversi_array = [];

if (convertedValue > 0) {
    var kodePalletFields = '';
    for (let i = 0; i < convertedValue; i++) {
        var newKodePallet = generateKodePallet();
        kodePalletFields += '<div class="col-sm-4 mb-4"><label>Kode Pallet ' + (index + 1) + ' (' + (i + 1) + ') : </label><input type="text" name="kode_pallet' + index + '[]" class="form-control" value="' + newKodePallet + '" readonly></div>';
        nilai_konversi_array.push(1); // Assume nilai_konversi is 1 for each kode_pallet
    }
    fieldHtml += kodePalletFields;
}

    $('#barang_container').append(fieldHtml);
            });
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
        }
    });
});



function generateKodePallet() {
    return 'PALLET-' + generateUniqueCode();
}

function generateUniqueCode() {
    return Math.floor(Math.random() * 1000000); // Generate a random 6-digit number
}

function convertAndAppend(index, satuan, qty) {
    let convertedValue = qty;

    if (satuan === 'KG') {
        convertedValue = qty / 1000;
    } else if (satuan === 'PACK') {
        convertedValue = qty / 2000;
    } else if (satuan === 'CTN') {
        convertedValue = qty / 10000;
    } else if (satuan === 'PALLET') {
        convertedValue = qty / 450000;
    }
    convertedValue = parseInt(convertedValue);
    $('#nilai_konversi_' + index).val(convertedValue);
    return convertedValue;
}


function fetchKodePallet(convertedValue, index) {
        $.ajax({
            url: '/fetch_kode_pallet', // Replace with your endpoint to fetch kode_pallet
            method: 'POST',
            data: { convertedValue: convertedValue }, // Send convertedValue to server
            dataType: 'JSON',
            success: function (response) {
                if (response.success) {
                    $('#kode_pallet_' + index).val(response.kode_pallet); // Assuming you have an input field for kode_pallet
                } else {
                    console.log('Error fetching kode_pallet:', response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error fetching kode_pallet:', error);
            }
        });
    }


    $.ajax({
            url: '<?= base_url('/ambil_kode_pallet'); ?>',
            type: 'GET',
            success: function (hasil) {
                var code = $.parseJSON(hasil);
                $('#kode_pallet').val(code); 
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
            }
        });
    });
</script>

<?= $this->include('template/footer'); ?>
