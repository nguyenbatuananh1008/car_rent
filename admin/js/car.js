
        document.querySelectorAll('.btnEdit').forEach(button => {
            button.addEventListener('click', () => {
                const id = button.getAttribute('data-id');
                const name = button.getAttribute('data-name');
                const type = button.getAttribute('data-type');
                const color = button.getAttribute('data-color');
                const capacity = button.getAttribute('data-capacity');
                const plate = button.getAttribute('data-plate');
                const id_c_house = button.getAttribute('data-name2');
                const img = button.getAttribute('data-img');

                document.getElementById('edit_id_car').value = id;
                document.getElementById('edit_c_name').value = name;
                document.getElementById('edit_c_type').value = type;
                document.getElementById('edit_c_color').value = color;
                document.getElementById('edit_capacity').value = capacity;
                document.getElementById('edit_c_plate').value = plate;
                document.getElementById('edit_id_c_house').value = id_c_house;
                document.getElementById('edit_preview_img').src = '../img' + img;

                const editModal = new bootstrap.Modal(document.getElementById('editModal'));
                editModal.show();
            });
        });

        document.querySelectorAll('.btnDelete').forEach(button => {
            button.addEventListener('click', () => {
                const id = button.getAttribute('data-id');
                document.getElementById('delete_id_car').value = id;

                const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
                deleteModal.show();
            });
        });

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
 