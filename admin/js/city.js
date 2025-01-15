document.querySelectorAll('.btnEdit').forEach(button => {
    button.addEventListener('click', (e) => {
        const id = e.target.closest('button').getAttribute('data-id');
        const name = e.target.closest('button').getAttribute('data-city_name');
        
        document.getElementById('editId_city').value = id;
        document.getElementById('edit_city_name').value = name; 
        
        new bootstrap.Modal(document.getElementById('editModal')).show();
    });
});

document.querySelectorAll('.btnDelete').forEach(button => {
        button.addEventListener('click', (e) => {
            const id = e.target.closest('button').getAttribute('data-id');
            document.getElementById('deleteId_city').value = id;
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
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
