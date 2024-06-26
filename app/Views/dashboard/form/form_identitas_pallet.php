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
                <form id="paletizationForm" action="/submit_form_identitas_pallet" method="post">
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
                    <input type="hidden" name="status_paletization" id="status_paletization" value="complete">
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

                    $(document).ready(function () {
                        $.each(response.data, function (index, row) {
                            var convertedValue = convertAndAppend(index, row.satuan, row.qty_dtg);
                            var fieldHtml = '<div class="row">';

                            var NamaBarang = '<div class="col-sm-4 mb-4"><label>Nama Barang ' + (index + 1) + ' : </label><input name="nama_barang[]" class="form-control" value="' + row.nama_barang + '" readonly></div>';
                            fieldHtml += NamaBarang;

                            var QtyBarang = '<div class="col-sm-4 mb-4"><label>Jumlah Qty Barang ' + (index + 1) + ' : </label><input name="qty_dtg[]" class="form-control qty" value="' + row.qty_dtg + '" readonly></div>';
                            fieldHtml += QtyBarang;

                            var SatuanBerat = '<div class="col-sm-4 mb-4"><label>Satuan Berat Barang ' + (index + 1) + ' : </label><input name="satuan_berat[]" class="form-control qty" value="' + row.satuan + '" readonly></div>';
                            fieldHtml += SatuanBerat;

                            var NilaiKonversi = '<div class="col-sm-4 mb-4"><label>Nilai Hasil Konversi Ke Pallet ' + (index + 1) + ' : </label><input type="text" id="nilai_konversi_' + index + '" name="nilai_konversi[]" class="form-control nilai_konversi" value="' + convertedValue + '" readonly></div>';
                            fieldHtml += NilaiKonversi;

                            var nilai_konversi_array = [];
                            var kodePalletFields = '';

                            if (convertedValue > 0) {
                                for (let i = 0; i < convertedValue; i++) {
                                    var newKodePallet = generateKodePallet();
                                    kodePalletFields += '<div class="col-sm-4 mb-4"><label>Kode Pallet ' + (index + 1) + ' (' + (i + 1) + ') : </label><input type="text" name="kode_pallet' + index + '[]" class="form-control" value="' + newKodePallet + '" readonly></div>';
                                    nilai_konversi_array.push(1);
                                }
                                fieldHtml += kodePalletFields;
                            }

                            $('#barang_container').append(fieldHtml);
                        });

                        var remainingKodePalletFields = '';
                        var remainingConvertedValues = response.remainingConvertedValues; 
                        if (remainingConvertedValues && remainingConvertedValues.length > 0) {
                            var lastIndex = response.data.length - 1;
                            remainingConvertedValues.forEach(function (value, i) {
                                var newKodePallet = generateKodePallet();
                                remainingKodePalletFields += '<div class="col-sm-4 mb-4"><label>Kode Pallet ' + (lastIndex + 1) + ' (Extra ' + (i + 1) + ') : </label><input type="text" name="kode_pallet' + lastIndex + '[]" class="form-control" value="' + newKodePallet + '" readonly></div>';
                            });
                            $('#barang_container .row:last-child').append(remainingKodePalletFields);
                        }
                    });

                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });

        $('#paletizationForm').submit(function (event) {
            event.preventDefault(); // Prevent the form from submitting normally

            var nomor_gr = $('#nomor_gr').val();

            $.ajax({
                url: '<?= site_url('/check_nomor_gr_exist') ?>',
                method: 'POST',
                data: { nomor_gr: nomor_gr },
                dataType: 'JSON',
                success: function (response) {
                    if (response.exists) {
                        alert('Tidak bisa memasukkan data kode GR karena kode GR sudah ada dalam database');
                    } else {
                        // Submit the form if nomor_gr is not in the database
                        $('#paletizationForm')[0].submit();
                    }
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
                convertedValue = Math.floor(qty == 1000) + 1;
            } else if (satuan === 'PACK') {
                convertedValue = Math.floor(qty == 2000) + 1;
            } else if (satuan === 'CTN') {
                convertedValue = Math.floor(qty == 10000) + 1;
            } else if (satuan === 'PALLET') {
                convertedValue = Math.floor(qty == 450000) + 1;
            }
            convertedValue = parseInt(convertedValue);
            $('#nilai_konversi_' + index).val(convertedValue);
            return convertedValue;
        }
    });

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
</script>

<?= $this->include('template/footer'); ?>
