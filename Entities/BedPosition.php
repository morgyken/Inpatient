<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;

class BedPosition extends Model
{
    protected $table = 'bed_position';
    protected $fillable = ['name','ward_id','status'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ward()
    {
        return $this->belongsTo(Ward::class, 'ward_id');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeIsTaken($query)
    {
        if($query->where('status', 1) == true){
            return true;
        }

        return false;
    }

    /**
     * @param $beds
     */
    public function getAvailableBeds($beds)
    {
        $beds = $this->findOrFail();
        if (!$beds){
            return $this->errorMessage();
        }
        return $beds;
    }

    public function errorMessage()
    {
        try{
            echo '';
        }catch(\Exception $e){
            echo '';
        }
    }

    private function findOrFail($id)
    {
        Bed::find($id);
    }


}
