<h1>My Tasks</h1>

<a href="{{ route('tasks.create') }}">Create Task</a>

<hr>

@if($tasks->count() === 0)
    <p>No tasks yet.</p>
@endif

@foreach($tasks as $task)
    <p>
        <strong>{{ $task->title }}</strong><br>
        {{ $task->description }} <br>

        <a href="{{ route('tasks.edit', $task->id) }}">Edit</a>

        <form method="POST" action="{{ route('tasks.destroy', $task->id) }}" style="display:inline">
            @csrf
            @method('DELETE')
            <button type="submit">Delete</button>
        </form>
    </p>
    <hr>
@endforeach
