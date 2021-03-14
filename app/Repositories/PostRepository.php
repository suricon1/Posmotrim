<?php
namespace App\Repositories;

use App\Models\Blog\Post;

class PostRepository {

    public function getPosts($request, $page)
    {
        return Post::with('comments')->
            active()->
            sort($this->getSort($request))->
            paginate(10, ['*'], 'page', $page);
    }

    public function getPostsByCategory($category, $request, $page)
    {
        return Post::with('comments')->
            where('category_id', $category->id)->
            active()->
            sort($this->getSort($request))->
            paginate(10, ['*'], 'page', $page);
    }

    public function getParams($request)
    {
        return $request->get('field')
            ? '?field='.$request->get('field').'&order_by='.$request->get('order_by')
            : '';
    }

    public function getSort($request)
    {
        return $request->get('field')
            ? ['field' => $request->get('field'), 'order_by' => $request->get('order_by')]
            : false;
    }
}
