<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\PostRepository;
use App\Transformers\PostTransformer;

class PostsController extends BaseController
{
    /**
     * @var PostRepository
     */
    protected $repository;

    public function __construct(PostRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $posts = $this->repository->paginate();

        return $this->response->paginator($posts, new PostTransformer());
    }

    public function store()
    {

    }

    public function show($id)
    {

    }

    public function update($id)
    {

    }

    public function destroy($id)
    {

    }
}
