<?php

namespace Ignite\Inpatient\Helpers;

/**
* HELPERS FOR THE INPATIENT MODULES
*/
class InpatientHelpers
{
	
	public function calculateBMI($weight, $height)
    {
        try {
            return $weight / ($height * $height);
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function getBMIStatus($bmi)
    {
        if (($bmi > 29.9))
            return "Obese";
        else if ($bmi < 30 && $bmi > 24.9)
            return "Overweight";
        else if ($bmi < 24.8 && $bmi > 18.5)
            return "Normal";
        else if ($bmi < 18.5)
            return "Underweight";
    }
}
