@extends('chatapp.layouts.app')

{{-- 1. YEH LINE HEAD TAG MEIN ADD KAREIN (agar pehle se nahi hai) --}}
@push('head')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@endpush

@section('content')
    <style>
        /* ================================
        BASIC INPUT + UI STYLING
    ================================ */
        .typing-area {
            display: flex;
            align-items: center;
            padding: 8px 12px;
            border-radius: 25px;
            margin: 5px 0;
            position: relative;
        }

        .typing-area .input-field {
            flex: 1;
            border: none;
            background: transparent;
            padding: 10px;
            font-size: 16px;
            outline: none;
            color: #798290;
            z-index: 1;
        }

        .typing-area .input-field::placeholder {
            color: #72767d;
        }

        .typing-area button {
            width: 40px;
            height: 40px;
            font-size: 20px;
            border: none;
            background: none;
            color: #798290;
            cursor: pointer;
            margin: 0 2px;
            position: relative;
            z-index: 1000;
            pointer-events: auto !important;
        }

        .typing-area button.active {
            color: #7289da;
        }

        #file-input {
            display: none;
        }

        emoji-picker {
            position: absolute;
            bottom: 65px;
            right: 5px;
            z-index: 100;
            display: none;
            width: 95%;
            max-width: 430px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .chat-box .doc-link a {
            display: inline-block;
            padding: 10px 15px;
            background: #f1f1f1;
            border-radius: 10px;
            text-decoration: none;
            color: #333;
            font-weight: 500;
        }

        .chat-box .doc-link a i {
            margin-right: 8px;
        }

        .chat-box .details p {
            word-wrap: break-word;
            margin: 0;
            max-width: 350px;
        }

        /* ================================
        CHAT STRUCTURE
    ================================ */
        /* Incoming bubble row */
        .chat-box .chat.incoming {
            display: flex;
            align-items: flex-end;
        }

        /* Incoming bubble gap */
        .chat-box .chat.incoming .details {
            margin-left: 10px;
        }

        /* Outgoing bubble row */
        .chat-box .chat.outgoing {
            display: flex;
            align-items: flex-end;
            justify-content: flex-end;
        }

        /* Images, videos inside chats */
        .chat-box .chat .details .message-file img,
        .chat-box .chat .details .message-file video {
            max-width: 250px;
            width: 100%;
            border-radius: 10px;
            margin-bottom: 5px;
            height: auto;
            border: #333 1px solid;
            display: block;
        }

        /* ================================
        REPLY CONTEXT BLOCK (Typing box)
    ================================ */
        .reply-context {
            background: #f1f1f1;
            padding: 8px 12px;
            margin: 0 5px 5px 5px;
            border-left: 4px solid #7289da;
            position: relative;
            border-radius: 8px;
        }

        .reply-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 13px;
        }

        .reply-header strong {
            color: #7289da;
        }

        .reply-header #cancel-reply-btn {
            border: none;
            background: none;
            font-size: 20px;
            font-weight: bold;
            color: #888;
            cursor: pointer;
            padding: 0 5px;
            line-height: 1;
        }

        .reply-message {
            font-size: 14px;
            color: #555;
            margin-top: 4px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100%;
        }

        /* ================================
        REPLY BUTTON ON EACH MESSAGE
    ================================ */
        .chat .reply-btn {
            background: transparent;
            border: none;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            line-height: 25px;
            text-align: center;
            cursor: pointer;
            color: #888;
            display: none;
            margin: 0 !important;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            flex-shrink: 0;
        }

        /* -------------------------------
        FINAL ACTUAL FIX:
        Incoming → RIGHT
        Outgoing → LEFT
    -------------------------------- */

        /* INCOMING MESSAGE → REPLY BUTTON RIGHT */
        .chat.incoming {
            position: relative;
        }

        .chat.incoming .reply-btn {
            right: -5px !important;
            left: auto !important;
        }

        /* OUTGOING MESSAGE → REPLY BUTTON LEFT */
        .chat.outgoing {
            position: relative;
        }

        .chat.outgoing .reply-btn {
            left: -5px !important;
            right: auto !important;
        }

        /* Hover par button show */
        .chat:hover .reply-btn {
            display: inline-block;
        }

        .chat .reply-btn:hover {
            color: #333;
        }

        /* Replied block inside bubble */
        .replied-message-block {
            background: rgba(0, 0, 0, 0.05);
            padding: 6px 10px;
            border-radius: 6px;
            margin-bottom: 5px;
            border-left: 3px solid #7289da;
            font-size: 14px;
            max-width: 300px;
        }

        .replied-message-block strong {
            color: #7289da;
            display: block;
            font-size: 13px;
        }

        .replied-message-block p {
            margin: 2px 0 0 0 !important;
            color: #666;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>


    <main class="main-content">
        <div class="wrapper" style="max-width: 450px; margin: 40px auto; position: relative;">
            <section class="chat-area">
                <header>
                    @if (isset($chatUser))
                        <a href="{{ route('chatapp.users.list') }}" class="back-icon"><i class="fas fa-arrow-left"></i></a>
                        <img src="{{ asset('images/chatapp_profiles/' . $chatUser->img) }}" alt="">
                        <div class="details">
                            <span>{{ $chatUser->fname . ' ' . $chatUser->lname }}</span>
                            <p>{{ $chatUser->status }}</p>
                        </div>
                    @endif
                </header>

                <div class="chat-box"></div>

                <div class="reply-context" id="reply-context-box" style="display: none;">
                    <div class="reply-header">
                        <strong>Replying to <span id="reply-user-name"></span></strong>
                        <button type="button" id="cancel-reply-btn">&times;</button>
                    </div>
                    <div class="reply-message" id="reply-message-preview">
                        ...
                    </div>
                </div>
                <form action="#" class="typing-area" enctype="multipart/form-data">
                    @csrf
                    <input type="text" class="incoming_id" name="incoming_id" value="{{ $chatUser->unique_id }}" hidden>

                    <input type="hidden" name="reply_to_message_id" id="reply_to_message_id" value="">
                    <button type="button" id="emoji-btn"><i class="fas fa-smile"></i></button>
                    <input type="file" id="file-input" name="file_upload">
                    <input type="text" name="message" class="input-field" placeholder="Message..." autocomplete="off">
                    <button type="button" id="attach-btn"><i class="fas fa-paperclip"></i></button>
                    <button type="submit" id="send-btn" class="active"><i class="fab fa-telegram-plane"></i></button>
                </form>
            </section>

            <emoji-picker></emoji-picker>
        </div>
    </main>

    {{-- YEH SCRIPT SECTION AAPKE BLADE FILE MEIN SABSE NEECHE AAYEGA --}}
    {{-- 2. YEH PURA SCRIPT BLOCK AAPKE PURANE SCRIPT BLOCK KO REPLACE KAREGA --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            console.log("WebSocket Chat script started!");

            // === 1. Saare Elements ===
            const form = document.querySelector(".typing-area");

            // === YEH HAI NAYA FIX (GUARD CLAUSE) ===
            // Agar .typing-area is page par nahi hai (matlab hum chat page par nahi hain),
            // toh script ko yahin rok dein.
            if (!form) {
                console.log("Not on the chat page. Stopping chat script.");
                return; // <-- Script ko yahin rok do
            }
            // === FIX KHATAM ===

            // Ab jab humein pata hai ki hum chat page par hain,
            // hum baki saare elements ko select kar sakte hain.
            const chatBox = document.querySelector(".chat-box");
            const emojiPicker = document.querySelector("emoji-picker");
            const attachBtn = document.querySelector("#attach-btn");
            const fileInput = document.querySelector("#file-input");
            const emojiBtn = document.querySelector("#emoji-btn");
            const sendBtn = document.querySelector("#send-btn");
            const inputField = form.querySelector(".input-field");
            const csrfTokenEl = form.querySelector('input[name="_token"]');

            // Reply Box Elements
            const replyContextBox = document.getElementById('reply-context-box');
            const replyUserName = document.getElementById('reply-user-name');
            const replyMessagePreview = document.getElementById('reply-message-preview');
            const cancelReplyBtn = document.getElementById('cancel-reply-btn');
            const replyMessageIdInput = document.getElementById('reply_to_message_id');

            // Chat ke liye IDs
            const incoming_id = form.querySelector(".incoming_id").value;
            const my_unique_id = "{{ session('unique_id') }}"; // Hamara khud ka ID

            // Asset base URL (images/files ke liye)
            const asset_base_url = "{{ asset('') }}";
            const chatapp_profile_url = `${asset_base_url}images/chatapp_profiles/`;

            // === 2. Saare Button Listeners (Aapka purana code) ===
            form.onsubmit = (e) => {
                e.preventDefault();
                sendMessage();
            };
            sendBtn.addEventListener('click', (e) => {
                e.preventDefault();
                sendMessage();
            });
            attachBtn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopImmediatePropagation();
                if (fileInput) fileInput.click();
            });
            emojiBtn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopImmediatePropagation();
                if (emojiPicker) {
                    emojiPicker.style.display = (emojiPicker.style.display === 'none' || !emojiPicker.style
                        .display) ? 'block' : 'none';
                }
            });
            if (emojiPicker) {
                emojiPicker.addEventListener('emoji-click', event => {
                    inputField.value += event.detail.unicode;
                    emojiPicker.style.display = 'none';
                    inputField.focus();
                    toggleSendButton();
                });
            }
            fileInput.onchange = () => {
                if (fileInput.files.length > 0) {
                    inputField.placeholder = `Caption for ${fileInput.files[0].name}`;
                    inputField.focus();
                }
                toggleSendButton();
            };
            inputField.onkeyup = () => {
                toggleSendButton();
            };

            function toggleSendButton() {
                if (!sendBtn) return; // Guard clause agar sendBtn na mile
                if (inputField.value.trim() !== "" || (fileInput && fileInput.files.length > 0)) {
                    sendBtn.classList.add("active");
                } else {
                    sendBtn.classList.remove("active");
                }
            }
            toggleSendButton(); // Page load par check karein

            // === 3. Naya Message Bhejne wala Function (AJAX) ===
            function sendMessage() {
                if (inputField.value.trim() === "" && fileInput.files.length === 0) {
                    return;
                }

                let xhr = new XMLHttpRequest();
                xhr.open("POST", "{{ route('chatapp.chat.insert') }}", true);
                xhr.onload = () => {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            try {
                                let response = JSON.parse(xhr.response);

                                if (response.status === 'success') {
                                    // ** BADLAAV: Ab hum message ko backend se lete hain **
                                    // Yeh hamara khud ka bheja gaya message hai
                                    appendMessageToChatbox(response.message);

                                    // Form reset karein
                                    inputField.value = "";
                                    fileInput.value = null; // File input ko reset karein
                                    inputField.placeholder = "Message...";
                                    hideReplyContext();
                                    toggleSendButton();
                                    scrollToBottom();
                                } else {
                                    alert(response.message || "Error sending message.");
                                }
                            } catch (e) {
                                console.error("Error parsing response:", xhr.response);
                            }
                        } else {
                            console.error("Error sending message:", xhr.statusText);
                            alert("Message could not be sent. Status: " + xhr.status);
                        }
                    }
                };

                xhr.setRequestHeader('X-CSRF-TOKEN', csrfTokenEl.value);
                xhr.setRequestHeader('Accept', 'application/json');

                let formData = new FormData(form);
                xhr.send(formData);
            }

            // === 4. Purani Chat History paane wala Function (Sirf 1 baar chalta hai) ===
            function getChatHistory() {
                let xhr = new XMLHttpRequest();
                xhr.open("POST", "{{ route('chatapp.chat.get') }}", true);

                xhr.onload = () => {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            try {
                                // ** BADLAAV: Ab hum HTML nahi, JSON parse kar rahe hain **
                                let messages = JSON.parse(xhr.response);

                                if (messages.length === 0) {
                                    chatBox.innerHTML =
                                        '<div class="text">No messages are available. Once you send message they will appear here.</div>';
                                } else {
                                    chatBox.innerHTML = ""; // Chat box ko khaali karein
                                    // Har message ko HTML mein badlein
                                    messages.forEach(message => {
                                        appendMessageToChatbox(message);
                                    });
                                }
                                scrollToBottom();

                                // *** SABSE ZAROORI: History load hone ke baad hi sunna shuru karein ***
                                listenForNewMessages();

                            } catch (e) {
                                console.error("Error parsing chat history:", xhr.response);
                                chatBox.innerHTML = '<div class="text">Error loading chat history.</div>';
                            }
                        }
                    }
                };
                xhr.setRequestHeader('X-CSRF-TOKEN', csrfTokenEl.value);
                xhr.setRequestHeader('Accept', 'application/json'); // <-- Hum JSON maang rahe hain
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send("incoming_id=" + incoming_id);
            }

            // === 5. NAYA WEBSOCKET LISTENER FUNCTION ===
            // === 5. NAYA WEBSOCKET LISTENER FUNCTION (FIXED) ===
            function listenForNewMessages() {
                // Check agar Echo loaded hai
                if (typeof window.Echo === 'undefined') {
                    console.error('Laravel Echo not configured.');
                    return;
                }

                console.log("Listening on channel: chat." + my_unique_id);

                // *** YAHAN FIX KIYA GAYA HAI ***
                // 'NewChatMessage' hata kar '.message.new' lagaya gaya hai
                // Kyunki Event file mein broadcastAs() 'message.new' return kar raha hai.
                // Dot (.) lagana zaroori hai jab broadcastAs use karte hain.
                
                window.Echo.private('chat.' + my_unique_id)
                    .listen('.message.new', (e) => {
                        
                        console.log("New message received via WebSocket:", e.message);

                        // UI update karein
                        appendMessageToChatbox(e.message);
                        scrollToBottom();
                    });
            }

            // === 6. NAYA HTML RENDER KARNE WALA FUNCTION ===
            // Yeh function JSON message object ko HTML mein badalta hai
            function appendMessageToChatbox(message) {

                // "No messages" text hata dein agar maujood hai
                const noMsgDiv = chatBox.querySelector('.text');
                if (noMsgDiv) noMsgDiv.remove();

                let output = "";
                let chatClass = (message.outgoing_msg_id == my_unique_id) ? "outgoing" : "incoming";

                // Sender ki image (sirf incoming par)
                let senderImg = "";
                if (chatClass === 'incoming') {
                    // Agar 'sender' object hai (Lazy loading se)
                    let imgSrc = message.img || (message.sender ? message.sender.img : 'default.png');
                    senderImg = `<img src="${chatapp_profile_url}${imgSrc}" alt="">`;
                }

                // Sender ka naam (Reply ke liye)
                let senderName = (chatClass === 'outgoing') ? 'You' : (message.fname || (message.sender ? message
                    .sender.fname : 'Someone'));

                // Reply Block HTML
                let replyBlock = "";
                if (message.reply_to_message_id) {
                    let parent_name = "Deleted Message";
                    let parent_text = "This message was deleted.";

                    // Check karein ki parent message ki details hain (History load se)
                    if (message.parent_sender_id) {
                        parent_name = (message.parent_sender_id == my_unique_id) ? "You" : (message
                            .parent_user_fname || 'Someone');
                        parent_text = message.parent_message_text || (message.parent_file_path ? 'File' : '...');
                    }
                    // Agar message abhi-abhi aaya hai (via WebSocket), 'replied_to' object hoga
                    else if (message.replied_to) {
                        parent_name = (message.replied_to.outgoing_msg_id == my_unique_id) ? "You" : (message
                            .replied_to.sender ? message.replied_to.sender.fname : 'Someone');
                        parent_text = message.replied_to.msg || (message.replied_to.file_path ? 'File' : '...');
                    }

                    replyBlock = `<div class="replied-message-block">
                              <strong>${parent_name}</strong>
                              <p>${parent_text.substring(0, 50)}...</p>
                          </div>`;
                }

                // Message Content HTML (File, Image, Text)
                let messageContent = "";
                let caption = message.msg ? `<p>${message.msg}</p>` : '';
                let fileUrl = message.file_path ? `${asset_base_url}${message.file_path}` : null;

                if (message.msg_type == 'image' && fileUrl) {
                    messageContent = `<div class="message-file"><img src="${fileUrl}" alt="Image"></div>${caption}`;
                } else if (message.msg_type == 'video' && fileUrl) {
                    messageContent =
                        `<div class="message-file"><video controls><source src="${fileUrl}"></video></div>${caption}`;
                } else if (message.msg_type == 'text') {
                    messageContent = `<p>${message.msg}</p>`;
                } else if (fileUrl) {
                    // Document logic
                    let fileIcon = 'fas fa-file'; // Default icon
                    let ext = message.msg_type;
                    if (['pdf'].includes(ext)) fileIcon = 'fas fa-file-pdf';
                    if (['doc', 'docx'].includes(ext)) fileIcon = 'fas fa-file-word';
                    if (['zip', 'rar'].includes(ext)) fileIcon = 'fas fa-file-archive';

                    messageContent =
                        `<div class="message-file doc-link"><a href="${fileUrl}" target="_blank"><i class="${fileIcon}"></i> ${caption || 'View File'}</a></div>`;
                } else {
                    messageContent = caption;
                }

                // Reply Button Data
                let reply_content = message.msg || 'File';

                // Final HTML
                if (chatClass == "outgoing") {
                    output = `<div class="chat outgoing">
                          <button class="reply-btn" data-message-id="${message.msg_id}" data-user-name="${senderName}" data-message-content="${reply_content}">
                              <i class="fas fa-reply"></i>
                          </button>
                          <div class="details">${replyBlock}${messageContent}</div>
                      </div>`;
                } else {
                    output = `<div class="chat incoming">
                          ${senderImg}
                          <div class="details">${replyBlock}${messageContent}</div>
                          <button class="reply-btn" data-message-id="${message.msg_id}" data-user-name="${senderName}" data-message-content="${reply_content}">
                              <i class="fas fa-reply"></i>
                          </button>
                      </div>`;
                }

                chatBox.insertAdjacentHTML("beforeend", output);
            }

            // === 7. Reply Logic (Aapka purana code, koi badlaav nahi) ===
            chatBox.addEventListener('click', function(e) {
                const replyBtn = e.target.closest('.reply-btn');
                if (replyBtn) {
                    e.preventDefault();
                    const messageId = replyBtn.dataset.messageId;
                    const userName = replyBtn.dataset.userName;
                    const messageContent = replyBtn.dataset.messageContent;
                    showReplyContext(messageId, userName, messageContent);
                }
            });

            function showReplyContext(messageId, userName, messageContent) {
                if (!replyContextBox || !replyUserName || !replyMessagePreview || !replyMessageIdInput) {
                    console.error('Reply context elements not found');
                    return;
                }
                replyUserName.textContent = userName;
                replyMessagePreview.textContent = messageContent.substring(0, 100) + (messageContent.length > 100 ?
                    '...' : '');
                replyMessageIdInput.value = messageId;
                replyContextBox.style.display = 'block';
                inputField.focus();
            }

            function hideReplyContext() {
                if (!replyContextBox || !replyMessageIdInput) return;
                replyContextBox.style.display = 'none';
                replyMessageIdInput.value = '';
            }
            if (cancelReplyBtn) {
                cancelReplyBtn.addEventListener('click', hideReplyContext);
            }

            // === 8. Utility Functions (Aapka purana code, koi badlaav nahi) ===
            chatBox.onmouseenter = () => {
                chatBox.classList.add("active");
            };
            chatBox.onmouseleave = () => {
                chatBox.classList.remove("active");
            };

            function scrollToBottom() {
                chatBox.scrollTop = chatBox.scrollHeight;
            }

            // === 9. CHAT START KAREIN ===
            // (setInterval ko hata diya gaya hai)
            getChatHistory(); // 1. Pehle purani history load karein
            // 2. History load hone ke baad, 'listenForNewMessages()' apne aap chalu ho jaayega
            inputField.focus();
        });
    </script>
@endsection
