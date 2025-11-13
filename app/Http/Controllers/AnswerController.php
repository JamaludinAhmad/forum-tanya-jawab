<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{
    public function store(Request $request, Question $question)
    {
        //

        $answer = $request->validate([
            'text' => 'required|string',
        ]);

        $question->answers()->create([
            'text' => $answer['text'],
            'user_id' => Auth::user()->id,
        ]);

        return redirect()->route('questions.show', $question)->with('success', 'Answer submitted successfully.');
    }

    public function update(Request $request, Answer $answer)
    {
        if ($answer->user_id !== Auth::id()) {
            return redirect()->route('questions.show', $answer->question_id)->with('error', 'You are not authorized to update this answer.');
        }

        $question = $answer->question;

        $updated_answer = $request->validate([
            'text' => 'required|string',
        ]);
        $answer->update([
            'text' => $updated_answer['text'],
        ]);
        
        return redirect()->route('questions.show', $question)->with('success', 'Answer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Answer $answer)
    {
        $question = $answer->question;

        if ($answer->user_id !== Auth::id()) {
            return redirect()->route('questions.show', $answer->question_id)->with('error', 'You are not authorized to delete this answer.');
        }

        $answer->delete();

        return redirect()->route('questions.show', $question)->with('success', 'Answer deleted successfully.');    
    }
}
