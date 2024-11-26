document.addEventListener('DOMContentLoaded', function () {
    const messageForm = document.getElementById('message-form');
    const messageContainer = document.querySelector('.message-list');
    const conversationPartnerId = document.getElementById('receiver_id').value;

    // Function to load messages
    async function loadMessages() {
        const response = await fetch(`get_messages.php?conversation_partner_id=${conversationPartnerId}`);
        const messages = await response.json();

        messageContainer.innerHTML = ''; // Clear previous messages
        
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

        if (response.ok) {
            loadMessages(); // Reload messages to show the new message
            messageForm.reset(); // Clear the form
        }
    });

    // Initial load of messages
    loadMessages();
});
document.addEventListener('DOMContentLoaded', function() {
    const unreadCountElement = document.createElement('div');
    unreadCountElement.id = 'unread-count';
    unreadCountElement.style.color = 'red';
    unreadCountElement.style.fontWeight = 'bold';
    document.body.appendChild(unreadCountElement); // Add notification to the body, or place it in a desired location

    // Function to check for unread messages
    async function checkUnreadMessages() {
        const response = await fetch('check_unread_messages.php');
        const data = await response.json();

        if (data.status === 'success') {
            const unreadCount = data.unread_count;
            if (unreadCount > 0) {
                unreadCountElement.textContent = `You have ${unreadCount} new message(s)`;
            } else {
                unreadCountElement.textContent = '';
            }
        }
    }

    // Initial check and set interval to check every 10 seconds
    checkUnreadMessages();
    setInterval(checkUnreadMessages, 10000); // Check every 10 seconds
});
