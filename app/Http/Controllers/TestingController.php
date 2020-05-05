<?php

namespace App\Http\Controllers;

use App\Http\Models\Answer;
use App\Http\Models\PassedQuestion;
use App\Http\Models\Test;
use App\Http\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id){
        $test = Test::find($id);

        return view('testing', ['test' => $test]);
    }

    public function testingEvaluation($id, Request $req){
        $questions = Test::find($id)->questions;
        $user = User::find(Auth::user()->id);
        $answers = $req->input('answers');

        foreach ($questions as $question) {
            $answer = null;
            try{
                $answer = $answers[$question->id];
            }catch (Exception $e){
                $user->passed_questions()->where('question_id', $question->id)->delete();
                continue;
            }
            
            if($question->type === 'writeAnswer'){
                $tmp = (mb_strtolower($question->answers[0]->text, 'utf-8') === mb_strtolower($answer, 'utf-8'));
                $user->passed_questions()->updateOrCreate(
                    ['question_id' => $question->id],
                    ['question_id' => $question->id, 'written_answer' => $answer, 'is_passed' => $tmp]
                );
            }
            elseif($question->type === 'oneAnswer'){
                $tmp = $question->answers->find($answer)->is_correct;
                $user->passed_questions()->updateOrCreate(
                    ['question_id' => $question->id],
                    ['question_id' => $question->id, 'answer_id' => $answer, 'is_passed' => $tmp]
                );
            }
            elseif($question->type === 'fewAnswers'){
                $userAnswers = $question->answers->find($answer)->pluck('is_correct')->toArray();
                $user->passed_questions()->where('question_id', $question->id)->delete();
                foreach($userAnswers as $key => $value){
                    $user->passed_questions()->create(
                        ['question_id' => $question->id, 'answer_id' => $answer[$key], 'is_passed' => $value]
                    );
                }
            }
        }
        
        return redirect()->route('testingResults', $id);
    }

    public function testingResults($id){
        $questions = Test::find($id)->questions;
        $answers = Auth::user()->passed_questions()->whereIn('question_id', $questions->pluck('id')->toArray())->get();
        
        $res = [];

        foreach ($questions as $question) {
            $answer = $answers->where('question_id', $question->id)->pluck('is_passed')->toArray();

            if($answer == null){
            $answer = [0];
            }
            if($question->type === 'writeAnswer' || $question->type === 'oneAnswer'){
                $res[] = head($answer);
            } 
            elseif($question->type === 'fewAnswers'){
                $correctAnswers = $question->answers->where('is_correct', true)->count();
                $res[] = array_sum($answer)/(count($answer)+$correctAnswers-array_sum($answer));
            }
        }
        
        return view('testingResults', ['test' => Test::find($id), 'userAnswers' => $answers, 'result' => round(array_sum($res)/count($res), 2)]);
    }
}


// foreach ($questions as $question) {
//     $answer = $answers->where('question_id', $question->id)->pluck('is_passed')->toArray();
//     if($answer == null){
//        $answer = [0];
//     }
//     if($question->type === 'writeAnswer' || $question->type === 'oneAnswer'){
//         $res[] = head($answer);
//     } 
//     elseif($question->type === 'fewAnswers'){
//         $correctAnswers = $question->answers->where('is_correct', true)->count();
//         $res[] = array_sum($answer)/(count($answer)+$correctAnswers-array_sum($answer));
//     }
// }
// foreach ($questions as $question) {
//     $answer = $answers->where('question_id', $question->id);
    
//     if($answer == null){
//        $answer = 0;
//     }
//     if($question->type === 'writeAnswer'){
//         $res[] = $answer->pluck('is_passed')->first();
//         $i = $answers->where('question_id', $question->id)->pluck('written_answer')->first();
//         $userAnswers[$question->id] = ['text' => $question->text, 'user_answer' => mb_strtolower($i, 'utf-8'), 'correct_answer' => mb_strtolower($question->answers->pluck('text')->first(), 'utf-8')];
//     }
//     elseif($question->type === 'oneAnswer'){
//         $res[] = $answer->pluck('is_passed')->first();
//         $i = $answers->where('question_id', $question->id)->pluck('answer_id')->first();
//         $userAnswers[$question->id] = ['text' => $question->text, 'user_answer' => Answer::find($i)->text, 'correct_answer' => $question->answers->where('is_correct', true)->pluck('text')->first()];
//     }
//     elseif($question->type === 'fewAnswers'){
//         $uAnswers = $answer->pluck('is_passed')->toArray();
//         $correctAnswers = $question->answers->where('is_correct', true)->count();
//         $res[] = array_sum($uAnswers)/(count($uAnswers)+$correctAnswers-array_sum($uAnswers));
//         $i = $answers->where('question_id', $question->id)->pluck('answer_id')->all();
//         $userAnswers[$question->id] = ['text' => $question->text, 'user_answer' => Answer::find($i)->pluck('text')->toArray(), 'correct_answer' => $question->answers->where('is_correct', true)->pluck('text')->toArray()];
//     }
// }