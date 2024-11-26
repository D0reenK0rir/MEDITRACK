document.addEventListener('DOMContentLoaded', function () {
    const messageForm = document.getElementById('message-form');
    const messageContainer = document.querySelector('.message-list');
    const confirmationMessage = document.getElementById('confirmation-message');
    const recipientNameInput = document.getElementById('recipient-name');

    // Function to load messages
    async function loadMessages(conversationPartnerId) {
        const response = await fetch(`get_messages.php?conversation_partner_id=${conversationPartnerId}`);
        const messages = await response.json();

        // Clear the message list
        messageContainer.innerHTML = '';
        
        // Display messages
        messages.forEach(message => {
            const messageItem = document.createElement('div');
            messageItem.classList.add('message-item');
            messageItem.innerHTML = `
                <p><strong>From:</strong> ${message.sender_first_name} ${message.sender_last_name}</p>
                <p>${message.message_content}</p>
                <p class="timestamp">${message.sent_at}</p>
            `;
            messageContainer.appendChild(messageItem);
        });
    }

    // Send message form submission
    messageForm.addEventListener('submit', async function (event) {
        event.preventDefault();

        const formData = new FormData(messageForm);
        const response = await fetch('send_message.php', {
            method: 'POST',
            body: formData
        });
        const result = await response.json();

        if (result.status === 'success') {
            confirmationMessage.classList.remove('hidden');
            confirmationMessage.textContent = result.message;

            // Reload messages with the selected recipient
            loadMessages(recipientNameInput.value);
            messageForm.reset(); // Clear the form
        } else {
            confirmationMessage.classList.remove('hidden');
            confirmationMessage.textContent = result.message;
        }
    });

    // Initial load of messages (assumes a recipient is selected by default)
    loadMessages(recipientNameInput.value);
});
