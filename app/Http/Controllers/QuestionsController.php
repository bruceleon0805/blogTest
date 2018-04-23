<?php

namespace App\Http\Controllers;

use App\Question;
use App\Repositories\QuestionRepositories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionsController extends Controller
{
    protected $questionRepositoriy;

    public function __construct(QuestionRepositories $questionRepositories)
    {
        //添加用户等路验证   首页和显示页面无需验证
        $this->middleware('auth')->except('index', 'show');
        $this->questionRepositoriy = $questionRepositories;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('questions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $topics = $this->questionRepositoriy->normalizeTopic($request->get('topics'));
        $data = [
            'title' => $request->get('title'),
            'body' => $request->get('body'),
            'user_id' => Auth::id(),
        ];
        $quetion = $this->questionRepositoriy->create($data);

        $quetion->topics()->attach($topics);   //关联questions_topics

        return redirect()->route('question.show' . [$quetion->id]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $question =$this->questionRepositoriy->byIdWithTopics($id);

        return view('questions.show')->compact('question');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $question = $this->questionRepositoriy->byId($id);
        if (Auth::user()->owns($question)){
            return view('questions.edit',compact('question'));
        }
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $question = $this->questionRepositoriy->byId($id);
        $question->update([
            'title' => $request->get('title'),
            'body' => $request->get('body'),
        ]);
        $question->topics()->sync($question);  //同步

        return redirect()->route('question.show',[$question->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
