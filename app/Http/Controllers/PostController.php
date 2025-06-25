<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;

use App\Repositories\PostRepositoryInterface;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //
    
    protected $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function index(){

        return response()->json($this->postRepository->all());

    }

    public function store(CreatePostRequest $request)
    {
        $validated = $request->validated();

        $data = [
            ...$validated,
            'user_id' => auth()->id(),
        ];

        $post = $this->postRepository->create($data);

        return response()->json([
            'success' => true,
            'message' => 'Post created successfully.',
            'data' => $post
        ], 201);
    }

    public function show($id){

        try {
           $post = $this->postRepository->find($id);

            return response()->json([
                'success' => true,
                'data' => $post
            ],200);
        } catch (\Throwable $th) {
            
            return response()->json([
                'success' => false,
                'message' => 'Post not found.'
            ], 404);

        }
                
    }

    public function update(UpdatePostRequest $request,$id){

        $validated = $request->validated();

         $data = [
            ...$validated,
            'id' => $id,
        ];

        try {

            $post = $this->postRepository->update($data);
            return response()->json([
                'success' => true,
                'message' => 'Post Updated successfully.',
                'data' => $post
            ], 200);

        } catch (\Throwable $th) {
            
            return response()->json([
                'success' => false,
                'message' => 'Post not found.'
            ], 404);

        }
       

    }

    public function destroy($id)
    {
        try {
            $this->postRepository->delete($id);

            return response()->json([
                'success' => true,
                'message' => 'Post deleted successfully.'
            ], 200);
            
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found or could not be deleted.'
            ], 404);
        }
    }







  

}
