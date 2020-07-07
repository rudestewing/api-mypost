<?php

namespace App\Http\Controllers\Api\Post;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Transformers\PostTransformer;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;

class FetchPostController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $paginator = Post::paginate();
        $posts = $paginator->getCollection();
        $resource = new Collection($posts, new PostTransformer);
        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));
        
        return response()->json(
            fractal()
                ->collection($paginator->getCollection())
                ->transformWith(new PostTransformer())
                ->paginateWith(new IlluminatePaginatorAdapter($paginator))
                ->toArray(),
            // $this->fractal->createData($resource)->toArray(),
            200
        );
        // return $this->fractal->createData($resource)->toArray();
    }
}
