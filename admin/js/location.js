document.getElementById('add-location').addEventListener('click', function () {
    const container = document.getElementById('location-container');
    const newField = document.createElement('div');
    newField.classList.add('d-flex', 'align-items-center', 'mb-2');

    newField.innerHTML = `
        <input type="text" class="form-control" name="name_location[]" placeholder="Tên vị trí" required>
        <input type="time" class="form-control ms-2" name="time_location[]" required>
        <button type="button" class="btn btn-danger ms-2 remove-location">-</button>
    `;

    container.appendChild(newField);

    newField.querySelector('.remove-location').addEventListener('click', function () {
        newField.remove();
    });
});

document.querySelectorAll('.btnEdit').forEach(button => {
    button.addEventListener('click', function () {

        const id_location = this.getAttribute('data-id');
        console.log(id_location);


        fetch(`../module/location_p.php?id_location=${id_location}`)
            .then(response => response.json())
            .then(data => {

                document.getElementById('editId_location').value = data.id_location;
                document.getElementById('editId_trip').value = data.id_trip;
                document.getElementById('edit_trip_info').value = data.trip_info;
                document.getElementById('edit_name_location').value = data.name_location;
                document.getElementById('edit_time').value = data.time;
                document.getElementById('edit_type_location').value = data.type_location;


                new bootstrap.Modal(document.getElementById('editModal')).show();
            })
            .catch(error => console.error('Lỗi khi lấy dữ liệu:', error));
    });
});



document.querySelectorAll('.btnDelete').forEach(button => {
    button.addEventListener('click', (e) => {
        const id = e.target.closest('button').getAttribute('data-id');
        document.getElementById('deleteId_location').value = id;
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    });
});

