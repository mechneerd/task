<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentsController extends Controller
{

    //
    public function store(Request $request){
        
        //validate
        $newstudent = $request->validate([
            'name'=>['required','max:100'],
            'subject'=>['required','max:100'],
            'marks'=>['required','max:100','numeric'],

        ]);
        $newstudent['user_id'] = auth()->id();

        //create student
        Student::create($newstudent);
        
        // return
        //return redirect('/studentlist')->with('message','Create successfully');
    }

    public function destroy($id){
       // dd($id);
        $student = Student::find($id)->delete();

    }

    public function getStudents(){
        $user_id = auth()->id();
        $all = Student::where('user_id', $user_id)
        ->select('student_id', 'name', 'subject', 'marks')
        ->get();
        return response()->json($all); 
    }

    public function update(Request $request, $id)
    {

       // dd($id);
        $request->validate([
            'name' => 'required|string|max:100',
            'subject' => 'required|string|max:100',
            'marks' => 'required|numeric',
        ]);

        $student = Student::findOrFail($id);

        $student['name']= $request['name'];
        $student['subject']= $request['subject'];
        $student['marks']= $request['marks'];

        $student->save();

       
    }
}
