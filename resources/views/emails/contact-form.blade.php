<h2>New Contact Message Received</h2>

<p><strong>Name:</strong> {{ $data['name'] }}</p>
<p><strong>Email:</strong> {{ $data['email'] }}</p>
<p><strong>Phone:</strong> {{ $data['phone'] ?? 'N/A' }}</p>
<p><strong>Message:</strong><br>{{ $data['message'] }}</p>
