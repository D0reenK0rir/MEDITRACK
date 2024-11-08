document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('new-message-form');
    const confirmationMessage = document.getElementById('confirmation-message');

    form.addEventListener('submit', (event) => {
        event.preventDefault();

        // Get form values
        const recipient = document.getElementById('recipient').value;
        const messageContent = document.getElementById('message-content').value;

        // Create a new message item
        const messagesContainer = document.querySelector('.messages-container');
        const newMessage = document.createElement('div');
        newMessage.classList.add('message-item');
        newMessage.innerHTML = `
            <p><strong>To:</strong> ${recipient}</p>
            <p><strong>Message:</strong> ${messageContent}</p>
            <button class="action-button">Reply</button>
        `;

        // Append the new message to the container
        messagesContainer.appendChild(newMessage);

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
