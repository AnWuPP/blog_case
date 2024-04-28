<?php

namespace App\Orchid\Screens\Posts;

use App\Models\Post;
use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Facades\Layout;
use Illuminate\Http\Request;

class PostEditScreen extends Screen
{
    /**
     * @var Post
     */
    public $post;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Post $post): iterable
    {
        $post->load('attachment');
        return [
            'post' => $post
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->post->exists ? 'Edit Post' : 'Create Post';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make(__('Delete'))
                ->icon('bs.trash3')
                ->confirm(__('Are you sure you want to delete this post?'))
                ->method('delete')
                ->canSee($this->post->exists),
            Button::make(__('Save'))
                ->icon('bs.check-circle')
                ->method('save'),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::rows([
                Input::make('post.title')
                    ->type('text')
                    ->max(255)
                    ->required()
                    ->title(__('Title'))
                    ->placeholder(__('Title')),

                Quill::make('post.content')
                    ->required()
                    ->title(__('Content'))
                    ->placeholder('Content'),
                    
                Upload::make('post.attachment')
                        ->title('Upload files')
                        ,
            ])->title('Post'),
        ];
    }

    public function save(Post $post, Request $request)
    {
        $request->validate([
            'post.title' => [
                'required',
                'max:255',
            ],
            'post.content' => [
                'required',
            ],
        ]);

        $post->fill($request->get('post'));
        $post->user_id = auth()->user()->id;
        $post->save();
        
        $post->attachment()->syncWithoutDetaching(
            $request->input('post.attachment', [])
        );
    
        Toast::info(__('Post was saved.'));
    
        return redirect()->route('platform.posts');
    }

    public function delete(Post $post)
    {
        $post->delete();

        Toast::info(__('Post was deleted.'));

        return redirect()->route('platform.posts');
    }
}
