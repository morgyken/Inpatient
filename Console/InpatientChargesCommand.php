<?php

namespace Ignite\Inpatient\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Ignite\Inpatient\Entities\Charge;
use Ignite\Inpatient\Entities\ChargeSheet;
use Ignite\Inpatient\Entities\Admission;

class InpatientChargesCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'inpatient:charges';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Charges and bills for inpatient.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $admissions = Admission::all();

        foreach($admissions as $admission)
        {
            $visit = $admission->visit;

            $ward = $admission->ward;
            
            $wardPrice = $visit->patients->schemes ? $ward->insurance_cost : $ward->cash_cost;
    
            ChargeSheet::create([
                'visit_id' => $visit->id,
                'ward_id' => $ward->id,
                'price' => $wardPrice
            ]);

            foreach(Charge::all() as $charge)
            {
                if($charge->type == 'recurring')
                {
                    ChargeSheet::create([
                        'visit_id' => $visit->id,
                        'charge_id' => $charge->id,
                        'price' => $charge->cost
                    ]);
                }
            }
        }
    }
}
