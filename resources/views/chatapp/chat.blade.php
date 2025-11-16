@extends('chatapp.layouts.app')

@section('content')

<style>
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
        color: #dcddde;
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
        color: #b9bbbe;
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

    /* --- INCOMING MESSAGE LAYOUT FIX --- */
    .chat-box .chat.incoming {
        display: flex;         /* Elements ko ek line mein laayein */
        align-items: flex-end; /* Dono ko neeche se align karein */
    }

    .chat-box .chat.incoming .details {
        /* flex: 1;        */
        margin-left: 10px;    /* Profile pic aur bubble ke beech space */
    }

    /* --- YEH HAI ASLI FIX (SABKE LIYE) --- */
    /* Yeh rule pehle waale se zyaada specific hai aur dono par laagu hoga */
    .chat-box .chat .details .message-file img,
    .chat-box .chat .details .message-file video {
        max-width: 250px;   /* Max size 250px rakho */
        width: 100%;        /* Lekin container ke hisaab se chote bhi ho jao */
        border-radius: 10px;
        margin-bottom: 5px;
        height: auto;
        border: #333 1px solid;
        display: block;     
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
            
            <form action="#" class="typing-area" enctype="multipart/form-data">
                @csrf 
                <input type="text" class="incoming_id" name="incoming_id" value="{{ $chatUser->unique_id }}" hidden>
                
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

    console.log("Form Element:", form);
    console.log("Attach Button Element:", attachBtn);
    console.log("Emoji Button Element:", emojiBtn);

    if (!form || !attachBtn || !emojiBtn || !fileInput) {
        // console.error("CRITICAL ERROR: Ek ya zyaada elements nahi miley. HTML check karein.");
        return;
    }

    const incoming_id = form.querySelector(".incoming_id").value;
    let intervalId;

    // Form click handler removed
    // form.addEventListener('click', (e) => {
    //     console.log("Form clicked, target:", e.target);
    // });

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

    // Enhanced event listeners with focus support
    attachBtn.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopImmediatePropagation();
        // console.log("Attach button clicked with mouse!");
        // alert("Attach button clicked with mouse!");
        if (fileInput) fileInput.click();
    });

    attachBtn.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') { // Enter or Space for keyboard
            e.preventDefault();
            e.stopImmediatePropagation();
            // console.log("Attach button clicked with keyboard!");
            // alert("Attach button clicked with keyboard!");
            if (fileInput) fileInput.click();
        }
    });

    attachBtn.addEventListener('touchstart', (e) => {
        e.preventDefault();
        e.stopImmediatePropagation();
        // console.log("Attach button touched!");
        // alert("Attach button touched!");
        if (fileInput) fileInput.click();
    });

    attachBtn.addEventListener('touchend', (e) => {
        e.preventDefault();
        e.stopImmediatePropagation();
        // console.log("Attach button touch ended!");
        if (fileInput) fileInput.click();
    });

    emojiBtn.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopImmediatePropagation();
        // console.log("Emoji button clicked with mouse!");
        // alert("Emoji button clicked with mouse!");
        if (emojiPicker) {
            emojiPicker.style.display = (emojiPicker.style.display === 'none' || !emojiPicker.style.display) ? 'block' : 'none';
        }
    });

    emojiBtn.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') { // Enter or Space for keyboard
            e.preventDefault();
            e.stopImmediatePropagation();
            // console.log("Emoji button clicked with keyboard!");
            // alert("Emoji button clicked with keyboard!");
            if (emojiPicker) {
                emojiPicker.style.display = (emojiPicker.style.display === 'none' || !emojiPicker.style.display) ? 'block' : 'none';
            }
        }
    });

    emojiBtn.addEventListener('touchstart', (e) => {
        e.preventDefault();
        e.stopImmediatePropagation();
        // console.log("Emoji button touched!");
        // alert("Emoji button touched!");
        if (emojiPicker) {
            emojiPicker.style.display = (emojiPicker.style.display === 'none' || !emojiPicker.style.display) ? 'block' : 'none';
        }
    });

    emojiBtn.addEventListener('touchend', (e) => {
        e.preventDefault();
        e.stopImmediatePropagation();
        console.log("Emoji button touch ended!");
        if (emojiPicker) {
            emojiPicker.style.display = (emojiPicker.style.display === 'none' || !emojiPicker.style.display) ? 'block' : 'none';
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
                    chatBox.innerHTML = data;

                    if (!chatBox.classList.contains("active") || chatBox.scrollTop + chatBox.clientHeight >= oldScrollHeight - 20) {
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

    getChatHistory();
    inputField.focus();

    console.log("Chat script successfully finished loading!");
});
</script>

@endsection