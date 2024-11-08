document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('message-form');
    const confirmationMessage = document.getElementById('confirmation-message');

    form.addEventListener('submit', (event) => {
        event.preventDefault();

        // Get form values
        const recipientName = document.getElementById('recipient-name').value;
        const subject = document.getElementById('subject').value;
        const messageContent = document.getElementById('message').value;

        // Create a new message item
        const messageList = document.querySelector('.message-list');
        const newMessage = document.createElement('div');
        newMessage.classList.add('message-item');
        newMessage.innerHTML = `
            <p><strong>From:</strong> You <br><strong>Subject:</strong> ${subject} <br><strong>Date:</strong> ${new Date().toLocaleDateString()}</p>
            <p>${messageContent}</p>
        `;

        // Append the new message to the list
        messageList.appendChild(newMessage);

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
