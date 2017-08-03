<?php
/**
 * Created by PhpStorm.
 * User: bravo
 * Date: 8/3/17
 * Time: 11:13 AM
 */

namespace Ignite\Inpatient\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;

class Controller extends AdminBaseController {

    /**
     * @var InpatientRepository
     */
    protected $inpatientRepository;

    /**
     * SetupController constructor.
     * @param InpatientRepository $InpatientRepository
     */
    public function __construct() {
        parent::__construct();
        //$this->inpatientRepository = $inpatientRepository;
    }

    public function index()
    {
        //dd('');
        return view('inpatient::temp');
    }


}

