document.addEventListener("DOMContentLoaded", function() {
    const modal = new bootstrap.Modal(document.getElementById('employeeModal'));
    const saveBtn = document.getElementById('saveEmployeeBtn');
    let currentAction = 'create', currentId = null;

    // Event handlers
    document.getElementById('addEmployeeBtn').addEventListener('click', () => openModal('create'));
    document.addEventListener('click', handleButtonClicks);
    saveBtn.addEventListener('click', handleSave);

    function openModal(action, employee = null) {
        currentAction = action;
        currentId = employee?.id || null;
        document.getElementById('employeeModalLabel').textContent = `${action === 'create' ? 'Add' : 'Edit'} Employee`;
        
        if (employee) {
            ['name', 'position', 'office', 'age', 'start_date', 'salary'].forEach(field => {
                document.getElementById(field).value = employee[field];
            });
        } else {
            clearForm();
        }
        modal.show();
    }

    function handleButtonClicks(e) {
        if (e.target.classList.contains('editEmployeeBtn')) {
            const employee = {
                id: e.target.dataset.id,
                name: e.target.dataset.name,
                position: e.target.dataset.position,
                office: e.target.dataset.office,
                age: e.target.dataset.age,
                start_date: e.target.dataset.start_date,
                salary: e.target.dataset.salary
            };
            openModal('update', employee);
        }
        
        if (e.target.classList.contains('deleteEmployeeBtn')) {
            e.preventDefault();
            const employeeId = e.target.dataset.id;
            confirm('Are you sure you want to delete this employee?') && deleteEmployee(employeeId, e.target);
        }
    }

    async function handleSave() {
        const formData = new FormData();
        ['name', 'position', 'office', 'age', 'start_date', 'salary'].forEach(field => {
            formData.append(field, document.getElementById(field).value);
        });
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

        const url = currentAction === 'update' ? `/admin/update/${currentId}` : '/admin/store';
        if (currentAction === 'update') formData.append('_method', 'PUT');

        setButtonState(saveBtn, 'Saving...');

        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            });
            const data = await response.json();

            if (data.success) {
                showAlert(data.message, 'success');
                modal.hide();
                currentAction === 'create' ? addRowToTable(data.employee) : updateRowInTable(data.employee);
            } else {
                throw new Error(data.message || 'Error saving employee');
            }
        } catch (error) {
            showAlert(error.message, 'danger');
        } finally {
            setButtonState(saveBtn, currentAction === 'update' ? 'Update' : 'Save', false);
        }
    }

    async function deleteEmployee(employeeId, button) {
        setButtonState(button, 'Deleting...');
        
        try {
            const response = await fetch(`/admin/${employeeId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            const data = await response.json();

            if (data.success) {
                const row = document.querySelector(`tr[data-id="${employeeId}"]`);
                row?.remove();
                showAlert(data.message, 'success');
            } else {
                throw new Error(data.message || 'Delete failed');
            }
        } catch (error) {
            showAlert(error.message, 'danger');
            setButtonState(button, 'Delete', false);
        }
    }

    function addRowToTable(employee) {
        const tbody = document.querySelector('#datatablesSimple tbody');
        const row = document.createElement('tr');
        row.dataset.id = employee.id;
        row.innerHTML = `
            <td>${employee.name}</td>
            <td>${employee.position}</td>
            <td>${employee.office}</td>
            <td>${employee.age}</td>
            <td>${employee.start_date}</td>
            <td>$${Number(employee.salary).toLocaleString()}</td>
            <td class="text-center">
                <button class="btn btn-sm btn-warning editEmployeeBtn"
                    data-id="${employee.id}"
                    data-name="${employee.name}"
                    data-position="${employee.position}"
                    data-office="${employee.office}"
                    data-age="${employee.age}"
                    data-start_date="${employee.start_date}"
                    data-salary="${employee.salary}">
                    <i class="fas fa-edit"></i> Edit
                </button>
                <button class="btn btn-sm btn-danger deleteEmployeeBtn" data-id="${employee.id}">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </td>
        `;
        tbody.appendChild(row);
    }

    function updateRowInTable(employee) {
        const row = document.querySelector(`tr[data-id="${employee.id}"]`);
        if (row) {
            const cells = row.querySelectorAll('td');
            cells[0].textContent = employee.name;
            cells[1].textContent = employee.position;
            cells[2].textContent = employee.office;
            cells[3].textContent = employee.age;
            cells[4].textContent = employee.start_date;
            cells[5].textContent = `$${Number(employee.salary).toLocaleString()}`;
            
            const editBtn = row.querySelector('.editEmployeeBtn');
            Object.entries(employee).forEach(([key, value]) => {
                editBtn.dataset[key] = value;
            });
        }
    }

    function setButtonState(button, text, loading = true) {
        button.disabled = loading;
        button.innerHTML = loading ? 
            `<span class="spinner-border spinner-border-sm"></span> ${text}` : 
            text;
    }

    function clearForm() {
        ['name', 'position', 'office', 'age', 'start_date', 'salary'].forEach(field => {
            document.getElementById(field).value = '';
        });
    }

    function showAlert(message, type) {
        document.querySelector('.alert')?.remove();
        
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
        alertDiv.innerHTML = `${message}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
        
        document.querySelector('.container-fluid').prepend(alertDiv);
        setTimeout(() => alertDiv.remove(), 5000);
    }
});