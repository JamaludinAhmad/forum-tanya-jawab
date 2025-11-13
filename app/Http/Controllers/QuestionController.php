<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $questions = Question::with('categories')
            ->where('user_id', Auth::id())
            ->withCount('answers')
            ->latest()
            ->paginate(10);

        return view('questions.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('questions.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $new_question = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'category_ids' => 'required|array|min:1',
            'category_ids.*' => 'exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('questions', 'public');
        }

        $question = Question::create([
            'title' => $new_question['title'],
            'body' => $new_question['body'],
            'image_url' => $imagePath,
            'user_id' => Auth::id(),
        ]);

        $question->categories()->sync($new_question['category_ids']);

        return redirect()->route('questions.index')->with('success', 'Question created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        $question->load(['users', 'categories', 'answers.user']);
        return view('questions.show', compact('question'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        if ($question->user_id !== Auth::id()) {
            return redirect()->route('questions.index')->with('error', 'You are not authorized to edit this question.');
        }

        $question->load('categories');
        $categories = Category::all();

        return view('questions.edit', compact('question', 'categories'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Question $question)
    {
        if (Auth::id() !== $question->user_id) {
            return redirect()->route('questions.index')->with('error', 'You are not authorized to edit this question.');
        }
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'category_ids' => 'required|array|min:1',
            'category_ids.*' => 'exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($question->image_url) {
                Storage::disk('public')->delete($question->image_url);
            }
            $question->image_url = $request->file('image')->store('questions', 'public');
        }

        $question->update([
            'title' => $validatedData['title'],
            'body' => $validatedData['body'],
            'image_url' => $question->image_url,
        ]);

        $question->categories()->sync($validatedData['category_ids']);

        return redirect()->route('questions.index')->with('success', 'Question updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        if (Auth::id() !== $question->user_id) {
            return redirect()->route('questions.index')->with('error', 'You are not authorized to delete this question.');
        }
        if ($question->image_url) {
            Storage::disk('public')->delete($question->image_url);
        }
        $question->categories()->detach();
        $question->delete();
        return redirect()->route('questions.index')->with('success', 'Question deleted successfully.');
    }
}
