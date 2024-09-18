@extends('layouts.app')

@section('content')
    <h1>Nova Tarefa</h1>
    <form action="{{ route('tasks.store') }}" method="POST">
    @csrf
        <div class="form-group">
            <label for="title">Título da Tarefa</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="description">Descrição</label>
            <textarea name="description" id="description" class="form-control"></textarea>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="0">Pendente</option>
                <option value="1">Concluída</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Criar Tarefa</button>
    </form> 
    <a href="{{ route('tasks.index') }}" class="btn btn-secondary mt-2">Voltar</a>
@endsection