<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('questions.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('questions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $new_question = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $user = Auth::user();
        Question::create([
            'title' => $new_question['title'],
            'body' => $new_question['body'],
            'user_id' => $user->id,
        ]);

        return redirect()->route('questions.index')->with('success', 'Question created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        //
        $question = Question::findOrFail($question->id);
        return view('questions.show', compact('question'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        //
        $question = Question::findOrFail($question->id);
        return view('questions.edit', compact('question'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Question $question)
    {
        //
        $user = Auth::user();
        $old_question = Question::find($question->id);


        if ($user->id !== $old_question->user_id) {
            return redirect()->route('questions.index')->with('error', 'You are not authorized to edit this question.');
        }
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $new_question = array_merge($validatedData, ['user_id' => $user->id]);
        
        $old_question->update($new_question);

        return redirect()->route('questions.index')->with('success', 'Question updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        //
        $user = Auth::user();
        $old_question = Question::find($question->id);
        if ($user->id !== $old_question->user_id) {
            return redirect()->route('questions.index')->with('error', 'You are not authorized to delete this question.');
        }
        $old_question->delete();
        return redirect()->route('questions.index')->with('success', 'Question deleted successfully.');
    }
}
