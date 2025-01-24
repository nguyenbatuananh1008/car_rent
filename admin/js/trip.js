
document.getElementById("name_c_house").addEventListener("change", function () {
    const id_c_house = this.value;
    const carSelect = document.getElementById("c_plate");

    carSelect.innerHTML = "<option value='' disabled selected>Đang tải...</option>";

    fetch("../module/trip_p.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `id_c_house=${id_c_house}`,
    })
        .then((response) => response.json())
        .then((data) => {
            carSelect.innerHTML = "<option value='' disabled selected>Chọn biển số</option>";
            data.forEach((car) => {
                carSelect.innerHTML += `<option value="${car.id_car}">${car.c_plate}</option>`;
            });
        })
        .catch((error) => {
            console.error("Error fetching cars:", error);
            carSelect.innerHTML = "<option value='' disabled>Không thể tải dữ liệu</option>";
        });
});

document.getElementById("edit_name_c_house").addEventListener("change", function () {
    const id_c_house = this.value;
    const carSelect = document.getElementById("edit_c_plate");

    carSelect.innerHTML = "<option value='' disabled selected>Đang tải...</option>";

    fetch("../module/trip_p.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `id_c_house=${id_c_house}`,
    })
        .then((response) => response.json())
        .then((data) => {
            carSelect.innerHTML = "<option value='' disabled selected>Chọn biển số</option>";
            data.forEach((car) => {
                carSelect.innerHTML += `<option value="${car.id_car}">${car.c_plate}</option>`;
            });
        })
        .catch((error) => {
            console.error("Error fetching cars:", error);
            carSelect.innerHTML = "<option value='' disabled>Không thể tải dữ liệu</option>";
        });
});
    
document.querySelectorAll('.btnEdit').forEach(button => {
    button.addEventListener('click', function () {
        const id = this.getAttribute('data-id');

        fetch(`../module/trip_p.php?id=${id}`)
            .then(response => response.json())
            .then(data => {

                document.getElementById('editId_trip').value = data.id_trip;
                document.getElementById('edit_name_c_house').value = data.id_c_house;
                document.getElementById('edit_id_city_from').value = data.id_city_from;
                document.getElementById('edit_id_city_to').value = data.id_city_to;
                document.getElementById('edit_t_pick').value = data.t_pick;
                document.getElementById('edit_t_drop').value = data.t_drop;
                document.getElementById('edit_t_limit').value = data.t_limit;
                document.getElementById('edit_price').value = data.price;


                const carHouseSelect = document.getElementById('edit_name_c_house');
                carHouseSelect.dispatchEvent(new Event('change'));


                setTimeout(() => {
                    document.getElementById('edit_c_plate').value = data.id_car;
                }, 500);


                new bootstrap.Modal(document.getElementById('editModal')).show();
            })
            .catch(error => console.error('Error:', error));
    });
});

document.querySelectorAll('.btnDelete').forEach(button => {
    button.addEventListener('click', (e) => {
        const id = e.target.closest('button').getAttribute('data-id');
        document.getElementById('deleteId_trip').value = id;
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    });
});

document.getElementById('btnSearch').addEventListener('click', function () {
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





