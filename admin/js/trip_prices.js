//Fix araia hidden
document.addEventListener("DOMContentLoaded", function () {
    document.addEventListener('hide.bs.modal', function (event) {
        if (document.activeElement) {
            document.activeElement.blur();
        }
    });
});

$(document).ready(function () {
    function loadRoutesAndCars(selectHouseId, routeSelectId, carSelectId, plateSelectId) {
        var id_c_house = $(selectHouseId).val();

        $(routeSelectId).html('<option value="" disabled selected>Đang tải...</option>');
        $(carSelectId).html('<option value="" disabled selected>Chọn nhà xe trước</option>');
        $(plateSelectId).html('<option value="" disabled selected>Chọn xe trước</option>');

        if (id_c_house) {
            //  tuyến đường
            $.ajax({
                url: '../module/trip_p.php',
                type: 'POST',
                data: { action: 'get_routes', id_c_house: id_c_house },
                success: function (response) {
                    $(routeSelectId).html(response);
                }
            });

            //  xe
            $.ajax({
                url: '../module/trip_p.php',
                type: 'POST',
                data: { action: 'get_cars', id_c_house: id_c_house },
                success: function (response) {
                    $(carSelectId).html(response);
                }
            });
        }
    }

    // Load data for edit modal
    function loadCarPlates(carSelectId, plateSelectId) {
        var id_car = $(carSelectId).val();

        if (id_car) {
            $.ajax({
                url: '../module/trip_p.php',
                type: 'POST',
                data: { action: 'get_car_plate', id_car: id_car },
                success: function (response) {
                    $(plateSelectId).html(response);
                }
            });
        }
    }

    // Add
    $('#name_c_house').change(function () {
        loadRoutesAndCars('#name_c_house', '#id_route', '#car_info', '#car_plate');
    });

    $('#car_info').change(function () {
        loadCarPlates('#car_info', '#car_plate');
    });

    // Xử lý sự kiện cho modal sửa
    $('#edit_name_c_house').change(function () {
        loadRoutesAndCars('#edit_name_c_house', '#edit_id_route', '#edit_car_info', '#edit_car_plate');
    });

    $('#edit_car_info').change(function () {
        loadCarPlates('#edit_car_info', '#edit_car_plate');
    });

    // Edit
    document.querySelectorAll('.btnEdit').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');

            fetch(`../module/trip_p.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    $('#edit_Id_trip').val(data.id_trip);
                    $('#edit_name_c_house').val(data.id_c_house).trigger('change');

                    setTimeout(() => {
                        $('#edit_id_route').val(data.id_route);
                        $('#edit_car_info').val(data.id_car_info).trigger('change');

                        setTimeout(() => {
                            $('#edit_car_plate').val(data.id_car_plate);
                        }, 500);
                    }, 500);

                    $('#edit_t_pick').val(data.t_pick);
                    $('#edit_t_drop').val(data.t_drop);
                    $('#edit_t_limit').val(data.t_limit);
                    $('#edit_price').val(data.price);

                    new bootstrap.Modal(document.getElementById('editModal')).show();
                })
                .catch(error => console.error('Error:', error));
        });
    });

    // Delete
    document.querySelectorAll('.btnDelete').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            $('#deleteId_trip').val(id);
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        });
    });
});
    // Search
    document.getElementById('btnSearch').addEventListener('click', function() {
        var searchKeyword = document.getElementById('searchKeyword').value;

        var form = document.createElement('form');
        form.method = 'POST';
        form.action = '';
        var inputAction = document.createElement('input');
        inputAction.type = 'hidden';
        inputAction.name = 'search_keyword';
        inputAction.value = searchKeyword;
        form.appendChild(inputAction);
        document.body.appendChild(form);
        form.submit();
    });