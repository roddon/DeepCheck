<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id'  => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'contactNumber' => $this->contact_number,
            'accountNumber' => optional($this->company)->account_number,
            'sftpUN' => $this->sftp_un,
            'sftpPW' => $this->sftp_pw,
            'sftpServerIp' => $this->sftp_server_ip,
            'sftpToken' => $this->sftp_token
        ];
    }
}
