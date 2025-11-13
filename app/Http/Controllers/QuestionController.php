<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Question;
use App\Models\User;
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
        $questions = Question::where('user_id', Auth::user()->id)->paginate(10);
        return view('questions.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categories = Category::all();
        return view('questions.create', compact('categories'));
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
        $question = Question::create([
            'title' => $new_question['title'],
            'body' => $new_question['body'],
            'user_id' => $user->id,
        ]);

        $question->categories()->attach($request->category_id);

        return redirect()->route('questions.index')->with('success', 'Question created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        //
        $question = Question::with(['users', 'answers.users'])->findOrFail($question->id);
        return view('questions.show', compact('question'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        //
        $categories = Category::all();

        $question->categories()->attach($question->categories);
        return view('questions.edit', compact('question', 'categories'));
        
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
