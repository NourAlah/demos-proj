<?php

namespace App\Repositories;

use App\Models\Post;

class PostRepository implements PostRepositoryInterface
{
    public function all()
    {
        return Post::with('user')->latest()->get();
    }

    public function find($id)
    {
        return Post::with('user')->findOrFail($id);
    }

    public function create(array $data)
    {
        return Post::create($data);
    }

    public function update(array $data)
    {
        $post = Post::findOrFail($data['id']);
        $post->update($data);
        return $post;
    }

    public function delete($id)
    {
        $post = Post::findOrFail($id);
        return $post->delete();
    }

}
