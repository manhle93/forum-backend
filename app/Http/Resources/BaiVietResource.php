<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BaiVietResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'anh_dai_dien' => $this->anh_dai_dien,
            'noi_dung' => $this->noi_dung,
            'tieu_de' => $this->tieu_de,
        ];
    }
}
