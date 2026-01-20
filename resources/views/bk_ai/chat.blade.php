@extends('layouts.dashboard')

@section('title', 'BK AI - Chat')

@section('content')
<div class="pc-content">
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">BK AI Chat</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">BK AI - Asisten Pendampingan Bimbingan Konseling</h5>
                    <small class="text-muted">Tanyakan apapun kepada BK AI untuk mendapatkan saran dan bimbingan</small>
                </div>
                <div class="card-body">
                    <div id="chat-container" style="height: 500px; overflow-y: auto; border: 1px solid #e0e0e0; border-radius: 8px; padding: 20px; background: #f9f9f9; margin-bottom: 20px;">
                        <div class="chat-message ai-message">
                            <div class="message-content">
                                <p><strong>BK AI:</strong> Halo! Saya adalah BK AI, asisten pendampingan bimbingan konseling Anda. Saya siap membantu Anda dengan masalah akademik, emosional, dan pengembangan diri. Apa yang bisa saya bantu hari ini?</p>
                            </div>
                        </div>
                    </div>

                    <form id="chat-form">
                        @csrf
                        <div class="input-group">
                            <input type="text" id="chat-message" class="form-control" placeholder="Ketik pesan Anda di sini..." required>
                            <button class="btn btn-primary" type="submit"><i class="ti ti-send"></i> Kirim</button>
                        </div>
                    </form>

                    <div id="loading" style="display: none; margin-top: 10px;">
                        <div class="spinner-border spinner-border-sm" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <span class="ms-2">BK AI sedang memikirkan jawaban...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .chat-message {
        margin-bottom: 15px;
        padding: 10px 15px;
        border-radius: 8px;
        max-width: 80%;
    }

    .user-message {
        background: #1976d2;
        color: white;
        margin-left: auto;
        border-bottom-right-radius: 0;
    }

    .ai-message {
        background: #e0e0e0;
        color: #333;
        margin-right: auto;
        border-bottom-left-radius: 0;
    }

    .message-content {
        margin: 0;
        line-height: 1.5;
    }

    .message-content p {
        margin: 0;
    }

    #chat-container {
        display: flex;
        flex-direction: column;
    }
</style>

<script>
document.getElementById('chat-form').addEventListener('submit', function(e) {
    e.preventDefault();

    const message = document.getElementById('chat-message').value.trim();
    if (!message) return;

    // Tampilkan pesan user
    const chatContainer = document.getElementById('chat-container');
    const userMessageDiv = document.createElement('div');
    userMessageDiv.className = 'chat-message user-message';
    userMessageDiv.innerHTML = `<div class="message-content"><p><strong>Anda:</strong> ${message}</p></div>`;
    chatContainer.appendChild(userMessageDiv);

    // Clear input
    document.getElementById('chat-message').value = '';

    // Tampilkan loading
    document.getElementById('loading').style.display = 'block';

    // Send to server
    fetch('{{ route("bk_ai.chat") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ message: message })
    })
    .then(response => response.json())
    .then(data => {
        console.log('Chat response:', data);
        document.getElementById('loading').style.display = 'none';

        if (data.status === 'success') {
            const aiMessageDiv = document.createElement('div');
            aiMessageDiv.className = 'chat-message ai-message';
            aiMessageDiv.innerHTML = `<div class="message-content"><p><strong>BK AI:</strong> ${data.response}</p></div>`;
            chatContainer.appendChild(aiMessageDiv);
        } else {
            const errorMessageDiv = document.createElement('div');
            errorMessageDiv.className = 'chat-message ai-message';
            errorMessageDiv.innerHTML = `<div class="message-content"><p><strong>BK AI (Error):</strong> ${data.message}</p></div>`;
            chatContainer.appendChild(errorMessageDiv);
        }

        // Scroll to bottom
        chatContainer.scrollTop = chatContainer.scrollHeight;
    })
    .catch(error => {
        document.getElementById('loading').style.display = 'none';
        console.error('Fetch Error:', error);
        const errorMessageDiv = document.createElement('div');
        errorMessageDiv.className = 'chat-message ai-message';
        errorMessageDiv.innerHTML = `<div class="message-content"><p><strong>BK AI (Error):</strong> Terjadi kesalahan komunikasi. Silakan coba lagi.</p></div>`;
        chatContainer.appendChild(errorMessageDiv);
    });
});
</script>
@endsection
