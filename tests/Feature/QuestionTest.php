<?php

namespace Tests\Feature;

use App\Models\Question;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class QuestionTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_view_question_page(): void
    {
        $response = $this->get('/questions');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public function test_user_can_view_question_page(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/questions');

        $response->assertStatus(200);
    }

    public function test_user_can_view_create_question_page(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/questions/create');

        $response->assertStatus(200);
    }

    public function test_user_can_show_question(): void
    {
        $user = User::factory()->create();
        $question = Question::factory()->create();

        $response = $this->actingAs($user)->get('/questions/' . $question->id);

        $response->assertStatus(200);
    }

    public function test_user_can_view_other_user_question(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $question = Question::factory()->create([
            'user_id' => $user2->id,
        ]);

        $response = $this->actingAs($user1)->get('/questions/' . $question->id);

        $response->assertStatus(200);
    }

    public function test_guest_cannot_create_question(): void
    {
        $response = $this->post('/questions', [
            'title' => 'Sample Question Title',
            'body' => 'This is a sample question body.',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }


    public function test_authenticated_user_can_create_question(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/questions', [
            'title' => 'Sample Question Title',
            'body' => 'This is a sample question body.',
            'user_id' => $user->id,
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('questions', [
            'title' => 'Sample Question Title',
            'body' => 'This is a sample question body.',
            'user_id' => $user->id,
        ]);
    }

    public function test_user_can_edit_question(): void
    {
        $user = User::factory()->create();

        // Implement test for editing a question
        $question = Question::factory()->create([
            'title' => 'Original Title',
            'body' => 'Original body content.',
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseHas('questions', [
            'title' => 'Original Title',
            'body' => 'Original body content.',
        ]);

        $response = $this->actingAs($user)->put('/questions/' . $question->id, [
            'title' => 'Updated Question Title',
            'body' => 'This is the updated question body.',
        ]);

        $this->assertDatabaseHas('questions', [
            'title' => 'Updated Question Title',
            'body' => 'This is the updated question body.',
        ]);

        $this->assertDatabaseMissing('questions', [
            'title' => 'Original Title',
            'body' => 'Original body content.',
        ]);

        $response->assertStatus(302);
    }

    public function test_user_cannot_edit_other_users_question(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $question = Question::factory()->create([
            'title' => 'User1 Question',
            'body' => 'Content by User1.',
            'user_id' => $user1->id,
        ]);

        $this->assertDatabaseHas('questions', [
            'title' => 'User1 Question',
            'body' => 'Content by User1.',
        ]);

        $response = $this->actingAs($user2)->put('/questions/' . $question->id, [
            'title' => 'Malicious Update',
            'body' => 'Trying to edit another user\'s question.',
        ]);

        $this->assertDatabaseHas('questions', [
            'title' => 'User1 Question',
            'body' => 'Content by User1.',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('error', 'You are not authorized to edit this question.');
    }

    public function test_user_can_delete_question(): void
    {
        $user = User::factory()->create();

        $question = Question::factory()->create([
            'title' => 'Question to be deleted',
            'body' => 'This question will be deleted.',
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseHas('questions', [
            'title' => 'Question to be deleted',
            'body' => 'This question will be deleted.',
        ]);

        $response = $this->actingAs($user)->delete('/questions/' . $question->id);

        $this->assertDatabaseMissing('questions', [
            'title' => 'Question to be deleted',
            'body' => 'This question will be deleted.',
        ]);

        $response->assertStatus(302);
    }

    public function test_user_cannot_delete_other_users_question(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $question = Question::factory()->create([
            'title' => 'User1 Question',
            'body' => 'Content by User1.',
            'user_id' => $user1->id,
        ]);

        $this->assertDatabaseHas('questions', [
            'title' => 'User1 Question',
            'body' => 'Content by User1.',
        ]);

        $response = $this->actingAs($user2)->delete('/questions/' . $question->id);

        $this->assertDatabaseHas('questions', [
            'title' => 'User1 Question',
            'body' => 'Content by User1.',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('error', 'You are not authorized to delete this question.');
    }
}
