<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TodoRequest;
use Illuminate\Http\Request;
use App\Models\Todo;
use App\Http\Resources\TodoResource;
use Symfony\Component\HttpFoundation\Response;
use function response;
use function view;


class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TodoResource::collection(Todo::orderBy('updated_at','desc')->paginate(5));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return TodoResource
     */
    public function store(TodoRequest $request)
    {
        $userInput = $request->all();

        $newTodo = Todo::create($userInput);

        return new TodoResource($newTodo);
    }

//  request 이렇게 써도됨 (TodoRequest가 아닌 일반 Request사용-> 단,TodoRequest에 있는 authorize은 사용 안됨)
//    public function store(Request $request)
//    {
//        $request -> validate([
//                'title' => 'required|max:50',
//                'content' => 'max:255',
//                'deadline' => 'date',
//                'isDone' => 'required|boolean',
//            ]);
//
//        $userInput = $request->all();
//
//        $newTodo = Todo::create($userInput);
//
//        return new TodoResource($newTodo);
//    }
//


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Todo::where('id', $id) -> exists()){
            return new TodoResource(Todo::find($id));
        } else {
            return response()->json(["message"=>"해당 할일을 찾을수가 없습니다."
            ],404,[],JSON_UNESCAPED_UNICODE);
        }
    }

//  aa에 출력
//    public function show(Todo $todo)
//    {
//        return view('aa',[
//            'todo' => $todo
//        ]);
//    }
//



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TodoRequest $request, $id)
    {
        if (Todo::where('id', $id) -> exists()){
            $fetchedTodo = Todo::find($id);

            $fetchedTodo->update($request->all());

            return new TodoResource($fetchedTodo);
        } else {
            return response()->json([
                "message"=>"해당 할일을 찾을수가 없습니다."
            ], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Todo::where('id', $id) -> exists()){
            $fetchedTodo = Todo::find($id);

            $fetchedTodo->delete();

            return response()->json([
                "message"=>"파일이 삭제되었습니다"
            ], Response::HTTP_NO_CONTENT);

        } else {
            return response()->json([
                "message"=>"해당 할일을 찾을수가 없습니다."
            ], Response::HTTP_NOT_FOUND);
        }
    }
}
