<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/18/2017
 * Time: 3:10 AM
 */


use Ignite\Inpatient\Entities\Admission;

if(!function_exists('generate_ip_number')){
    /**
     *
     */
    function generate_ip_number(){
        //R-H 001/07/2017

    }
}

if(!function_exists('get_next_bed_number')){

    /**
     * @param $ward
     */
    function get_next_bed_number($id){
        $ward_id = \Ignite\Inpatient\Entities\Ward::findOrfail($id);
        $number = substr( $ward_id, 4);

        return 'RH'. sprintf('%6d', intval($number) + 1);

    }
}

