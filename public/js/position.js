document.addEventListener("DOMContentLoaded", function() {
    const modal = new bootstrap.Modal(document.getElementById('positionModal'));
    const saveBtn = document.getElementById('savePositionBtn');
    let currentAction = 'create';

    // Get the current office ID from the URL
    const pathSegments = window.location.pathname.split('/');
    const officeId = pathSegments[pathSegments.length - 1];

    // Event handlers
    document.getElementById('addPositionBtn').addEventListener('click', () => openModal('create'));
    saveBtn.addEventListener('click', handleSave);

    // Edit button click (event delegation)
    document.addEventListener('click', function(e) {
        if (e.target.closest('.editPositionBtn')) {
            const button = e.target.closest('.editPositionBtn');
            const positionData = {
                id: button.dataset.id,
                name: button.dataset.name,
                total_employee_count: button.dataset.total_employee_count,
                hired_employee_count: button.dataset.hired_employee_count,
                available_position: button.dataset.available_position
            };
            openModal('update', positionData);
        }
    });

    function openModal(action, position = null) {
        currentAction = action;
        document.getElementById('positionModalLabel').textContent = `${action === 'create' ? 'Add' : 'Edit'} Position`;
        
        if (position) {
            // Fill form with existing data for editing
            document.getElementById('position_id').value = position.id;
            document.getElementById('name').value = position.name;
            document.getElementById('total_employee_count').value = position.total_employee_count;
        } else {
            clearForm();
        }
        modal.show();
    }

    async function handleSave() {
        const formData = new FormData();
        formData.append('name', document.getElementById('name').value);
        formData.append('total_employee_count', document.getElementById('total_employee_count').value);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

        let url = `/admin/office/${officeId}/positions`;
        let method = 'POST';

        // If updating, change URL and method
        if (currentAction === 'update') {
            const positionId = document.getElementById('position_id').value;
            url = `/admin/positions/${positionId}`;
            method = 'PUT';
            formData.append('_method', 'PUT');
        }

        setButtonState(saveBtn, 'Saving...');

        try {
            const response = await fetch(url, {
                method: method,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            });
            
            const data = await response.json();
            console.log('Response data:', data);

            if (response.ok) {
                showAlert(`Position ${currentAction === 'create' ? 'created' : 'updated'} successfully!`, 'success');
                modal.hide();
                
                if (data.position && data.position.id) {
                    if (currentAction === 'create') {
                        addRowToTable(data.position);
                    } else {
                        updateRowInTable(data.position);
                    }
                } else {
                    location.reload();
                }
            } else {
                throw new Error(data.message || `Error ${currentAction === 'create' ? 'saving' : 'updating'} position`);
            }
        } catch (error) {
            console.error('Error:', error);
            showAlert(error.message, 'danger');
        } finally {
            setButtonState(saveBtn, 'Save', false);
        }
    }

    function addRowToTable(position) {
        const tbody = document.querySelector('#datatablesSimple tbody');
        const row = document.createElement('tr');
        row.dataset.id = position.id;
        row.innerHTML = `
            <td>
                <a href="/position/${position.id}" class="text-decoration-none">
                    ${position.name}
                </a>
            </td>
            <td>${position.total_employee_count}</td>
            <td>${position.hired_employee_count || 0}</td>
            <td>${position.total_employee_count - (position.hired_employee_count || 0)}</td>
            <td class="text-center">
                <button class="btn btn-sm btn-warning editPositionBtn"
                    data-id="${position.id}"
                    data-name="${position.name}"
                    data-total_employee_count="${position.total_employee_count}"
                    data-hired_employee_count="${position.hired_employee_count || 0}"
                    data-available_position="${position.total_employee_count - (position.hired_employee_count || 0)}">
                    <i class="fas fa-edit"></i> Edit
                </button>
                <button class="btn btn-sm btn-danger deletePositionBtn" data-id="${position.id}">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </td>
        `;
        tbody.appendChild(row);
    }

    function updateRowInTable(position) {
        const row = document.querySelector(`tr[data-id="${position.id}"]`);
        if (row) {
            const cells = row.querySelectorAll('td');
            cells[0].innerHTML = `<a href="/position/${position.id}" class="text-decoration-none">${position.name}</a>`;
            cells[1].textContent = position.total_employee_count;
            cells[2].textContent = position.hired_employee_count || 0;
            cells[3].textContent = position.total_employee_count - (position.hired_employee_count || 0);
            
            // Update edit button data attributes
            const editBtn = row.querySelector('.editPositionBtn');
            editBtn.dataset.name = position.name;
            editBtn.dataset.total_employee_count = position.total_employee_count;
            editBtn.dataset.hired_employee_count = position.hired_employee_count || 0;
            editBtn.dataset.available_position = position.total_employee_count - (position.hired_employee_count || 0);
        }
    }

    function setButtonState(button, text, loading = true) {
        button.disabled = loading;
        button.innerHTML = loading ? 
            `<span class="spinner-border spinner-border-sm"></span> ${text}` : 
            text;
    }

    function clearForm() {
        document.getElementById('position_id').value = '';
        document.getElementById('name').value = '';
        document.getElementById('total_employee_count').value = '';
    }

    function showAlert(message, type) {
        document.querySelector('.alert')?.remove();
        
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
        alertDiv.innerHTML = `${message}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
        
        document.querySelector('.card').prepend(alertDiv);
        setTimeout(() => alertDiv.remove(), 5000);
    }
});