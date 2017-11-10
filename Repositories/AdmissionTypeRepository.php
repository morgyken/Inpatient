<?php
namespace Ignite\Inpatient\Repositories;

use Ignite\Inpatient\Entities\AdmissionType;
use Carbon\Carbon;

class AdmissionTypeRepository
{
	/*
	* Return all the admission types from the database
	*/
	public function all()
	{
		return AdmissionType::all();
	}

	/*
	* Persist a new admission type into the database
	*/
	public function create($fields)
	{
		return AdmissionType::create($fields);
	}

	/*
	* Persist a new admission type into the database
	*/
	public function update($id, $fields)
	{
		return AdmissionType::where('id', $id)->update($fields);
	}

	/*
	* Make the admission types json ready for ajax calls
	*/
	public function jsonReady($admissionTypes)
	{	
		$jsonReadyData = $admissionTypes->map(function($admission){

            return [
				$admission->name, 
				$admission->deposit,
                $admission->description,
                Carbon::parse($admission->created_at)->toDateString(),
                '<a href="'.url("/inpatient/admission-types/".$admission["id"]."/delete").'" class="btn btn-danger btn-xs">Delete</a>
                                        <button class="btn btn-primary btn-xs edit" id="'.$admission->id.'" >Edit</button>'
            ];

        })->toArray();

		return [
			'data' => $jsonReadyData
		];
	}

	/*
	* Find the admission type by the id
	*/
	public function findById($id)
	{
		return AdmissionType::findOrFail($id);
	}
}