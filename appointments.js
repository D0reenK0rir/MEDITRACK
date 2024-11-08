document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('appointment-form');
    const confirmationMessage = document.getElementById('confirmation-message');

    form.addEventListener('submit', (event) => {
        event.preventDefault();

        // Get form values
        const doctorName = document.getElementById('doctor-name').value;
        const date = document.getElementById('date').value;
        const time = document.getElementById('time').value;

        // Create a new appointment item
        const appointmentList = document.querySelector('.appointment-list');
        const newAppointment = document.createElement('div');
        newAppointment.classList.add('appointment-item');
        newAppointment.innerHTML = `<p><strong>Appointment:</strong> Dr. ${doctorName} <br><strong>Date:</strong> ${date} <br><strong>Time:</strong> ${time}</p>`;

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
