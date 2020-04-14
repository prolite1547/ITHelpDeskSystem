import {elements, hideModal, toggleFormGroups, closePModal} from "./views/base";
import {ticketViewController,ticketAddController} from "./TicketViewController";
import {DepartReportAddController,DepartReportViewController} from "./DepartReportController";
import {ticketPageController} from "./TicketPageController";
import {profileController} from "./ProfileController";
import {adminPageController} from  "./AdminPageController";
import {maintenancePageController} from "./maintenancePageController";
import {treasuryDashboardController} from "./treasury/index";
import {devProjsController} from "./devprojs/datatable";
import {MasterDataController} from "./masterdata/datatable";
import {storeVisitController} from "./storeVisit/index";
import {incompletePageController} from "./incompletePage/index.js";
import {InventoryController} from "./inventory/ws_data.js";
import User from './models/User';
import * as Global from './global';



$(document).ready( function(){

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

/*ADDED SELECT2 PLUGIN*/
$.fn.select2.defaults.set("width", "auto");
$.fn.select2.defaults.set("dropdownAutoWidth", true);
if(elements.select2elements){
    elements.select2elements.select2();
}



elements.popupClose.addEventListener('click',() => {
    hideModal();
});

elements.pModalClose.addEventListener('click',()=>{
    closePModal();
});

 

    const ticketView_route  = new RegExp("\/tickets\/view\/\\d+",'gm');
    const ticketAdd_route  = new RegExp("\/tickets\/add",'gm');
    const AddDeptReport_route = new RegExp("\/view\/dept\/report", 'gm');
    const viewReported_route = new RegExp("\/reported\/issues\/view",'gm');
    const userProfile_route  = new RegExp("\/user\/profile\/\\d+",'gm');
    const tikcketPages_route  = new RegExp("\/tickets\/(open|my|ongoing|closed|all|fixed|expired)",'gm');
    const adminPage_route  = new RegExp("\/admin",'gm');
    const reportedTicket_route =  new RegExp("\/view\/reported\/ticket\/\\d+",'gm');
    const maintenancePage_route  = new RegExp("\/maintenance",'gm');
    const treasuryDashboard_route  = new RegExp("\/treasury/dashboard",'gm');
    const devprojs_route = new RegExp("\/show/devprojects",'gm');
    const storeVisit_route = new RegExp("\/technical/store-visit",'gm');
    const mdis_route =  new RegExp("\/show/mds",'gm'); 
    const incompleteTixRoute =  new RegExp("\/ticket/incomplete/\\d+",'gm');
    const inventoryRoute = new RegExp("\/inventory/ws",'gm');
    const pathName = window.location.pathname;
    switch (true){
        case ticketView_route.test(pathName):
            const user = new User();
            ticketViewController(user);
            break;
        case ticketAdd_route.test(pathName):
            elements.maintenanceCol.addEventListener('click',toggleFormGroups); /*EVENT LISTENER ON PLUS ICONS*/
            ticketAddController();
            break;
        case AddDeptReport_route.test(pathName):
            DepartReportAddController();
            break;
        case viewReported_route.test(pathName):
            DepartReportViewController();
            break;
        case userProfile_route.test(pathName):
            profileController();
            break;
        case tikcketPages_route.test(pathName):
            ticketPageController();
            break;
        case adminPage_route.test(pathName):
            adminPageController();
            break;
        case maintenancePage_route.test(pathName):
            maintenancePageController();
            break;
        case treasuryDashboard_route.test(pathName):
            treasuryDashboardController();
            break;
        case devprojs_route.test(pathName):
            devProjsController();
        break;
        case mdis_route.test(pathName):
            MasterDataController();
        break;
        case storeVisit_route.test(pathName):
            storeVisitController();
            break;
        case incompleteTixRoute.test(pathName):
            incompletePageController();
            break;
        case inventoryRoute.test(pathName):
            InventoryController(); 
            break;
        case reportedTicket_route.test(pathName):
            DepartReportAddController();
            break;
        default:
            console.log('route not set');
    }

});
