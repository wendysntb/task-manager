@extends('layouts.app')

@section('content')

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <h3>Gerenciador de Tarefas</h3>
    <div class="d-flex justify-content-between">
        <div>
            <form method="GET" action="{{ route('tasks.index') }}" class="mb-4">
                <div class="form-group">
                    <label for="status">Filtrar:</label>
                    <select id="status" name="status" class="form-control" onchange="this.form.submit()">
                        <option value="">Tudo</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Pendente</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Concluída</option>
                    </select>
                </div>
            </form>
        </div>
        <div>
            <a href="{{ route('tasks.create') }}" class="btn btn-success mb-4">Criar Nova Tarefa</a>
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Título</th>
                <th>Descrição</th>
                <th>Status</th>
                <th>Categorias</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
                <tr>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->description }}</td>
                    <td>
                        {{ $task->status ? 'Concluída' : 'Pendente' }}
                    </td>
                    <td>
                        @foreach($task->categories as $category)
                            <span class="badge badge-secondary m-2">{{ $category->title }}</span>
                        @endforeach
                    </td>
                    <td>
                        <div class="d-flex flex-wrap m-2">
                            <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        </div>
                        <div class="d-flex flex-wrap m-2">
                            <form method="POST" action="{{ route('tasks.destroy', $task->id) }}" onsubmit="return confirm('Você tem certeza que quer excluir esta tarefa?')" 
                            style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Deletar</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table> 
@endsection