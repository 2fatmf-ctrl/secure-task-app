<h1>Edit Task</h1>

<form method="POST" action="{{ route('tasks.update', $task->id) }}">
    @csrf
    @method('PUT')

    <input type="text" name="title" value="{{ $task->title }}" required>
    <br><br>

    <textarea name="description">{{ $task->description }}</textarea>
    <br><br>

    <button type="submit">Update</button>
</form>

<a href="{{ route('tasks.index') }}">Back to tasks</a>
