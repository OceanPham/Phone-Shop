<!-- Chatbot Popup Component -->
<div id="chatbot-container" class="fixed bottom-4 right-4 z-50">
    <!-- Chat Button -->
    <button id="chatbot-toggle" class="bg-blue-600 hover:bg-blue-700 text-white rounded-full p-4 shadow-lg transition-all duration-300 transform hover:scale-110">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
        </svg>
    </button>

    <!-- Chat Window -->
    <div id="chatbot-window" class="hidden absolute bottom-16 right-0 w-96 h-[500px] bg-white rounded-lg shadow-2xl border border-gray-200 flex flex-col">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-4 rounded-t-lg flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                    <img src="{{ asset('icons/chatbot.png') }}" alt="AI Assistant" class="w-10 h-10 rounded-full">
                </div>
                <div>
                    <h3 class="font-semibold text-lg">AI Assistant</h3>
                    <p class="text-blue-100 text-sm">Hỏi đáp về sản phẩm</p>
                </div>
            </div>
            <button id="chatbot-close" class="text-white hover:text-blue-200 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Messages Container -->
        <div id="chatbot-messages" class="flex-1 p-4 overflow-y-auto space-y-4">
            <!-- Welcome Message -->
            <div class="flex items-start space-x-3">
                <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                    </svg>
                </div>
                <div class="bg-blue-50 rounded-lg p-3 max-w-xs">
                    <p class="text-gray-800 text-sm">
                        👋 Xin chào! Tôi là AI Assistant của The Phone Store. Tôi có thể giúp bạn:
                    </p>
                    <ul class="text-gray-600 text-xs mt-2 space-y-1">
                        <li>• Tìm kiếm sản phẩm phù hợp</li>
                        <li>• So sánh thông số kỹ thuật</li>
                        <li>• Tư vấn mua hàng</li>
                        <li>• Hỗ trợ khác</li>
                    </ul>
                    <p class="text-gray-800 text-sm mt-2">
                        Hãy hỏi tôi bất cứ điều gì về sản phẩm nhé! 😊
                    </p>
                </div>
            </div>
        </div>

        <!-- Input Area -->
        <div class="border-t border-gray-200 p-4">
            <form id="chatbot-form" class="flex space-x-2">
                <input
                    type="text"
                    id="chatbot-input"
                    placeholder="Nhập câu hỏi của bạn..."
                    class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                    autocomplete="off">
                <button
                    type="submit"
                    id="chatbot-send"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center space-x-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                </button>
            </form>
        </div>

        <!-- Loading Indicator -->
        <div id="chatbot-loading" class="hidden p-4">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                    </svg>
                </div>
                <div class="bg-blue-50 rounded-lg p-3">
                    <div class="flex space-x-1">
                        <div class="w-2 h-2 bg-blue-600 rounded-full animate-bounce"></div>
                        <div class="w-2 h-2 bg-blue-600 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                        <div class="w-2 h-2 bg-blue-600 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Style cho nội dung assistant (bullet/heading/code đẹp) -->
<style>
  #chatbot-window .ai-rich p { margin: 0.25rem 0; }
  #chatbot-window .ai-rich ul {
    list-style: disc;
    padding-left: 1.25rem;
    margin: 0.25rem 0;
  }
  #chatbot-window .ai-rich ol {
    list-style: decimal;
    padding-left: 1.25rem;
    margin: 0.25rem 0;
  }
  #chatbot-window .ai-rich li { margin: 0.125rem 0; }
  #chatbot-window .ai-rich a { color: #2563eb; text-decoration: underline; }
  #chatbot-window .ai-rich code {
    background: #f3f4f6;
    padding: 0.1rem 0.25rem;
    border-radius: 0.25rem;
  }
</style>

