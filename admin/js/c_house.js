//Fix araia hidden
document.addEventListener("DOMContentLoaded", function () {
    document.addEventListener('hide.bs.modal', function (event) {
        if (document.activeElement) {
            document.activeElement.blur();
        }
    });
});

document.querySelectorAll('.btnEdit').forEach(button => 
    {
        button.addEventListener('click', (e) => {
            const id = e.target.closest('button').getAttribute('data-id');
            const name = e.target.closest('button').getAttribute('data-name');
            const address = e.target.closest('button').getAttribute('data-address');
            const phone = e.target.closest('button').getAttribute('data-phone');
            const email = e.target.closest('button').getAttribute('data-email');
            
            document.getElementById('editId_c_house').value = id;
            document.getElementById('edit_name_c_house').value = name;
            document.getElementById('edit_address').value = address;
            document.getElementById('edit_phone').value = phone;
            document.getElementById('edit_email').value = email;

            new bootstrap.Modal(document.getElementById('editModal')).show();
        });
    });

  
    document.querySelectorAll('.btnDelete').forEach(button => {
        button.addEventListener('click', (e) => {
            const id = e.target.closest('button').getAttribute('data-id');
            document.getElementById('deleteId_c_house').value = id;
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
