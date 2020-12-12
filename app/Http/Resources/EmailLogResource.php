<?php

namespace App\Http\Resources;

use DOMDocument;
use Illuminate\Http\Resources\Json\JsonResource;

class EmailLogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $dom = new DOMDocument;
        libxml_use_internal_errors(true);
        $dom->loadHTML($this->body);
        $node = $dom->getElementById('emailView');
        $body = "";
        if ($node) {
            $body = $dom->saveXML($node);
        }

        return [
            'id' => $this->id,
            'date' => $this->created_at ? $this->created_at->toDateTimeString() : '',
            'to' => $this->to,
            'from' => $this->from,
            'subject' => $this->subject,
            'body' => $body

        ];
    }
}
