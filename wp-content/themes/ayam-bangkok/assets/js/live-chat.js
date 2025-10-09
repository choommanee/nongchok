/**
 * Live Chat Widget - Wix Style
 */

(function($) {
    'use strict';

    $(document).ready(function() {
        const chatToggle = $('.chat-toggle');
        const chatWindow = $('.chat-window');
        const chatClose = $('.chat-close');
        const chatMessages = $('.chat-messages');
        const messageInput = $('#chat-message-input');
        const sendButton = $('#send-message');

        // Initialize chat with welcome message
        function initChat() {
            const welcomeHTML = `
                <div class="welcome-message">
                    <h4>สวัสดีครับ! 👋</h4>
                    <p>ยินดีต้อนรับสู่หนองจอก เอฟซีไอ<br>มีอะไรให้ช่วยไหมครับ?</p>
                </div>
            `;
            chatMessages.html(welcomeHTML);
        }

        // Toggle chat window
        chatToggle.on('click', function() {
            if (chatWindow.is(':visible')) {
                chatWindow.removeClass('show').fadeOut(200);
            } else {
                chatWindow.addClass('show').fadeIn(200);
                messageInput.focus();

                // Remove notification badge
                chatToggle.removeClass('has-notification');

                // Add pulse effect on first open
                if (chatMessages.children().length === 0) {
                    initChat();
                }
            }
        });

        // Close chat window
        chatClose.on('click', function() {
            chatWindow.removeClass('show').fadeOut(200);
        });

        // Add pulse effect after page load
        setTimeout(function() {
            chatToggle.addClass('pulse');

            // Remove pulse after 5 seconds
            setTimeout(function() {
                chatToggle.removeClass('pulse');
            }, 5000);
        }, 2000);

        // Send message on button click
        sendButton.on('click', function() {
            sendMessage();
        });

        // Send message on Enter key
        messageInput.on('keypress', function(e) {
            if (e.which === 13 && !e.shiftKey) {
                e.preventDefault();
                sendMessage();
            }
        });

        // Send message function
        function sendMessage() {
            const message = messageInput.val().trim();

            if (message === '') {
                return;
            }

            // Disable input while sending
            messageInput.prop('disabled', true);
            sendButton.prop('disabled', true);

            // Add user message to chat
            addMessage(message, 'user');

            // Clear input
            messageInput.val('');

            // Show typing indicator
            showTypingIndicator();

            // Send AJAX request
            $.ajax({
                url: ayam_chat_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'send_chat_message',
                    nonce: ayam_chat_ajax.nonce,
                    message: message,
                    user_id: ayam_chat_ajax.user_id,
                    user_name: ayam_chat_ajax.user_name
                },
                success: function(response) {
                    // Remove typing indicator
                    removeTypingIndicator();

                    if (response.success) {
                        // Add bot response
                        setTimeout(function() {
                            addMessage(response.data.reply, 'bot');
                        }, 500);
                    } else {
                        addMessage('ขออภัยครับ เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง', 'bot');
                    }

                    // Re-enable input
                    messageInput.prop('disabled', false);
                    sendButton.prop('disabled', false);
                    messageInput.focus();
                },
                error: function() {
                    removeTypingIndicator();
                    addMessage('ไม่สามารถเชื่อมต่อได้ กรุณาลองใหม่อีกครั้ง', 'bot');
                    messageInput.prop('disabled', false);
                    sendButton.prop('disabled', false);
                }
            });
        }

        // Add message to chat
        function addMessage(message, type) {
            const time = getCurrentTime();
            const messageHTML = `
                <div class="chat-message ${type}">
                    <div class="message-bubble">
                        ${escapeHtml(message)}
                    </div>
                </div>
            `;

            // Remove welcome message if exists
            $('.welcome-message').remove();

            chatMessages.append(messageHTML);
            scrollToBottom();
        }

        // Show typing indicator
        function showTypingIndicator() {
            const typingHTML = `
                <div class="chat-message bot typing-message">
                    <div class="typing-indicator">
                        <div class="typing-dot"></div>
                        <div class="typing-dot"></div>
                        <div class="typing-dot"></div>
                    </div>
                </div>
            `;
            chatMessages.append(typingHTML);
            scrollToBottom();
        }

        // Remove typing indicator
        function removeTypingIndicator() {
            $('.typing-message').remove();
        }

        // Scroll to bottom of chat
        function scrollToBottom() {
            chatMessages.animate({
                scrollTop: chatMessages[0].scrollHeight
            }, 300);
        }

        // Get current time
        function getCurrentTime() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            return `${hours}:${minutes}`;
        }

        // Escape HTML
        function escapeHtml(text) {
            const map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return text.replace(/[&<>"']/g, function(m) { return map[m]; });
        }

        // Initialize chat
        initChat();
    });

})(jQuery);
