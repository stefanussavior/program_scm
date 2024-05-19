<?= $this->include('template/navigation_bar'); ?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<title>Seat Status</title>
<style>
    #seat-map {
        display: flex;
        flex-wrap: wrap;
    }

    #seat-container {
        display: flex;
        justify-content: center;
        align-items: center;
        max-width: 400px;
    }

    .seat {
        width: 40px;
        height: 40px;
        margin: 5px;
        background-color: #ccc;
        /* Default color for available seats */
        text-align: center;
        line-height: 40px;
        cursor: pointer;
        border-radius: 8px;
    }

    .reserved {
        background-color: #f00;
        /* Color for reserved seats */
    }

    .available:hover {
        background-color: #aaa;
        /* Hover color for available seats */
    }

    .reserved:hover {
        background-color: #f00;
        /* Hover color for reserved seats */
    }

    .seat2 {
        width: 40px;
        height: 40px;
        margin: 5px;
        background-color: blue;
        /* Default color for available seats */
        text-align: center;
        line-height: 40px;
        cursor: pointer;
        border-radius: 40px;
    }

    .btn-ruangan {
        width: 80px;
        height: 50px;
        cursor: pointer;
        border-radius: 5px;
    }

    .btn-ruangan:hover {
        background-color: blue;
        color: white;
    }

    .row {
        flex-wrap: wrap;
        margin-right: 11px;
        margin-left: -15px;
    }

    .column {
        flex: 5.55%;
        /* Divide by 18 (number of seats per row) */
        padding: 5px;
    }

    #seat-map2 {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .seat-buttons {
        margin-bottom: 20px;
    }
</style>
<div class="container-fluid">
    <h2>BIN Location</h2>
    <br>
    <div id="seat-map2">
        <div class="seat-buttons">
            <?php foreach ($master_bin_location as $bin): ?>
                <button class="btn btn-secondary btn-ruangan" data-group="<?php echo $bin['bin_location']; ?>">
                    <?php echo $bin['bin_location']; ?>
                </button>
            <?php endforeach; ?>
        </div>
        <div id="seat-container"></div>
    </div>
</div>

<!-- The Modal -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Data Pallet BIN</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="kode_pallet"></div>
                <div id="nama_barang"></div>
                <div id="total_qty_barang"></div>
                <div id="satuan"></div>
                <div id="exp_date"></div>
                <div id="lokasi_rack"></div>
                <div id="bin_location"></div>
                <div id="modal-data"></div>
                <div id="modal-status"></div>
                <br>
                <p><b>Kode pada QRCode : </b></p>
                <div id="qrcode">
                    
                </div> <!-- QR code will be generated here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="generate_qr">Generate To QRCode</button>
                <button type="button" class="btn btn-danger" id="print_qrcode">Print data QRCode</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<script>
    $(document).ready(function () {
        $('.btn-ruangan').click(function () {
            var group = $(this).data('group');
            $.ajax({
                url: '<?= base_url('/group_bin_data') ?>',
                type: 'POST',
                data: { group: group },
                dataType: 'json',
                success: function (response) {
                    let seatMapHtml = '';
                    let x = 9;
                    let y = 8;
                    for (let i = 1; i <= y; i++) {
                        seatMapHtml += '<div class="row">';
                        for (let j = 1; j <= x; j++) {
                            let seatNumber = (j - 1) * y + i;
                            seatMapHtml += '<div class="column">';
                            seatMapHtml += '<div class="seat ';
                            if (response[seatNumber] === 1) {
                                seatMapHtml += 'reserved';
                            } else {
                                seatMapHtml += 'available';
                            }
                            seatMapHtml += '">' + seatNumber + '</div>';
                            seatMapHtml += '</div>';
                        }
                        seatMapHtml += '</div>';
                    }
                    $('#seat-container').html(seatMapHtml);
                },
                error: function (xhr, status, error) {
                    console.error('Error : ', error);
                }
            });
        });

        // Click event for reserved seats
        $(document).on('click', '.seat', function () {
            var bin_location = $(this).text(); // Get the seat number from the text content
            $.ajax({
                url: '<?= base_url('/ajax_get_seat_data') ?>', // Correct endpoint name
                type: 'GET',
                data: { bin_location: bin_location }, // Remove seatStatus if not needed
                dataType: 'json',
                success: function (response) {
                    $('#kode_pallet').html("Kode Pallet : " + response[0].kode_pallet);
                    $('#nama_barang').html("Nama Barang : " + response[0].nama_barang);
                    $('#total_qty_barang').html("Total Qty Barang : " + response[0].total_qty);
                    $('#exp_date').html("Expired Date : " + response[0].exp_date);
                    $('#satuan').html("Satuan Berat : " + response[0].satuan);
                    $('#lokasi_rack').html("Lokasi Rack : " + response[0].rack);
                    $('#bin_location').html("Nomor BIN Location : " + response[0].bin_location);
                    $('#myModal').modal('show');
                },
                error: function (xhr, status, error) {
                    console.error('Error : ', error);
                }
            });
        });

        // Generate QR code
        $('#generate_qr').click(function () {
            var qrData = {
                kode_pallet: $('#kode_pallet').text(),
                nama_barang: $('#nama_barang').text(),
                total_qty_barang: $('#total_qty_barang').text(),
                satuan: $('#satuan').text(),
                exp_date: $('#exp_date').text(),
                lokasi_rack: $('#lokasi_rack').text(),
                bin_location: $('#bin_location').text()
            };

            // Construct URL with query parameters
            var url = '<?= base_url('/show_data') ?>?' + $.param(qrData);

            // Clear any existing QR code
            $('#qrcode').html('');

            // Generate QR code with high resolution
            var qrcode = new QRCode(document.getElementById("qrcode"), {
                text: url,
                width: 380, // Increased width for higher resolution
                height: 380 // Increased height for higher resolution
            });

            console.log('QR Code generated');
        });
        $(document).on('click', '.modal .close', function () {
            $('#myModal').modal('hide');
        });


        $('#print_qrcode').click(function () {
            var palletData = {
        kode_pallet: $('#kode_pallet').text(),
        nama_barang: $('#nama_barang').text(),
        total_qty_barang: $('#total_qty_barang').text(),
        satuan: $('#satuan').text(),
        exp_date: $('#exp_date').text(),
        lokasi_rack: $('#lokasi_rack').text(),
        bin_location: $('#bin_location').text()
    };
    generatePDF(palletData);
            });

            function generatePDF(palletData) {
    // Get the QR code image data URL
    var qrCodeImageData = $('#qrcode canvas')[0].toDataURL('image/png');

    // Define the PDF document structure
    var docDefinition = {
        content: [
            // { text: "Data Pallet BIN", style: 'header' },
            { text: palletData.kode_pallet, style: 'subheader' },
            { text: palletData.nama_barang, style: 'subheader' },
            { text: palletData.total_qty_barang, style: 'subheader' },
            { text: palletData.exp_date, style: 'subheader' },
            { text: palletData.satuan, style: 'subheader' },
            { text: palletData.lokasi_rack, style: 'subheader' },
            { text: palletData.bin_location, style: 'subheader' },
            { image: qrCodeImageData, width: 200, alignment: 'center', margin: [0, 20] } // Add the QR code image to the PDF
        ],
        styles: {
            header: { fontSize: 18, bold: true, margin: [0, 0, 0, 10] },
            subheader: { fontSize: 14, bold: true, margin: [0, 5] }
        }
    };

    // Generate the PDF
    pdfMake.createPdf(docDefinition).open();
}

    });
</script>


<?= $this->include('template/footer'); ?>