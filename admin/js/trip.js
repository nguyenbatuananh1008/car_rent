$(document).ready(function() {
    $('#name_c_house').change(function() {
        var id_c_house = $(this).val();

        $('#id_route').html('<option value="" disabled selected>Đang tải...</option>');
        $('#car_info').html('<option value="" disabled selected>Chọn nhà xe trước</option>');
        $('#car_plate').html('<option value="" disabled selected>Chọn xe trước</option>');

        if (id_c_house) {
            //Nhà xe -> Tuyến Đường
            $.ajax({
                url: '../module/trip_p.php',
                type: 'POST',
                data: { action: 'get_routes', id_c_house: id_c_house },
                success: function(response) {
                    $('#id_route').html(response);
                }
            });

            //Nhà xe -> Xe
            $.ajax({
                url: '../module/trip_p.php',
                type: 'POST',
                data: { action: 'get_cars', id_c_house: id_c_house },
                success: function(response) {
                    $('#car_info').html(response);
                }
            });
        }
    });

    // Xe -> Biển số xe
    $('#car_info').change(function() {
        var id_car = $(this).val();

        if (id_car) {
            $.ajax({
                url: '../module/trip_p.php',
                type: 'POST',
                data: { action: 'get_car_plate', id_car: id_car },
                success: function(response) {
                    $('#car_plate').html(response);
                }
            });
        }
    });
});

document.querySelectorAll('.btnDelete').forEach(button => {
    button.addEventListener('click', function () {
        const id = this.getAttribute('data-id');
        document.getElementById('deleteId_trip').value = id;
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    });
});