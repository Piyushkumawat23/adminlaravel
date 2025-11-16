@extends('chatapp.layouts.app')

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
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
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
                @if(isset($chatUser))
                    <a href="{{ route('chatapp.users.list') }}" class="back-icon"><i class="fas fa-arrow-left"></i></a>
                    <img src="{{ asset('images/chatapp_profiles/'. $chatUser->img) }}" alt="">
                    <div class="details">
                        <span>{{ $chatUser->fname . " " . $chatUser->lname }}</span>
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

<script>
document.addEventListener("DOMContentLoaded", function () {
    console.log("Chat script started!");

    const form = document.querySelector(".typing-area");
    const chatBox = document.querySelector(".chat-box");
    const emojiPicker = document.querySelector("emoji-picker");
    const attachBtn = document.querySelector("#attach-btn");
    const fileInput = document.querySelector("#file-input");
    const emojiBtn = document.querySelector("#emoji-btn");
    const sendBtn = document.querySelector("#send-btn");
    const inputField = form.querySelector(".input-field");
    const csrfTokenEl = form.querySelector('input[name="_token"]');

    // === YEH NAYE JS VARIABLES HAIN ===
    const replyContextBox = document.getElementById('reply-context-box');
    const replyUserName = document.getElementById('reply-user-name');
    const replyMessagePreview = document.getElementById('reply-message-preview');
    const cancelReplyBtn = document.getElementById('cancel-reply-btn');
    const replyMessageIdInput = document.getElementById('reply_to_message_id');
    // === YAHAN TAK NAYE VARIABLES ===

    console.log("Form Element:", form);
    console.log("Attach Button Element:", attachBtn);
    console.log("Emoji Button Element:", emojiBtn);

    if (!form || !attachBtn || !emojiBtn || !fileInput) {
        // console.error("CRITICAL ERROR: Ek ya zyaada elements nahi miley. HTML check karein.");
        return;
    }

    const incoming_id = form.querySelector(".incoming_id").value;
    let intervalId;

    // ... (Aapka purana form, sendBtn, attachBtn, emojiBtn ka logic) ...
    form.onsubmit = (e) => {
        e.preventDefault();
        if (e.submitter === sendBtn) {
            sendMessage();
        }
    };
    sendBtn.addEventListener('click', (e) => {
        e.preventDefault();
        sendMessage();
    });
    // ... (Aapke saare button listeners) ...
    
    // YEH SAB AAPKA PURANA CODE HAI, ISSE CHHEDNA NAHI HAI
    attachBtn.addEventListener('click', (e) => { e.preventDefault(); e.stopImmediatePropagation(); if (fileInput) fileInput.click(); });
    attachBtn.addEventListener('keydown', (e) => { if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); e.stopImmediatePropagation(); if (fileInput) fileInput.click(); } });
    attachBtn.addEventListener('touchstart', (e) => { e.preventDefault(); e.stopImmediatePropagation(); if (fileInput) fileInput.click(); });
    attachBtn.addEventListener('touchend', (e) => { e.preventDefault(); e.stopImmediatePropagation(); if (fileInput) fileInput.click(); });
    emojiBtn.addEventListener('click', (e) => { e.preventDefault(); e.stopImmediatePropagation(); if (emojiPicker) { emojiPicker.style.display = (emojiPicker.style.display === 'none' || !emojiPicker.style.display) ? 'block' : 'none'; } });
    emojiBtn.addEventListener('keydown', (e) => { if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); e.stopImmediatePropagation(); if (emojiPicker) { emojiPicker.style.display = (emojiPicker.style.display === 'none' || !emojiPicker.style.display) ? 'block' : 'none'; } } });
    emojiBtn.addEventListener('touchstart', (e) => { e.preventDefault(); e.stopImmediatePropagation(); if (emojiPicker) { emojiPicker.style.display = (emojiPicker.style.display === 'none' || !emojiPicker.style.display) ? 'block' : 'none'; } });
    emojiBtn.addEventListener('touchend', (e) => { e.preventDefault(); e.stopImmediatePropagation(); console.log("Emoji button touch ended!"); if (emojiPicker) { emojiPicker.style.display = (emojiPicker.style.display === 'none' || !emojiPicker.style.display) ? 'block' : 'none'; } });
    if (emojiPicker) {
        emojiPicker.addEventListener('emoji-click', event => {
            inputField.value += event.detail.unicode;
            emojiPicker.style.display = 'none';
            inputField.focus();
            toggleSendButton();
        });
    }
    fileInput.onchange = () => {
        console.log("File selected:", fileInput.files);
        if (fileInput.files.length > 0) {
            inputField.placeholder = `Caption for ${fileInput.files[0].name}`;
            inputField.focus();
        }
        toggleSendButton();
    };
    inputField.onkeyup = () => { toggleSendButton(); };
    function toggleSendButton() {
        if (inputField.value.trim() !== "" || fileInput.files.length > 0) {
            sendBtn.classList.add("active");
        } else {
            sendBtn.classList.remove("active");
        }
    }
    toggleSendButton();
    // PURANA CODE YAHAN TAK

    function sendMessage() {
        if (inputField.value.trim() === "" && fileInput.files.length === 0) {
            return;
        }

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "{{ route('chatapp.chat.insert') }}", true);
        xhr.onload = () => {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    inputField.value = "";
                    fileInput.value = null;
                    inputField.placeholder = "Message...";
                    
                    // === YEH LINE ADD HUI HAI ===
                    hideReplyContext(); // Message bhejte hi reply box hide karein
                    // === YAHAN TAK ===
                    
                    toggleSendButton();
                    scrollToBottom();
                }
            }
        };

        xhr.setRequestHeader('X-CSRF-TOKEN', csrfTokenEl.value);
        xhr.setRequestHeader('Accept', 'application/json');

        let formData = new FormData(form);
        xhr.send(formData);
    }

    function getChatHistory() {
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "{{ route('chatapp.chat.get') }}", true);

        xhr.onload = () => {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    let data = xhr.response;
                    let oldScrollHeight = chatBox.scrollHeight;
                    // === YEH LINE MODIFIED HAI (Scroll check karne ke liye) ===
                    let isScrolledToBottom = chatBox.scrollTop + chatBox.clientHeight >= oldScrollHeight - 20;

                    chatBox.innerHTML = data;

                    if (!chatBox.classList.contains("active") || isScrolledToBottom) {
                        scrollToBottom();
                    }
                }
            }
        };
        xhr.setRequestHeader('X-CSRF-TOKEN', csrfTokenEl.value);
        xhr.setRequestHeader('Accept', 'text/html');
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("incoming_id=" + incoming_id);
    }

    chatBox.onmouseenter = () => { chatBox.classList.add("active"); };
    chatBox.onmouseleave = () => { chatBox.classList.remove("active"); };

    intervalId = setInterval(getChatHistory, 2000);

    function scrollToBottom() {
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    
    // === YEH NAYA JS CODE ADD HUA HAI (REPLY KE LIYE) ===
    
    // Chat box mein click hone par check karein ki reply button click hua hai
    chatBox.addEventListener('click', function(e) {
        // .reply-btn ya uske andar (jaise <i> tag) click hone par
        const replyBtn = e.target.closest('.reply-btn'); 
        
        if (replyBtn) {
            e.preventDefault();
            const messageId = replyBtn.dataset.messageId;
            const userName = replyBtn.dataset.userName;
            const messageContent = replyBtn.dataset.messageContent;
            
            // Reply box dikhaane wala function call karein
            showReplyContext(messageId, userName, messageContent);
        }
    });

    // Reply box dikhaane wala function
    function showReplyContext(messageId, userName, messageContent) {
        if (!replyContextBox || !replyUserName || !replyMessagePreview || !replyMessageIdInput) {
            console.error('Reply context elements not found');
            return;
        }
        replyUserName.textContent = userName;
        // Message ko thoda chota (truncate) karke dikhayein
        replyMessagePreview.textContent = messageContent.substring(0, 100) + (messageContent.length > 100 ? '...' : '');
        replyMessageIdInput.value = messageId;
        replyContextBox.style.display = 'block';
        inputField.focus(); // Input field par focus karein
    }

    // Reply box hide karne wala function
    function hideReplyContext() {
        if (!replyContextBox || !replyMessageIdInput) return;
        
        replyContextBox.style.display = 'none';
        replyMessageIdInput.value = ''; // Hidden input ko reset karein
    }

    // Cancel button par click listener
    if (cancelReplyBtn) {
        cancelReplyBtn.addEventListener('click', hideReplyContext);
    }
    
    // === YAHAN TAK NAYA JS CODE ===
    

    getChatHistory();
    inputField.focus();

    console.log("Chat script successfully finished loading!");
});
</script>

@endsection