document.getElementById('add-location').addEventListener('click', async function () {
    const container = document.getElementById('location-container');
    const newField = document.createElement('div');
    newField.classList.add('d-flex', 'align-items-center', 'mb-2');

    const cityOptions = await fetch('../module/location_p.php?get_city')
        .then(response => response.text())
        .catch(error => console.error("Lỗi lấy danh sách thành phố:", error));
        console.log(cityOptions);

    newField.innerHTML = `
        <input type="text" class="form-control" name="name_location[]" placeholder="Tên địa điểm" required>
        <input list="cities" name="city_name[]" placeholder = "Tên thành phố" required class="form-control ms-2">
        <datalist id="cities"> ${cityOptions}</datalist>
        <input type="time" class="form-control ms-2" name="time_location[]" required>
        <button type="button" class="btn btn-danger ms-2 remove-location">-</button>
    `;
    container.appendChild(newField);

    newField.querySelector('.remove-location').addEventListener('click', function () {
        newField.remove();
    });
});


document.addEventListener("DOMContentLoaded", function () {
    const editButtons = document.querySelectorAll(".btnEdit");

    editButtons.forEach(button => {
        button.addEventListener("click", function () {
            document.getElementById("editId_location").value = this.dataset.id;
            document.getElementById("edit_route_info").value = this.dataset.route;
            document.getElementById("edit_name_location").value = this.dataset.name;
            document.getElementById("edit_city_name").value = this.dataset.city;
            document.getElementById("edit_time").value = this.dataset.time;
            document.getElementById("edit_type_location").value = this.dataset.type;
        });
    });
});


document.querySelectorAll('.btnDelete').forEach(button => {
    button.addEventListener('click', (e) => {
        const id = e.target.closest('button').getAttribute('data-id');
        document.getElementById('deleteId_location').value = id;
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    });
});

