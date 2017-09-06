<?php

/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: Collabmed Health Platform
 * Author: Samuel Okoth <sodhiambo@collabmed.com>
 *
 * =============================================================================
 */

namespace Ignite\Inpatient\Library;

use Ignite\Inpatient\Repositories\InpatientRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


/**
 * Description of FunctionsRepository
 *
 * @author samuel
 */
class InpatientFunctions implements InpatientRepository
{

    /**
     * Incoming HTTP request
     * @var Request
     *
     */
    protected $request;

    /**
     * The filtered input
     * @var array
     */
    protected $input;

    /**
     * Visit reference ID
     * @var mixed|int
     */
    protected $visit;

    /**
     * User making the request
     * @var int
     */
    protected $user;

    /**
     * Model ID or null
     * @var null|int
     */
    protected $id = null;

    /**
     * EvaluationFunctions constructor.
     * @param Request $request
     * @param InventoryRepository $repo
     */
    public function __construct(Request $request, InpatientRepository $repo)
    {
        $this->request = $request;
        $this->repo = $repo;
        $this->input = $this->request->all();
        if ($this->request->has('visit')) {
            $this->visit = $this->request->visit;
        }
        if (Auth::check()) {
            $this->user = $this->request->user()->id;
        }
        $this->prepareInput($this->input);

        $this->inventoryRepository = $repo;
    }

    /**
     * Remove the token from the input array
     * Also remove empty values
     * @param $input
     */
    private function prepareInput(&$input)
    {
        unset($input['_token']);
        foreach ($input as $key => $value) {
            if (empty($value)) {
                unset($input[$key]);
            }
        }
        if (!empty($input['id'])) {
            $this->id = $input['id'];
            unset($input['id']);
        }
    }

}
