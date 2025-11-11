document.addEventListener("DOMContentLoaded", function() {
    const modal = new bootstrap.Modal(document.getElementById('positionModal'));
    const saveBtn = document.getElementById('savePositionBtn');
    let currentAction = 'create';

    // Event handlers
    document.getElementById('addPositionBtn').addEventListener('click', () => openModal('create'));
    saveBtn.addEventListener('click', handleSave);

    function openModal(action) {
        currentAction = action;
        document.getElementById('positionModalLabel').textContent = `${action === 'create' ? 'Add' : 'Edit'} Position`;
        clearForm();
        modal.show();
    }

    async function handleSave() {
        const formData = new FormData();
        formData.append('name', document.getElementById('name').value);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

        const url = '/admin/position/store'; // CREATE endpoint

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
            console.log('Response data:', data); // Debug log

            if (response.ok) {
                showAlert('Position created successfully!', 'success');
                modal.hide();
                
                // Handle different response formats
                const positionData = data.position || data.data || data;
                if (positionData && positionData.id) {
                    addRowToTable(positionData);
                } else {
                    // If no office data in response, reload the page
                    location.reload();
                }
            } else {
                throw new Error(data.message || 'Error saving position');
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
            <td class="text-center">
                <button class="btn btn-sm btn-warning editPositionBtn"
                    data-id="${position.id}"
                    data-name="${position.name}">
                    <i class="fas fa-edit"></i> Edit
                </button>
                <button class="btn btn-sm btn-danger deletePositionBtn" data-id="${position.id}">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </td>
        `;
        tbody.appendChild(row);
    }

    function setButtonState(button, text, loading = true) {
        button.disabled = loading;
        button.innerHTML = loading ? 
            `<span class="spinner-border spinner-border-sm"></span> ${text}` : 
            text;
    }

    function clearForm() {
        document.getElementById('name').value = '';
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