<!-- DOMPurify (sanitize HTML) -->
<script src="https://cdn.jsdelivr.net/npm/dompurify@3/dist/purify.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatbotToggle   = document.getElementById('chatbot-toggle');
    const chatbotWindow   = document.getElementById('chatbot-window');
    const chatbotClose    = document.getElementById('chatbot-close');
    const chatbotForm     = document.getElementById('chatbot-form');
    const chatbotInput    = document.getElementById('chatbot-input');
    const chatbotMessages = document.getElementById('chatbot-messages');
    const chatbotLoading  = document.getElementById('chatbot-loading');

    let sessionId = generateSessionId();

    function generateSessionId() {
        return 'session_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
    }

    // Sanitize bằng DOMPurify
    function sanitizeHtml(html) {
        if (!html) return '';
        if (window.DOMPurify) {
            return DOMPurify.sanitize(html, {
                ALLOWED_TAGS: [
                    'p','div','span','br','strong','b','em','i','u','ol','ul','li',
                    'h1','h2','h3','h4','h5','h6','table','thead','tbody','tr','th','td',
                    'a','code','pre','blockquote','hr','img'
                ],
                ALLOWED_ATTR: ['href','title','target','rel','class','style','src','alt']
            });
        }
        return html
            .replace(/<script[\s\S]*?>[\s\S]*?<\/script>/gi, '')
            .replace(/\son\w+="[^"]*"/gi, '')
            .replace(/\son\w+='[^']*'/gi, '')
            .replace(/javascript:/gi, '');
    }

    // Xóa code fence ```html và ``` (kể cả khi bị tách chunk)
    function stripCodeFence(s) {
        if (!s) return '';
        return s
            .replace(/```(?:\s*html)?/gi, '')
            .replace(/```/g, '')
            .replace(/``/g, '');
    }

    // Toggle window
    chatbotToggle.addEventListener('click', function() {
        chatbotWindow.classList.toggle('hidden');
        if (!chatbotWindow.classList.contains('hidden')) {
            chatbotInput.focus();
        }
    });

    // Close
    chatbotClose.addEventListener('click', function() {
        chatbotWindow.classList.add('hidden');
    });

    // Submit
    chatbotForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const question = chatbotInput.value.trim();
        if (!question) return;

        addMessage(question, 'user');
        chatbotInput.value = '';
        showLoading();

        // Stream!
        sendToAIAssistantStream(question);
    });

    // Add message bubble (trả về element để cập nhật innerHTML khi stream)
    function addMessage(content, sender) {
        const wrapper = document.createElement('div');
        wrapper.className = 'flex items-start space-x-3';

        if (sender === 'user') {
            wrapper.innerHTML = `
                <div class="flex-1"></div>
                <div class="bg-blue-600 text-white rounded-lg p-3 max-w-xs">
                    <p class="text-sm">${escapeHtml(content)}</p>
                </div>
                <div class="w-8 h-8 bg-gray-400 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
            `;
            chatbotMessages.appendChild(wrapper);
            scrollToBottom();
            return null;
        } else {
            wrapper.innerHTML = `
                <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                    </svg>
                </div>
                <div class="bg-gray-100 rounded-lg p-3 max-w-xs">
                    <div class="text-sm text-gray-800 ai-rich"></div>
                </div>
            `;
            const contentDiv = wrapper.querySelector('.text-sm.text-gray-800.ai-rich');
            contentDiv.innerHTML = ''; // sẽ set innerHTML khi stream
            chatbotMessages.appendChild(wrapper);
            scrollToBottom();
            return contentDiv;
        }
    }

    function showLoading() { chatbotLoading.classList.remove('hidden'); scrollToBottom(); }
    function hideLoading() { chatbotLoading.classList.add('hidden'); }

    // STREAM via fetch (POST) -> đọc SSE và render HTML
    async function sendToAIAssistantStream(question) {
        const url = '{{ route("chatbot.stream") }}';
        const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const assistantContentEl = addMessage('', 'assistant');
        let accumulated = '';
        let rafScheduled = false;

        // Hàm update DOM (throttle bằng rAF để mượt)
        function flushRender() {
            rafScheduled = false;
            const cleaned = stripCodeFence(accumulated);
            const safeHtml = sanitizeHtml(cleaned);
            if (assistantContentEl) assistantContentEl.innerHTML = safeHtml;
            scrollToBottom();
        }

        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'text/event-stream'
                },
                body: JSON.stringify({ session_id: sessionId, question })
            });

            if (!response.ok || !response.body) {
                hideLoading();
                if (assistantContentEl) assistantContentEl.textContent = 'Xin lỗi, không thể kết nối luồng phản hồi.';
                return;
            }

            const reader = response.body.getReader();
            const decoder = new TextDecoder('utf-8');
            let buffer = '';

            hideLoading();

            while (true) {
                const { value, done } = await reader.read();
                if (done) break;
                buffer += decoder.decode(value, { stream: true });

                let sepIndex;
                while ((sepIndex = buffer.indexOf('\n\n')) !== -1) {
                    const rawEvent = buffer.slice(0, sepIndex);
                    buffer = buffer.slice(sepIndex + 2);

                    const lines = rawEvent.split('\n').filter(l => l.startsWith('data: '));
                    for (const line of lines) {
                        const payload = line.replace(/^data:\s*/, '');
                        if (!payload) continue;

                        let evt; try { evt = JSON.parse(payload); } catch { continue; }

                        if (evt.type === 'meta') continue;

                        if (evt.type === 'chunk') {
                            const piece = evt.text || '';
                            // Gộp, xoá code-fence khi render (để không nhảy chữ ``` giữa chừng)
                            accumulated += piece;

                            // throttle render
                            if (!rafScheduled) {
                                rafScheduled = true;
                                requestAnimationFrame(flushRender);
                            }
                            continue;
                        }

                        if (evt.type === 'error') {
                            if (assistantContentEl) {
                                const html = sanitizeHtml(stripCodeFence(accumulated + '\n[Lỗi] ' + (evt.message || 'Không xác định')));
                                assistantContentEl.innerHTML = html;
                            }
                            continue;
                        }

                        if (evt.type === 'done') {
                            // Render lần cuối cho chắc
                            flushRender();
                            return;
                        }
                    }
                }
            }
        } catch (err) {
            console.error('Chatbot stream error:', err);
            hideLoading();
            if (assistantContentEl) assistantContentEl.textContent = 'Xin lỗi, có lỗi xảy ra khi kết nối luồng.';
        }
    }

    function scrollToBottom() {
        setTimeout(() => {
            chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
        }, 30);
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Enter
    chatbotInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            chatbotForm.dispatchEvent(new Event('submit'));
        }
    });

    chatbotToggle.addEventListener('click', function() {
        setTimeout(() => chatbotInput.focus(), 100);
    });
});
</script>
