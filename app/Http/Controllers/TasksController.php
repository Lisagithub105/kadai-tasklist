<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task; // 追加

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // getでtasksにアクセスされた場合の「一覧表示処理」
    public function index()
    {
        $data = [];
        if (\Auth::check()) {
            //認証済の場合
            //認証済ユーザを取得
            $user = \Auth::user();
            //ユーザ投稿の一覧を作成日時の降順で取得
            $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);
            $data = [
                'user' => $user,
                'tasks' => $tasks
            ];
            
            // indexのviewに$tasksを渡す。
            // return view('tasks.index', $tasks);
            
        }
        // welcomeビューでそれらを表示
        return view('welcome', $data);
    }
        
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $task = new Task;
        
        // タスクの作成ビューを表示
        return view('tasks.create', [
            'task'=>$task,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'status' => 'required|max:10', // カラム追加
            'content' => 'required|max:255']);
        
        // タスク名の作成
        $task = new Task;
        $task->user_id = \Auth::id();
        $task->status = $request->status; // カラム追加
        $task->content = $request->content;
        $task->save();
        
        // トップページへリダイレクトさせる
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // idの値でタスクを検索して取得
        $task = Task::findOrFail($id);
        
        if (\Auth::id() === $task->user_id) {
            // 自分自身のもの
            // ユーザ詳細ビューでそれらを表示
            return view('tasks.show', [
                // 'user' => $user,
                'task' => $task,
        ]);
        } 
            // 自分以外のもの
            // 前のURLへリダイレクトさせる
            // welcomeビューでそれらを表示
            return redirect('/');
        }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // idの値でタスク名を検索して取得
        $task = Task::findOrFail($id);
        
        // 認証済ユーザ（閲覧者）がその投稿の所有者である場合は、投稿を削除
        if (\Auth::id() === $task->user_id)
        {
            
            // idの値でメッセージを検索して取得
            $message = Message::findOrFail($id);
            // タスク名編集ビューでそれを表示
            return view('tasks.edit', [
                'task' => $task,
            ]);
            
            
        } 
            // 前のURLへリダイレクトさせる
            return back();    
        }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // バリデーション
        $request->validate([
            'status' => 'required|max:10',
            'content' => 'required|max:255',
            ]);
        
        // idの値でタスク名を検索して取得
        $task = Task::findOrFail($id);
        // タスク名を更新
        $task->status = $request->status;
        $task->content = $request->content;
        $task->save();
        
        // トップページへリダイレクトさせる
        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // idの値でタスク名を検索して取得
        $task = Task::findOrFail($id);
        // タスクを削除
        $task->delete();
        
        // トップページへリダイレクトさせる
        return redirect('/');
    }
}
