<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    protected $showSensitiveFields = false;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if (!$this->showSensitiveFields) {
            $this->resource->makeHidden(['phone_number', "email"]);
        }

        // return parent::toArray($request);
        $data =  parent::toArray($request);
        $data['bound_phone_number'] = $this->resource->phone_number ? true : false;
        $data['bound_wechat'] = ($this->resource->weixin_openid || $this->resource->weixin_unionid) ? true : false;
        return $data;
    }

    public function showSensitiveFields($boolean = true)
    {
        $this->showSensitiveFields = $boolean;
        return $this;
    }
}
