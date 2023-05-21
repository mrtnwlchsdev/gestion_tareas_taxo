<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Task;

class TasksController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Se realiza la consulta de todas las tareas asociadas a un usuario en especifico
        $tasks = Task::selectRaw('id, task_title, tags, task_description, favorite_task, completed_task')->where('user_id', $user->id);
        // Se paginan desde el back las tareas consultadas
        $all_tasks = $tasks->get();
        $pagination = $tasks->paginate(9);;

        return Inertia::render('Pages/views/TasksView', [
            "tasks_pagination" => $pagination,
            "all_tasks" => $all_tasks,
        ]);
    }

    public function create()
    {
        return Inertia::render('Pages/views/CreateView');
    }

    public function store(Request $request)
    {
        $task = new Task;
        $user = Auth::user();

        $task->tags = $request->tags;
        $task->task_title = $request->title;
        $task->task_description = $request->description;
        $task->user_id = $user->id;
        $task->save();
    }


    public function destroy(Request $request)
    {
        $task = Task::find($request->id);

        if ($task) {
            $task->delete();
            return response()->json([
                'message' => 'Tarea eliminada correctamente',
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se encontró la tarea',
            ], 400);
        }
    }

    // Actualizar el estado favorito de una tarea
    public function updateFavoriteTask(Request $request)
    {
        $task = Task::find($request->id);

        if ($task) {
            $task->favorite_task = !$task->favorite_task;
            $task->save();

            return response()->json([
                'message' => 'Tarea actualizada correctamente',
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se encontró la tarea',
            ], 400);
        }
    }

    // Actualizar el título y descripción de una tarea
    public function updateTask(Request $request)
    {
        $task = Task::find($request->id);

        if ($task) {
            $task->task_title = $request->title;
            $task->task_description = $request->description;
            $task->save();

            return response()->json([
                'message' => 'Tarea actualizada correctamente',
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se encontró la tarea',
            ], 400);
        }
    }

    public function show($id)
    {
        $task = Task::find($id);

        return Inertia::render('Pages/views/ShowView', ["data" => $task]);
    }

    public function completeTask(Request $request)
    {
        $task = Task::find($request->id);

        if ($task) {
            $task->completed_task = !$task->completed_task;
            $task->save();

            return response()->json([
                'message' => 'Tarea actualizada correctamente',
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se encontró la tarea',
            ], 400);
        }
    }
}
