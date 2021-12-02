<?php

namespace App\Transformers;

use App\Models\Content;
use League\Fractal\TransformerAbstract;

class ContentTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Content $content): array
    {
        return [
            'id' => $content->id,
            'title' => (string) $content->title,
            'body' => (string) $content->body,
            'status' => (string) $content->status,
            'view_count' => (string) $content->view_count,
            'like' => (string) $content->like,
            'category' => $content->category,
            'tags' => $content->tags,
            'slug' => (string) $content->slug,
        ];
    }
}
