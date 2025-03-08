document.querySelectorAll('.btnEdit').forEach(button => {
    button.addEventListener('click', (e) => {
        const id = e.target.closest('button').getAttribute('data-id');
        const id_trip = e.target.closest('button').getAttribute('data-id_trip');
        const name = e.target.closest('button').getAttribute('data-name');
        const phone = e.target.closest('button').getAttribute('data-phone');
        const email = e.target.closest('button').getAttribute('data-email');
        const number_seat = e.target.closest('button').getAttribute('data-number_seat');
        const total_price = e.target.closest('button').getAttribute('data-total_price');
        const method = e.target.closest('button').getAttribute('data-method');
        const date = e.target.closest('button').getAttribute('data-date');
        const status = e.target.closest('button').getAttribute('data-status');

        document.getElementById('edit_Id_ticket').value = id;
        document.getElementById('edit_id_trip').value = id_trip;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_phone').value = phone;
        document.getElementById('edit_email').value = email;
        document.getElementById('edit_number_seat').value = number_seat;
        document.getElementById('edit_total_price').value = total_price;
        document.getElementById('edit_method').value = method;
        document.getElementById('edit_date').value = date;
        document.getElementById('edit_status').value = status;

        new bootstrap.Modal(document.getElementById('editModal')).show();
    });
});

document.querySelectorAll('.btnDelete').forEach(button => {
    button.addEventListener('click', (e) => {
        const id = e.target.closest('button').getAttribute('data-id');
        document.getElementById('deleteId_ticket').value = id;
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