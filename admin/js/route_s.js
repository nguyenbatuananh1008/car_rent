//Fix araia hidden
document.addEventListener("DOMContentLoaded", function () {
    document.addEventListener('hide.bs.modal', function (event) {
        if (document.activeElement) {
            document.activeElement.blur();
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const firstNumberStopInput = document.querySelector('input[name="number_stop[]"]');
    if (firstNumberStopInput) {
        firstNumberStopInput.value = 1;
    }

    document.getElementById('add-route-stop').addEventListener('click', async function () {
        const container = document.getElementById('route_stop-container');
        const newField = document.createElement('div');
        newField.classList.add('d-flex', 'align-items-center', 'mb-2');

        const cityOptions = await fetch('../module/route_sp.php?get_city')
            .then(response => response.text())
            .catch(error => console.error("Lỗi lấy danh sách thành phố:", error));

        newField.innerHTML = `
            <input type="text" class="form-control ms" name="route_stop[]" placeholder="Tên thành phố" list="city-list" required>
            <datalist id="city-list">
                ${cityOptions}
            </datalist>
            <input type="text" class="form-control ms-2 number-stop" name="number_stop[]" placeholder="Số thứ tự dừng" required >
            <button type="button" class="btn btn-danger ms-2 remove-route-stop">-</button>
        `;
        container.appendChild(newField);


        const allNumberStops = container.querySelectorAll('input[name="number_stop[]"]'); 
        const numberStopInput = newField.querySelector('input[name="number_stop[]"]');
        numberStopInput.value = allNumberStops.length; 


        newField.querySelector('.remove-route-stop').addEventListener('click', function () {
            newField.remove();
            updateNumberStops();
        });
    });
   
    function updateNumberStops() {
        const allNumberStops = document.querySelectorAll('input[name="number_stop[]"]');
        allNumberStops.forEach((input, index) => {
            input.value = index + 1; 
        });
    }
});


// Delete route
document.querySelectorAll('.btnDelete').forEach(button => {
    button.addEventListener('click', function () {
        const id = this.getAttribute('data-id');
        document.getElementById('deleteId_route').value = id;
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    });
});