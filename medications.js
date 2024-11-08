document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('medication-form');
    const confirmationMessage = document.getElementById('confirmation-message');

    form.addEventListener('submit', (event) => {
        event.preventDefault();

        // Get the form values
        const medicineName = document.getElementById('medicine-name').value;
        const time = document.getElementById('time').value;

        // Create a new medication item
        const medicationList = document.querySelector('.medication-list');
        const newMedication = document.createElement('div');
        newMedication.classList.add('medication-item');
        newMedication.innerHTML = `<p><strong>Medicine:</strong> ${medicineName} <br><strong>Time:</strong> ${time}</p>`;

        // Append the new medication to the list
        medicationList.appendChild(newMedication);

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
