<?php

namespace App\Http\Controllers;

use App\Http\Models\Question;
use App\Http\Models\Test;
use Illuminate\Http\Request;

class TestsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function editTest($id){
        $test = Test::find($id);
        $questionTypes = [  'oneAnswer' => 'Одна правельна відповідь', 
                            'fewAnswers' => 'Декілька правельних відповідей', 
                            'writeAnswer' => 'Записати відповідь' ];


        return view('editTest', ['test' => $test, 'questionTypes' => $questionTypes]);
    }

    public function saveQuestion($id, Request $req){
        $req->validate(['text' => 'required|min:10',
                        'answers' => 'required',
                        'answers.*' => 'required'],
                       ['text.*' => 'Текст питання має містити принаймні 10 символів!',
                        'answers.*' => 'Питання має мати відповіді!']);
        if($req->input('type') === 'oneAnswer' || $req->input('type') === 'fewAnswers'){
            $req->validate(['right-answers' => 'required'], ['right-answers.*' => 'Ви не вказали правильну відповідь!']);
        }
        
        $test = Test::find($id);
        $question = $test->questions()->create(['text' => $req->input('text'), 'type' => $req->input('type')]);
        
        foreach($req->input('answers') as $key => $value){
            if($req->input('type') == 'writeAnswer'){
                $question->answers()->create(['text' => $value, 'is_correct' => true]);
            }
            else{
                if (in_array($key, $req->input('right-answers'))) {
                    $question->answers()->create(['text' => $value, 'is_correct' => true]);
                }
                else{
                    $question->answers()->create(['text' => $value, 'is_correct' => false]);
                }
            }
        }
    
        return redirect()->route('editTest', $id);
    }

    public function updateQuestion($test_id, $question_id, Request $req){
        $req->validate(['text' => 'required|min:10',
                        'answers' => 'required',
                        'answers.*' => 'required'],
                       ['text.*' => 'Текст питання має містити принаймні 10 символів!',
                        'answers.*' => 'Питання має мати відповіді!']);
        if($req->input('type') === 'oneAnswer' || $req->input('type') === 'fewAnswers'){
            $req->validate(['right-answers' => 'required'], ['right-answers.*' => 'Ви не вказали правильну відповідь!']);
        }
        $question = Question::find($question_id);
        $question->text = $req->input('text');
        $question->type = $req->input('type');
        $question->save();

        if($req->input('type') != $question->type || count($req->input('answers')) != $question->answers()->count()){
           $question->answers()->delete();
           foreach($req->input('answers') as $key => $value){
                if($req->input('type') == 'writeAnswer'){
                    $question->answers()->create(['text' => $value, 'is_correct' => true]);
                }
                else{
                    if (in_array($key, $req->input('right-answers'))) {
                        $question->answers()->create(['text' => $value, 'is_correct' => true]);
                    }
                    else{
                        $question->answers()->create(['text' => $value, 'is_correct' => false]);
                    }
                }
            }
        }
        else{
            return 'Dodelat';
        }

        return redirect()->route('editTest', $test_id);
    }

    public function deleteQuestion($test_id, $question_id){
        Question::find($question_id)->delete();

        return redirect()->route('editTest', $test_id);
    }
}
