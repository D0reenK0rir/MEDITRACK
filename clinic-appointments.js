document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('new-appointment-form');
    const confirmationMessage = document.getElementById('confirmation-message');

    form.addEventListener('submit', (event) => {
        event.preventDefault();

        // Get form values
        const patientName = document.getElementById('patient-name').value;
        const date = document.getElementById('appointment-date').value;
        const time = document.getElementById('appointment-time').value;

        // Create a new appointment item
        const appointmentList = document.querySelector('.appointment-list');
        const newAppointment = document.createElement('div');
        newAppointment.classList.add('appointment-item');
        newAppointment.innerHTML = `
            <p><strong>Patient:</strong> ${patientName} <br><strong>Date:</strong> ${date} <br><strong>Time:</strong> ${time}</p>
            <button class="action-button">Mark as Completed</button>
        `;

        // Append the new appointment to the list
        appointmentList.appendChild(newAppointment);

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
