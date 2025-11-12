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
        const pathSegments = window.location.pathname.split('/').filter(segment => segment);
        console.log('🔍 Path Segments:', pathSegments); // ['admin', 'position', '13']
        
        // The position ID is the last segment
        const positionId = pathSegments[pathSegments.length - 1];
        console.log('🔍 Extracted Position ID:', positionId);
        
        if (!positionId || isNaN(positionId)) {
            showAlert('Error: Could not determine position!', 'danger');
            return;
        }

        const formData = new FormData();
        formData.append('name', document.getElementById('name').value);
        formData.append('age', document.getElementById('age').value);
        formData.append('start_date', document.getElementById('start_date').value);
        formData.append('salary', document.getElementById('salary').value);
        formData.append('position_id', positionId);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

        const url = '/admin/employee/store';
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
            console.log('🔍 Server Response:', data);

            if (response.ok) {
                showAlert('Employee created successfully!', 'success');
                modal.hide();
                
                if (data.employee && data.employee.id) {
                    addRowToTable(data.employee);
                    if (data.available_positions !== undefined) {
                        updateAvailablePositions(data.available_positions);
                    }
                } else {
                    location.reload();
                }
            } else {
                // Show specific validation errors
                if (data.errors) {
                    console.log('🔍 Validation Errors:', data.errors);
                    let errorMessages = [];
                    for (const field in data.errors) {
                        errorMessages.push(data.errors[field][0]);
                    }
                    showAlert('Validation failed: ' + errorMessages.join(', '), 'danger');
                } else {
                    throw new Error(data.message || 'Error saving employee');
                }
            }
        } catch (error) {
            console.error('Error:', error);
            showAlert(error.message, 'danger');
        } finally {
            setButtonState(saveBtn, 'Save', false);
        }
    }

    // Function to update available positions display
    function updateAvailablePositions(availablePositions) {
        // Find and update the available positions count in the table header or somewhere visible
        const availablePositionsElement = document.querySelector('.available-positions-count');
        if (availablePositionsElement) {
            availablePositionsElement.textContent = availablePositions;
        }
        
        // Disable "Add New" button if no available positions left
        const addButton = document.getElementById('addEmployeeBtn');
        if (availablePositions <= 0) {
            addButton.disabled = true;
            addButton.title = 'No available positions';
            showAlert('No more available positions for this role!', 'warning');
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
        console.log('🔍 EMPLOYEE OBJECT FOR TABLE:', employee);
        
        // Check if DataTables is initialized
        if (typeof dataTable !== 'undefined') {
            // Use DataTables API to add row
            dataTable.row.add([
                employee.name || 'N/A',
                employee.age || 'N/A',
                employee.start_date || 'N/A',
                `$${employee.salary ? Number(employee.salary).toLocaleString() : 'N/A'}`,
                `
                <button class="btn btn-sm btn-warning editEmployeeBtn"
                    data-id="${employee.id}"
                    data-name="${employee.name}"
                    data-age="${employee.age}"
                    data-start_date="${employee.start_date}"
                    data-salary="${employee.salary}">
                    <i class="fas fa-edit"></i> Edit
                </button>
                <button class="btn btn-sm btn-danger deleteEmployeeBtn" data-id="${employee.id}">
                    <i class="fas fa-trash"></i> Delete
                </button>
                `
            ]).draw();
            console.log('✅ Row added via DataTables API');
        } else {
            // Fallback: Try to find tbody with different selectors
            let tbody = document.querySelector('#datatablesSimple tbody') || 
                    document.querySelector('.datatables tbody') ||
                    document.querySelector('table tbody');
            
            if (!tbody) {
                console.error('❌ Table body not found!');
                location.reload(); // Reload to see the new data
                return;
            }
            
            const row = document.createElement('tr');
            row.dataset.id = employee.id;
            row.innerHTML = `
                <td>${employee.name || 'N/A'}</td>
                <td>${employee.age || 'N/A'}</td>
                <td>${employee.start_date || 'N/A'}</td>
                <td>$${employee.salary ? Number(employee.salary).toLocaleString() : 'N/A'}</td>
                <td class="text-center">
                    <button class="btn btn-sm btn-warning editEmployeeBtn"
                        data-id="${employee.id}"
                        data-name="${employee.name}"
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
            console.log('✅ Row added via DOM');
        }
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