document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('new-record-form');
    const confirmationMessage = document.getElementById('confirmation-message');

    form.addEventListener('submit', (event) => {
        event.preventDefault();

        // Get form values
        const patientName = document.getElementById('patient-name').value;
        const age = document.getElementById('patient-age').value;
        const contact = document.getElementById('patient-contact').value;
        const medicalHistory = document.getElementById('medical-history').value;

        // Create a new table row
        const tableBody = document.querySelector('.records-table tbody');
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>New</td>
            <td>${patientName}</td>
            <td>${age}</td>
            <td>${contact}</td>
            <td>${medicalHistory}</td>
            <td><button class="action-button">View Details</button></td>
        `;

        // Append the new row to the table
        tableBody.appendChild(newRow);

        // Show confirmation message
        confirmationMessage.classList.remove('hidden');

        // Clear form fields
        form.reset();

        // Hide the confirmation message after 3 seconds
        setTimeout(() => {
            confirmationMessage.classList.add('hidden');
        }, 3000);
    });
});
