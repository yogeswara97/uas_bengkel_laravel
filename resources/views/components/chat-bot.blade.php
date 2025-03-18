<div>
    <!-- Chat Icon -->
    <div class="fixed bottom-5 right-5 w-15 h-15 p-4 bg-blue-500 rounded-full cursor-pointer flex items-center justify-center shadow-lg transition-all duration-300"
        onclick="toggleChat()">
        <i class="fa fa-comment fa-2x" aria-hidden="true"></i>
    </div>

    <!-- Chat Container -->
    <div
        class="chat-container fixed bottom-24 right-5 w-96 max-h-[80vh] z-1000 bg-white shadow-lg rounded-lg overflow-hidden transition-all duration-300 hidden">
        <!-- Chat Header -->
        <div class="bg-slate-900 text-white p-4">
            <h2 class="text-lg font-semibold">Abdi Jaya Chatbot</h2>
        </div>

        <!-- Chat Messages -->
        <div class="flex flex-col flex-grow p-4 overflow-y-auto h-[60vh]">
            <div id="chat-messages">

                <!-- Messages will be dynamically added here -->
            </div>

            <div id="loading"
                class="hidden flex items-center justify-center p-3 rounded-lg mb-2 bg-gray-200 text-black mr-auto max-w-3/4">
                <div class="animate-spin rounded-full h-5 w-5 border-t-2 border-slate-500"></div>
                <span class="ml-2">Loading...</span>
            </div>
        </div>

        <!-- Input Area -->
        <div class="input-container p-4 bg-white border-t border-gray-300 flex gap-2 ">
            <input id="chat-input" type="text" placeholder="Type your message..."
                class="flex-grow p-2 border border-gray-300 text-slate-900 rounded-lg outline-none"
                value="Summarize the data" />
            <button onclick="sendMessage()"
                class="p-2 bg-slate-500 text-white rounded-lg cursor-pointer hover:bg-slate-600">Send</button>
        </div>
    </div>

    <script>
        // Toggle chat visibility
        function toggleChat() {
            const chatContainer = document.querySelector('.chat-container');
            chatContainer.classList.toggle('hidden');
        }

        // Add a message to the chat
        function addMessage(sender, text) {
            const chatMessages = document.getElementById('chat-messages');
            const messageDiv = document.createElement('div');
            messageDiv.classList.add('message', 'p-3', 'mb-2');

            if (sender == 'user') {
                messageDiv.classList.add('bg-slate-500', 'text-white', 'rounded-s-xl', 'rounded-ee-xl', 'ml-auto',
                    'max-w-[80%]');
            } else {
                messageDiv.classList.add('bg-gray-200', 'text-slate-900', 'rounded-e-xl', 'rounded-es-xl', 'mr-auto',
                    'max-w-full')
            }
            messageDiv.textContent = text;
            chatMessages.appendChild(messageDiv);
        }

        // show & remove loading
        function showLoading() {
            document.getElementById('loading').classList.remove('hidden')
        }

        function hideLoading() {
            document.getElementById('loading').classList.add('hidden');
        }

        // Send user message and get bot response
        async function sendMessage() {
            const input = document.getElementById('chat-input');
            const loading = document.querySelector('.loading')
            const userMessage = input.value.trim();

            if (!userMessage) return;

            // Add user message to chat
            addMessage('user', userMessage);
            input.value = ''; // Clear input

            showLoading();

            try {
                // Send message to backend
                const response = await fetch('http://127.0.0.1:5000/generate_summary', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        prompt: userMessage
                    }),
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();
                addMessage('bot', data.response); // Add bot response to chat
            } catch (error) {
                console.error('Error:', error);
                addMessage('bot', `Error: ${error.message}`); // Show error message
            } finally {
                hideLoading()
                scrollToBottom()
            }
        }

        function scrollToBottom() {
            const chatMessages = document.getElementById('chat-messages');
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        // Allow pressing Enter to send message
        document.getElementById('chat-input').addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });

        document.addEventListener('click', (event) => {
            const chatContainer = document.querySelector('.chat-container');
            const chatIcon = document.querySelector(
                '.fixed.bottom-5.right-5.w-15.h-15.p-4.bg-slate-500.rounded-full.cursor-pointer.flex.items-center.justify-center.shadow-lg.transition-all.duration-300'
            );

            // Check if the click is outside the chat container and chat icon
            if (!chatContainer.contains(event.target) && !chatIcon.contains(event.target)) {
                chatContainer.classList.add('hidden');
            }
        });
    </script>
</div>
