document.addEventListener("DOMContentLoaded", function() {
    console.log('employee.js loaded successfully');
    
    const modal = new bootstrap.Modal(document.getElementById('employeeModal'));
    const saveBtn = document.getElementById('saveEmployeeBtn');
    let currentAction = 'create';
    let currentId = null;

    // Add new employee
    document.getElementById('addEmployeeBtn').addEventListener('click', function() {
        currentAction = 'create';
        currentId = null;
        document.getElementById('employeeModalLabel').textContent = 'Add Employee';
        clearForm();
        modal.show();
    });

    // Edit employee buttons
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('editEmployeeBtn')) {
            currentAction = 'update';
            currentId = e.target.getAttribute('data-id');
            document.getElementById('employeeModalLabel').textContent = 'Edit Employee';
            
            // Fill form with data
            document.getElementById('name').value = e.target.getAttribute('data-name');
            document.getElementById('position').value = e.target.getAttribute('data-position');
            document.getElementById('office').value = e.target.getAttribute('data-office');
            document.getElementById('age').value = e.target.getAttribute('data-age');
            document.getElementById('start_date').value = e.target.getAttribute('data-start_date');
            document.getElementById('salary').value = e.target.getAttribute('data-salary');
            
            modal.show();
        }
    });

    // Save employee
    saveBtn.addEventListener('click', function() {
        const formData = new FormData();
        formData.append('name', document.getElementById('name').value);
        formData.append('position', document.getElementById('position').value);
        formData.append('office', document.getElementById('office').value);
        formData.append('age', document.getElementById('age').value);
        formData.append('start_date', document.getElementById('start_date').value);
        formData.append('salary', document.getElementById('salary').value);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

        let url = '/admin/store';
        if (currentAction === 'update') {
            url = `/admin/update/${currentId}`;
            formData.append('_method', 'PUT');
        }

        // Show loading state
        const originalText = saveBtn.innerHTML;
        saveBtn.disabled = true;
        saveBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Saving...';

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showSuccessAlert(data.message);
                modal.hide();
                
                if (currentAction === 'create') {
                    // Add new row to table
                    addRowToTable(data.employee);
                } else {
                    // Update existing row
                    updateRowInTable(data.employee);
                }
            } else {
                showErrorAlert(data.message || 'Error saving employee');
                if (data.errors) {
                    console.error('Validation errors:', data.errors);
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showErrorAlert('Network error occurred');
        })
        .finally(() => {
            // Reset button state
            saveBtn.disabled = false;
            saveBtn.innerHTML = originalText;
        });
    });

    function clearForm() {
        document.getElementById('name').value = '';
        document.getElementById('position').value = '';
        document.getElementById('office').value = '';
        document.getElementById('age').value = '';
        document.getElementById('start_date').value = '';
        document.getElementById('salary').value = '';
    }

    function addRowToTable(employee) {
        const tbody = document.querySelector('#datatablesSimple tbody');
        const newRow = document.createElement('tr');
        newRow.setAttribute('data-id', employee.id);
        
        newRow.innerHTML = `
            <td>${employee.name}</td>
            <td>${employee.position}</td>
            <td>${employee.office}</td>
            <td>${employee.age}</td>
            <td>${employee.start_date}</td>
            <td>$${parseFloat(employee.salary).toLocaleString()}</td>
            <td class="text-center">
                <button 
                    class="btn btn-sm btn-warning editEmployeeBtn"
                    data-id="${employee.id}"
                    data-name="${employee.name}"
                    data-position="${employee.position}"
                    data-office="${employee.office}"
                    data-age="${employee.age}"
                    data-start_date="${employee.start_date}"
                    data-salary="${employee.salary}">
                    <i class="fas fa-edit"></i> Edit
                </button>
                <form action="/admin/${employee.id}" method="POST" class="d-inline deleteForm">
                    <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this employee?')">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>
            </td>
        `;
        
        tbody.appendChild(newRow);
        showSuccessAlert('Employee added successfully!');
    }

    function updateRowInTable(employee) {
        const row = document.querySelector(`tr[data-id="${employee.id}"]`);
        if (row) {
            row.querySelector('td:nth-child(1)').textContent = employee.name;
            row.querySelector('td:nth-child(2)').textContent = employee.position;
            row.querySelector('td:nth-child(3)').textContent = employee.office;
            row.querySelector('td:nth-child(4)').textContent = employee.age;
            row.querySelector('td:nth-child(5)').textContent = employee.start_date;
            row.querySelector('td:nth-child(6)').textContent = `$${parseFloat(employee.salary).toLocaleString()}`;
            
            // Update the edit button data attributes
            const editBtn = row.querySelector('.editEmployeeBtn');
            editBtn.setAttribute('data-name', employee.name);
            editBtn.setAttribute('data-position', employee.position);
            editBtn.setAttribute('data-office', employee.office);
            editBtn.setAttribute('data-age', employee.age);
            editBtn.setAttribute('data-start_date', employee.start_date);
            editBtn.setAttribute('data-salary', employee.salary);
            
            showSuccessAlert('Employee updated successfully!');
        }
    }

    function showSuccessAlert(message) {
        showAlert(message, 'success');
    }

    function showErrorAlert(message) {
        showAlert(message, 'danger');
    }

    function showAlert(message, type) {
        // Remove existing alerts
        const existingAlert = document.querySelector('.alert');
        if (existingAlert) {
            existingAlert.remove();
        }

        // Create new alert
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

        // Insert alert at the top of the main content
        const mainContent = document.querySelector('.container-fluid');
        mainContent.insertBefore(alertDiv, mainContent.firstChild);

        // Auto remove after 5 seconds
        setTimeout(() => {
            if (alertDiv.parentElement) {
                alertDiv.remove();
            }
        }, 5000);
    }
    // Simpler delete handler for the alternative approach
    // Delete employee function
    function deleteEmployeeSimple(employeeId, button) {
        console.log('Starting delete for employee:', employeeId);
        
        // Store original button state
        const originalHTML = button.innerHTML;
        
        // Show loading state
        button.disabled = true;
        button.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Deleting...';
        
        // Make AJAX request
        fetch(`/admin/${employeeId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Delete success:', data);
            
            if (data.success) {
                // Find and remove the row
                const row = document.querySelector(`tr[data-id="${employeeId}"]`);
                if (row) {
                    row.style.transition = 'all 0.3s ease';
                    row.style.opacity = '0';
                    setTimeout(() => {
                        row.remove();
                        showSuccessAlert(data.message || 'Employee deleted successfully!');
                    }, 300);
                } else {
                    showSuccessAlert(data.message || 'Employee deleted successfully!');
                    // Fallback: reload if row not found
                    setTimeout(() => location.reload(), 1000);
                }
            } else {
                throw new Error(data.message || 'Delete failed');
            }
        })
        .catch(error => {
            console.error('Delete error:', error);
            showErrorAlert('Delete failed: ' + error.message);
            
            // Reset button state
            button.disabled = false;
            button.innerHTML = originalHTML;
        });
    }

    // Event listener for delete buttons
    document.addEventListener('click', function(e) {
        // Check if it's a delete button
        if (e.target.classList.contains('deleteEmployeeBtn')) {
            e.preventDefault(); // Prevent any default behavior
            e.stopPropagation(); // Stop event bubbling
            
            const employeeId = e.target.getAttribute('data-id');
            console.log('Delete button clicked for ID:', employeeId);
            
            if (confirm('Are you sure you want to delete this employee?')) {
                deleteEmployeeSimple(employeeId, e.target);
            }
        }
    });
    
});