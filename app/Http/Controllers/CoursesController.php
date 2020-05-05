<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\User;
use App\Http\Models\Course;
use App\Http\Models\Test;
use Illuminate\Support\Facades\Auth;

class CoursesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function userCourses(){
        $createdCourses = User::find(Auth::user()->id)->createdCourses->sortByDesc('created_at');
        $subscriptions = User::find(Auth::user()->id)->courses->sortByDesc('created_at');

        return view('userCourses', ['createdCourses' => $createdCourses, 'subscriptions' => $subscriptions]);
    }

    public function createCourse(){
        $subjects = ['Астрономія', 'Біологія', 'Інформатика', 'Математика', 'Мови', 'Фізика', 'Хімія' ];
        
        return view('createCourse', ['subjects' => $subjects]);
    }

    public function saveCourse(Request $req){
        $req->validate(['name' => 'required|min:3|max:255'], 
                       ['name.*' => 'Назва курсу має містити принаймні 3 символи!']);
                       
        $user = User::find(Auth::user()->id);
        
        $course = new Course();
        $course->name = $req->input('name');
        $course->subject = $req->input('subject');
        $course->description = $req->input('description');

        $user->createdCourses()->save($course);

        return redirect()->route('userCourses');
    }

    public function updateCourse($id){
        $course = Course::find($id);

        return view('updateCourse', ['course' => $course]);
    }

    public function saveUpdatedCourse($id, Request $req){
        $req->validate(['name' => 'required|min:3|max:255',
                        'test' => 'required',
                        'test.*' => 'required|min:3|max:255'], 
                       ['name.*' => 'Назва курсу має містити принаймні 3 символи!',
                        'test.required' => 'Курс повинен мати принаймні один тест!',
                        'test.*.*' => 'Назва тесту має містити принаймні 3 символи!']);

        $course = Course::find($id);
        $course->name = $req->input('name');
        $course->description = $req->input('description');
        $course->save();

        $newTests = [];
        $oldTests = [];
        foreach($req->input('test') as $key => $value){
            if($key < 0){
                $newTests[] = ['name' => $value];
            }
            else{
                $oldTests += [$key => $value];
            }
        }

        $toDelete = array_diff($course->tests->modelKeys(), array_keys($oldTests));

        Test::destroy(array_values($toDelete));

        foreach (Test::find(array_keys($oldTests)) as $test) {
            $test->name = $oldTests[$test->id];
            $test->save();
        }

        $course->tests()->createMany($newTests);

        return redirect()->route('userCourses');
    }

    public function deleteCourse($id){
        Course::find($id)->delete();

        return redirect()->route('userCourses');
    }

    public function courseInfo($id){
        $course = Course::find($id);
        $isSubscribed = $course->users()->where('user_id', Auth::user()->id)->exists();

        return view('courseInfo', ['course' => $course, 'isSubscribed' => $isSubscribed]);
    }

    public function subscribe($id){
        $user = User::find(Auth::user()->id);
        $course = Course::find($id);
        
        $user->courses()->attach($course);
        
        return redirect()->route('courseInfo', $id);
    }

    public function unsubscribe($id){
        $user = User::find(Auth::user()->id);
        $course = Course::find($id);
        
        $user->courses()->detach($course);

        return redirect()->back();
    }

    public function publishCourse($id){
        $course = Course::find($id);
        
        if($course->tests->count() < 1){
            return redirect()->back()->withErrors(['error' => ['Курс повинен мати принаймні один тест!']]);
        }
        foreach ($course->tests as $test) {
            if($test->questions->count() < 5)
                return redirect()->back()->withErrors(['error' => ["Тест $test->name має менше п'яти запитань!"]]);
        }
            
        $course->is_published = true;
        $course->save();

        return redirect()->back();
    }

    public function unpublishCourse($id){
        $course = Course::find($id);

        $course->is_published = false;
        $course->save();

        return redirect()->back();
    }
}
