<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/18/2017
 * Time: 3:32 AM
 */

namespace Ignite\Inpatient\Sidebar;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Ignite\Core\Contracts\Authentication;
use Maatwebsite\Sidebar\Menu;
use Maatwebsite\Sidebar\SidebarExtender as Panda;


class SidebarExtender implements Panda
{

    protected $auth;


    /**
     * SidebarExtender constructor.
     * @param Authentication $auth
     */
    public function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param Menu $menu
     *
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {
        $menu->group('Dashboard', function(Group $group){
            $group->item('In-Patient', function(Item $item){
                $item->weight(3);

                $item->icon('fa fa-address-book');
                // $item->item('Admit Patient', function (Item $item) {
                //     $item->icon('fa fa-check-square-o');
                //     $item->url('/inpatient/admit');
                // });
                // $item->item('Admissions', function(Item $item) {
                //     $item->icon('fa fa-bed');
                //     $item->url('/inpatient/admission');
                //     //$item->authorize($this->auth->hasAccess('evaluation.settings.admit_patient'));
                //     $item->weight(4);
                // });
                $item->item('Awaiting admission', function(Item $item) {
                    $item->icon('fa fa-user-plus');
                    $item->url('/inpatient/admission-requests');
                    //$item->authorize($this->auth->hasAccess('evaluation.settings.admit_patient'));
                    $item->weight(4);
                });
                $item->item('Patient Management', function(Item $item) {
                    $item->icon('fa fa-users');
                    $item->url('/inpatient/admissions');
                    //$item->authorize($this->auth->hasAccess('evaluation.settings.admit_patient'));
                    $item->weight(4);
                });
                //patients waiting admissions
                $item->item('Requested Discharge ', function(Item $item) {
                    $item->icon('fa fa-exclamation-circle');
                    $item->url('/inpatient/discharge-requests');
                    //$item->authorize($this->auth->hasAccess('evaluation.settings.admit_patient'));
                    $item->weight(4);
                });

                $item->item('All Admission Logs', function(Item $item){
                    $item->icon('fa fa fa-cogs');
                    $item->url('/inpatient/admissions/logs');
                    $item->weight(4);
                });

            });

            $group->item('Setup', function (Item $item) {
                /* add recurrent services */
                $item->item('Inpatient', function(Item $item) {
                    $item->icon('fa fa-bed');
                    $item->weight(4);

                    /* add inpatient admission types */
                    $item->item('Admission types', function(Item $item) {
                        $item->icon('fa fa-heartbeat');
                        $item->url('/inpatient/admission-types');
                        $item->weight(4);
                    });

                    /* add recurrent services */
                    $item->item('Recurring & One-off Fees', function(Item $item) {
                        $item->icon('fa fa-paypal');
                        $item->url('/inpatient/charges');
                        $item->weight(4);
                    });
                    
                    //wards
                    $item->item('Wards', function(Item $item) {
                        $item->icon('fa fa-home');
                        $item->url('/inpatient/ward');
                        //$item->authorize($this->auth->hasAccess('evaluation.settings.admit_patient'));
                        $item->weight(4);
                    });
                    $item->item('Beds', function(Item $item) {
                        $item->icon('fa fa-bed');
                        $item->url('/inpatient/beds');
                        //$item->authorize($this->auth->hasAccess('evaluation.settings.admit_patient'));
                        $item->weight(4);
                    });
                    $item->item('Bed Types', function(Item $item) {
                        $item->icon('fa fa-bed');
                        $item->url('/inpatient/bed-types');
                        //$item->authorize($this->auth->hasAccess('evaluation.settings.admit_patient'));
                        $item->weight(4);
                    });

                    // Beds
                    // $item->item('Add/View Beds', function(Item $item) {
                    //     $item->icon('fa fa-bed');
                    //     $item->url('/inpatient/beds/bedList');
                    //     $item->authorize($this->auth->hasAccess('evaluation.settings.admit_patient'));
                    //     $item->weight(4);
                    // });
                        
                    /**
                    * Removed bed types and added standard bed types
                    */    
                    // $item->item('Add/View Bed Types', function(Item $item) {
                    //     $item->icon('fa fa-bed');
                    //     $item->url('/inpatient/beds/bedTypes');
                    //     //$item->authorize($this->auth->hasAccess('evaluation.settings.admit_patient'));
                    //     $item->weight(4);
                    // });  
                });
            });
        });

        return $menu;
        // TODO: Implement extendWith() method.
    }
}