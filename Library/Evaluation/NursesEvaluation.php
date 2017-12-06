<?php

namespace Ignite\Inpatient\Library\Evaluation;

use Ignite\Evaluation\Entities\Visit;

use Ignite\Inpatient\Library\Interfaces\EvaluationInterface;

use Ignite\Inpatient\Entities\InpatientNote;

use Carbon\Carbon;

class NursesEvaluation implements EvaluationInterface
{
    protected $visit; 
    
    /*
    * Initialize the visit property
    */
    public function __construct(Visit $visit)
    {
        $this->visit = $visit;
    }


    /*
    * Method must be defined, gets the prescriptions
    */
    public function data()
    {
        $notes = InpatientNote::where('type', 'nurse')->
                                where('visit_id', $this->visit->id)->
                                orderBy('created_at', 'DESC')->get()->map(function($note){
            return [
                'title' => $note->title ? $note->title : 'Nurses Note',
                'body' => $note->notes,
                'date' => Carbon::parse($note->created_at)->toDateTimeString()
            ];
        });

        return compact('notes');
    }

    /*
    * Persist the doctors notes into the database
    */
    public function persist()
    {
        $notes = request()->all();
        $notes['visit_id'] = $this->visit->id;
        $notes['type'] = 'nurse';

        return InpatientNote::create($notes);
    }
}

