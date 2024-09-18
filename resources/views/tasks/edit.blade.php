@extends('layouts.app')

@section('content')
    <h1>Editar Tarefa</h1>
    <form action="{{ route('tasks.update', $task->id) }}" method="POST"onsubmit="return confirm('Você tem certeza que quer editar esta tarefa?')">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="title">Título da Tarefa</label>
        <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $task->title) }}" required>
    </div>

    <div class="form-group">
        <label for="description">Descrição</label>
        <textarea name="description" id="description" class="form-control">{{ old('description', $task->description) }}</textarea>
    </div>

    <div class="form-group">
        <label for="status">Status</label>
        <select name="status" id="status" class="form-control" required>
            <option value="0" {{ old('status', $task->status) === 0 ? 'selected' : '' }}>Pendente</option>
            <option value="1" {{ old('status', $task->status) === 1 ? 'selected' : '' }}>Concluída</option>
        </select>
    </div>

    <div class="form-group">
        <label for="categories">Categorias (separe por vírgula)</label>
        <input type="text" name="categories" id="categories" class="form-control" value="{{ old('categories', implode(', ', $task->categories->pluck('title')->toArray())) }}" placeholder="Digite categorias separadas por vírgula">
    </div>

    <button type="submit" class="btn btn-success">Atualizar Tarefa</button>
    </form>
    <a href="{{ route('tasks.index') }}" class="btn btn-secondary mt-2">Voltar</a>
@endsection