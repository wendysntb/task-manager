<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        // Recupera o status do filtro, se existir
        $status = $request->get('status');

        // Verifica se há um filtro de status
        $tasksQuery = Task::with('categories');

        if ($status !== null) {
            $tasksQuery->where('status', $status);
        }

        // Verifica se existe cache para as tarefas filtradas
        $cacheKey = 'tasks_' . ($status !== null ? $status : 'all');
    
        $tasks = Cache::rememberForever($cacheKey, function () use ($tasksQuery) {
        return $tasksQuery->get();
    });

    return view('tasks.index', compact('tasks', 'status'));
    }

    protected function updateCache()
    {
        // Atualiza o cache para todas as tarefas
        $tasksAll = Task::with('categories')->get();
        Cache::put('tasks_all', $tasksAll, now()->addMinutes(10));

        $tasksPending = Task::with('categories')->where('status', 0)->get();
        Cache::put('tasks_0', $tasksPending, now()->addMinutes(10));

        $tasksCompleted = Task::with('categories')->where('status', 1)->get();
        Cache::put('tasks_1', $tasksCompleted, now()->addMinutes(10));
    }

    public function create()
    {
        $categories = Category::all();
        return view('tasks.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'status' => 'required|boolean',
        ]);

        Task::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'status' => $validatedData['status'], 
        ]);

        // Atualiza o cache
        $this->updateCache();

        return redirect()->route('tasks.index')->with('success', 'Tarefa criada com sucesso!');

    }

    public function edit(Task $task)
    {
        $categories = Category::all();
        return view('tasks.edit', compact('task', 'categories'));
    }

    public function update(Request $request, Task $task)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'status' => 'required|boolean',
            'categories' => 'nullable|string' // Recebe uma string com categorias separadas por vírgula
        ]);

        // Atualiza a tarefa
        $task->update([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'status' => $validatedData['status'],
        ]);

        // Processa as categorias
        $categoryNames = array_map('trim', explode(',', $validatedData['categories']));
        $categoryIds = [];

        foreach ($categoryNames as $categoryName) {
            // Cria a categoria se não existir
            $category = Category::firstOrCreate(['title' => $categoryName]);
            $categoryIds[] = $category->id;
        }
        // Associa as categorias à tarefa
        $task->categories()->sync($categoryIds);

       // Atualizar o cache
        $this->updateCache();

        return redirect()->route('tasks.index')->with('success', 'Tarefa atualizada com sucesso!');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        // Limpa os caches
        Cache::forget('tasks_all');
        Cache::forget('tasks_0'); 
        Cache::forget('tasks_1');

        return redirect()->route('tasks.index')->with('success', 'Tarefa excluída com sucesso!');
    }
}