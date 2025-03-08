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
        $('#l_start').html('<option value="" disabled selected>Chọn điểm đón</option>'); 
        $('#l_stop').html('<option value="" disabled selected>Chọn điểm trả</option>'); 

        if (id_c_house) {
            $.ajax({
                url: '../module/trip_prices_p.php',
                type: 'POST',
                data: { action: 'get_routes', id_c_house: id_c_house },
                success: function (response) {
                    $(routeSelectId).html(response);
                }
            });

            $.ajax({
                url: '../module/trip_prices_p.php',
                type: 'POST',
                data: { action: 'get_cars', id_c_house: id_c_house },
                success: function (response) {
                    $(carSelectId).html(response);
                }
            });
        }
    }

    // Khi chọn tuyến đường, lọc các thành phố theo tuyến đường
    $('#id_route').change(function () {
        var id_route = $(this).val();

        if (id_route) {
            $.ajax({
                url: '../module/trip_prices_p.php',
                type: 'POST',
                data: { action: 'get_cities_by_route', id_route: id_route },
                success: function (response) {
                    
                    var data = JSON.parse(response);
                    var cityOptions = '<option value="" disabled selected>Chọn thành phố</option>';
                    data.forEach(function(city) {
                        cityOptions += '<option value="' + city.id_city + '">' + city.city_name + '</option>';
                    });
                    // Gán thành phố vào điểm đón và điểm trả
                    $('#l_start').html(cityOptions);
                    $('#l_stop').html(cityOptions);
                }
            });
        }
    });

    function loadCarPlates(carSelectId, plateSelectId) {
        var id_car = $(carSelectId).val();

        if (id_car) {
            $.ajax({
                url: '../module/trip_prices_p.php',
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

    // Delete
    document.querySelectorAll('.btnDelete').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            $('#deleteId_price').val(id);
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

    $(document).ready(function() {
        // Khi nhấn nút sửa
        $('.btnEdit').on('click', function() {
            var id_price = $(this).data('id'); 

            $('#edit_id_price').val(id_price);
    
            // Mở modal
            $('#editModal').modal('show');

            $.ajax({
                url: '../module/trip_prices_p.php',
                method: 'GET',
                data: { action: 'get_trip_price', id_price: id_price },
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    $('#edit_id_price').val(data.id_price);
                    $('#edit_id_route').val(data.id_route);
                    $('#edit_price').val(data.price);

                    // $('#edit_l_start').val(data.l_start);
                    // $('#edit_l_stop').val(data.l_stop);
    
                    
                    $.ajax({
                        url: '../module/trip_prices_p.php',
                        method: 'POST',
                        data: { action: 'get_cities_by_route', id_route: data.id_route },
                        dataType: 'json',
                        success: function(cities) {
                            var l_start_options = '<option value="" disabled selected>Chọn điểm đón</option>';
                            var l_stop_options  = '<option value="" disabled selected>Chọn điểm trả</option>';
    
                            $.each(cities, function(index, city) {
                                l_start_options += '<option value="' + city.id_city + '" ' + (city.id_city == data.l_start ? 'selected' : '') + '>' + city.city_name + '</option>';
                                l_stop_options  += '<option value="' + city.id_city + '" ' + (city.id_city == data.l_stop ? 'selected' : '') + '>' + city.city_name + '</option>';
                            });
                                
                            $('#edit_l_start').html(l_start_options);
                            $('#edit_l_stop').html(l_stop_options);
                        },
                        error: function() {
                            alert("Không thể tải danh sách tỉnh của tuyến đường.");
                        }
                    });
                },
                error: function() {
                    alert("Không thể tải dữ liệu chuyến xe. Vui lòng thử lại.");
                }
            });
        });
    });
    

  