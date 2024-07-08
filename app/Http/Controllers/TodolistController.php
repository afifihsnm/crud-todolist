<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todolist;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Resources\TodolistCollection;
use App\Http\Resources\TodolistResource;
use App\Http\Requests\ShowTodolistRequest;
use App\Http\Requests\CreateTodolistRequest;
use App\Http\Requests\UpdateTodolistRequest;


class TodolistController extends Controller
{
    private const DEFAULT_PER_PAGE = 10;

    public function show(ShowTodolistRequest $request) {
        $data = $request->validated();

        if (!isset($data["per_page"])) $data["per_page"] = self::DEFAULT_PER_PAGE;

        $todos = Todolist::query();

        if (isset($data["name"])) $todos = $todos->where('name', 'like', '%'.$data["name"].'%');

        if (isset($data["status"])) $todos = $todos->where('status', $data["status"]);

        $todos = $todos->paginate($data["per_page"]);

        if ($todos->isEmpty()) throw new HttpResponseException(response()->json([
            'message' => 'Todolist Kosong',
            'data' => []
        ], 404));
        
        return response()->json([
            "message" => "Berhasil mengambil data",
            "data" => new TodolistCollection($todos)
        ]);
    }

    public function create(CreateTodolistRequest $request) {
        $data = $request->validated();

        $todo = new Todolist();
        $todo->name = $data["name"];
        $todo->description = $data["description"];
        $todo->status = 0;
        $todo->save();

        return response()->json([
            'message' => 'Data berhasil ditambahkan',
            'data' => new TodolistResource($todo)
        ]);
    }

    public function update(UpdateTodolistRequest $request, $id) {
        $todo = Todolist::find($id);

        if (!$todo) throw new HttpResponseException(response()->json([
            'message' => 'Todolist tidak ditemukan'
        ], 404));

        $todo->update($request->validated());

        return response()->json([
            'message' => 'Data berhasil diupdate',
            'data' => new TodolistResource($todo)
        ]);
    }

    public function delete($id) {
        $todo = Todolist::find($id);

        if (!$todo) throw new HttpResponseException(response()->json([
            'message' => 'Todolist tidak ditemukan'
        ], 404));

        $todo->delete();

        return response()->json([
            'message' => 'Data berhasil dihapus'
        ]);
    }
}
