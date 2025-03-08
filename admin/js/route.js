document.querySelectorAll('.btnEdit').forEach(button => {
    button.addEventListener('click', function () {
        const id = this.getAttribute('data-id');

        fetch(`../module/route_p.php?id=${id}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('editId_route').value = data.id_route;
                document.getElementById('edit_id_c_house').value = data.id_c_house;
                document.getElementById('edit_id_city_from').value = data.id_city_from;
                document.getElementById('edit_id_city_to').value = data.id_city_to;
                

                new bootstrap.Modal(document.getElementById('editModal')).show();
            })
            .catch(error => console.error('Error:', error));
    });
});

    document.querySelectorAll('.btnDelete').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            document.getElementById('deleteId_route').value = id;
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

    
 

