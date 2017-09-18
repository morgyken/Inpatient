<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/18/2017
 * Time: 3:10 AM
 */


use Ignite\Inpatient\Entities\Admission;
use Carbon\Carbon;
use Ignite\Inventory\Entities\InventoryProducts;

if (!function_exists('generate_ip_number')) {
    /**
     *
     */
    function generate_ip_number()
    {
        //R-H 001/07/2017
        $dateOfAdmission = Carborn::now()->startOfYear();
        $hospitalInitials = 'RH';
        $number = substr($dateOfAdmission, 5);

        return $hospitalInitials . sprintf(intval($number) + 1);

    }
}

if (!function_exists('get_next_bed_number')) {

    /**
     * @param $ward
     * @return string
     */
    function get_next_bed_number($id)
    {
        $ward_id = \Ignite\Inpatient\Entities\Ward::findOrfail($id);
        $number = substr($ward_id, 4);

        return 'RH' . sprintf('%6d', intval($number) + 1);

    }
}
if (!function_exists('get_inventory_consumables')) {
    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    function get_inventory_consumables()
    {
        return InventoryProducts::whereConsumable(true)->get();
    }
}


if (!function_exists('save_patient_transaction')) {
    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    function save_patient_transaction()
    {
        return InventoryProducts::whereConsumable(true)->get();
    }
}