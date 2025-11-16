<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        $data = parent::toArray($request);

        $viewer = $request->user();

        $canSeeRealEmail = $viewer && $viewer->hasRole('admin');

        $data['email'] = $canSeeRealEmail ? $this->email : '******@******.***';

        return $data;
    }
}