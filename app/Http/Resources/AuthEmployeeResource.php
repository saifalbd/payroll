<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthEmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'companyName'=>$this->company->title,
            'company_id'=>$this->company->id,
            'name'=>$this->employee_name,
            'id'=>$this->id,
            'avatar'=>'',
            'email'=>$this->email,
            'phone'=>$this->phone,
            'designation'=>$this->designation,
            'department'=>$this->department->name,
            'has'=>'employee'
        ];
    }
}
