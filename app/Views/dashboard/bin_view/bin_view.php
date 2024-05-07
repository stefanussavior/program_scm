<?= $this->include('template/navigation_bar'); ?>
    <title>Seat Reservation</title>
    <style>
        #seat-map {
    display: flex;
    flex-wrap: wrap;
}

.seat {
    width: 40px;
    height: 40px;
    margin: 5px;
    background-color: #ccc;
    text-align: center;
    line-height: 40px;
    cursor: pointer;
    border-radius: 5px 5px
}

.seat.reserved {
    background-color: #f00; /* Change color for reserved seats */
}

.seat.selected {
    background-color: #0f0; /* Change color for selected seats */
}

.seat:hover {
    background-color: #aaa;
}
    </style>
</head>
<body>
    <div class="container-fluid">
        <h1>Add BIN Location</h1>
        <input type="text" id="user_name" name="user_name" class="form-control" placeholder="Your name">
        <br>
        <select name="seat_group" id="seat_group" class="form-control">
            <option value="group-a">Group A</option>
            <option value="group-b">Group B</option>
        </select>
        <input type="hidden" name="is_reserved" id="is_reserved" value=1>
        <br/>
        <br>
        <div id="seat-map">
            <!-- Seat map will be generated here -->
        </div>
        <br>
        <button id="reverse-btn">Submit Location</button>
    </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            $(document).ready(function() {
                // Load seat map
                loadSeatMap();
                // Function to load seat map
                function loadSeatMap() {
                    $.ajax({
                        url: '<?= site_url('/check_available') ?>',
                        type: 'POST',
                        dataType: 'json',
                        success: function(response) {
                            var seatMapHtml = '';
                            for (var i = 1; i <= 50; i++) {
                                seatMapHtml += '<div class="seat';
                                if (!response.available) {
                                    seatMapHtml += ' reserved';
                                }
                                seatMapHtml += '" data-seat="' + i + '">' + i + '</div>';
                            }
                            $('#seat-map').html(seatMapHtml);
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                        }
                    });
                }
                // Seat click event
                $('#seat-map').on('click', '.seat:not(.reserved)', function(){
                    $(this).toggleClass('selected');
                });
                $('#reverse-btn').on('click', function() {
                    let selectedSeats = $('.seat.selected').map(function() {
                        return $(this).data('seat');
                    }).get();
                    let userName = $('#user_name').val();
                    let seatGroup = $('#seat_group').val();
                    let isReserved = $('#is_reserved').val();
                    $.ajax({
                        url: '<?= site_url('/reverse_seats') ?>',
                        type: 'POST',
                        dataType: 'JSON',
                        data: {
                            seat_numbers:selectedSeats,
                            user_name:userName,
                            seat_group:seatGroup,
                            is_reserved:isReserved
                        },
                        success: function(response) {
                            if (response.success) {
                                alert('Submit Location successfully');
                                loadSeatMap();
                            } else {
                                alert('Failed to reserved seat');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                        }
                    });
                });
            });
            </script>
<?= $this->include('template/footer'); ?>