<h1>New message from your portfolio!</h1>

<br>

<p><strong>Sender name:</strong> {{ $data['sender_name'] }}</p>
<p><strong>Sender email:</strong> {{ $data['sender_email'] }}</p>
<p><strong>Subject:</strong> {{ $data['subject'] }}</p>

<hr>

<h3>Message:</h3>
<div style="white-space: pre-wrap; font-family: sans-serif;">
    {{ $data['content'] }}
</div>
