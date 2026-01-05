<h1>Audit Logs Page</h1>
<p>Admin access only</p>

@foreach($logs as $log)
    <p>
        User: {{ $log->user_id }} |
        Action: {{ $log->action }} |
        IP: {{ $log->ip_address }} |
        Time: {{ $log->created_at }}
    </p>
@endforeach
