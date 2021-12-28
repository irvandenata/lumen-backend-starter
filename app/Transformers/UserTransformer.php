<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
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
    public function transform(User $user): array
    {
        return [
            'id' => $user->id,
            'name' => (string) $user->name,
            'email' => (string) $user->email,
            'address' => (string) $user->address,
            'description' => (string) $user->description,
            'social_media' => $user->sosmeds,
            'photo' => ($user->files->first() != null) ?  url('') . "/storage/" . $user->files->first()->link : null,
        ];
    }
}
