<?php

namespace App\Transformers;

use App\Models\Banner;
use League\Fractal\TransformerAbstract;

class BannerTransformer extends TransformerAbstract
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
    public function transform(Banner $banner): array
    {
        return [
            'id' => $banner->id,
            'title' => (string) $banner->title,
            'description' => (string) $banner->description,
            'photo' => ($banner->files->first() != null) ?  url('') . "/storage/" . $banner->files->first()->link : null,
        ];
    }
}
