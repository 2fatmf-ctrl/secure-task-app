<h1>Create Task</h1>

<form method="POST" action="{{ route('tasks.store') }}">
    @csrf

    <input type="text" name="title" placeholder="Task title" required>
    <br><br>

    <textarea name="description" placeholder="Description"></textarea>
    <br><br>

    <button type="submit">Create</button>
</form>

<a href="{{ route('tasks.index') }}">Back to tasks</a>
