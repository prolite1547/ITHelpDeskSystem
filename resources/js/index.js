import {elements, elementStrings, hideModal} from "./views/base";
import {ticketViewController,ticketAddController} from "./TicketViewController";
import {ticketPageController} from "./TicketPageController";
import {profileController} from "./ProfileController";
import {adminPageController} from  "./AdminPageController";

$(document).ready( function(){



$.extend( true, $.fn.dataTable.defaults, {
    searching: true,
    columnDefs: [
        {
            targets: -1, /*CHECKBOX*/
            render: () => {
                return `<div class='menu'>
                            <ul class='menu__list u-display-n'>
                                <li class='menu__item'><a href='#!' class='menu__link'>Print</a></li>
                                <li class='menu__item'><a href='#!' class='menu__link'>Delete</a></li>
                                <li class='menu__item'><a href='#!' class='menu__link'>Mark as resolved</a></li>
                           </ul>
                            <input type='checkbox' class='menu__checkbox'>
                        </div>`
            }
        },
        {
            targets: 2, /*CATEGORY*/
            render: (data) => {
                return `<span class='u-bold u-${data.toLowerCase()}'>${data}</span>`
            }
        },
        {
            targets: 0, /*SUBJECT*/
            createdCell: ( cell, cellData,rowData) => {
                cell.setAttribute('title',rowData.subject);
            },
            orderable: false,
            render: (data, type, row) => {
                return `<a href='/tickets/view/${data}' class='table__subject'>${row.subject}</a>
                <span class='table__info'>Ticket #: ${data}</span>
                <span class='table__info'>Category: ${row.category}</span>`
            }

        },
        {
            targets: 5, /*CREATED_AT COLUMN*/
            createdCell: ( cell, cellData) => {
                cell.setAttribute('title',cellData);
            },
            render: (data, type, row) => {
                return moment(data).fromNow();
            }

        },
        {
            targets: 6, /*EXPIRATION DATE COLUMN*/
            createdCell: ( cell, cellData) => {
                cell.setAttribute('title',cellData);
            },
            render: (data, type, row) => {
                let now;

                now = moment();

                if(now >= moment(data)){
                    return `<span class="expired">Expired</span>`;
                }else {
                    return moment(data).fromNow();
                }
            }

        }
    ],
    dom: 'lrtip',
    processing: true,
    serverSide: true,
    orderable: false,
    select:true,
    iDisplayLength: 6,
    aLengthMenu: [[6,10, 25, 50, -1], [6,10, 25, 50, "All"]],
    language: {
        processing: '<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>'
    }
} );


$.extend( $.fn.dataTable.ext.classes, {
    "sTable": "",
    "sNoFooter": "no-footer",

    /* Paging buttons */
    "sPageButton": "paginate_button",
    "sPageButton": "paginate_button",
    "sPageButtonActive": "current",
    "sPageButtonDisabled": "disabled",

    /* Striping classes */
    "sStripeOdd": "odd",
    "sStripeEven": "even",

    /* Empty row */
    "sRowEmpty": "dataTables_empty",

    /* Features */
    "sWrapper": "dataTables_wrapper",
    "sFilter": "dataTables_filter",
    "sInfo": "dataTables_info",
    "sPaging": "dataTables_paginate paging_", /* Note that the type is postfixed */
    "sLength": "dataTables_length",
    "sProcessing": "dataTables_processing",

    /* Sorting */
    "sSortAsc": "sorting_asc",
    "sSortDesc": "sorting_desc",
    "sSortable": "sorting", /* Sortable in both directions */
    "sSortableAsc": "sorting_asc_disabled",
    "sSortableDesc": "sorting_desc_disabled",
    "sSortableNone": "sorting_disabled",
    "sSortColumn": "sorting_", /* Note that an int is postfixed for the sorting order */

    /* Filtering */
    "sFilterInput": "",

    /* Page length */
    "sLengthSelect": "",

    /* Scrolling */
    "sScrollWrapper": "dataTables_scroll",
    "sScrollHead": "dataTables_scrollHead",
    "sScrollHeadInner": "dataTables_scrollHeadInner",
    "sScrollBody": "dataTables_scrollBody",
    "sScrollFoot": "dataTables_scrollFoot",
    "sScrollFootInner": "dataTables_scrollFootInner",

    /* Misc */
    "sHeaderTH": "",
    "sFooterTH": "",

    // Deprecated
    "sSortJUIAsc": "",
    "sSortJUIDesc": "",
    "sSortJUI": "",
    "sSortJUIAscAllowed": "",
    "sSortJUIDescAllowed": "",
    "sSortJUIWrapper": "",
    "sSortIcon": "",
    "sJUIHeader": "",
    "sJUIFooter": ""
} );


if(elements.table) {
    elements.table.addEventListener('click',e => {
        if(e.target.matches(elementStrings.ticketCheckbox)){

            //clear menu


            //show the menu
            e.target.closest('tr').classList.toggle('selected-row')
            console.log(e.target.parentNode.childNodes['1'].classList.toggle('u-display-n'));
        }
    });
};

/*ADDED SELECT2 PLUGIN*/
if(elements.select2elements){
  elements.select2elements.select2();
};



elements.popupClose.addEventListener('click',() => {
    hideModal();
});

    const ticketView_route  = new RegExp("\/tickets\/view\/\\d+",'gm');
    const ticketAdd_route  = new RegExp("\/tickets\/add",'gm');
    const userProfile_route  = new RegExp("\/user\/profile\/\\d+",'gm');
    const tikcketPages_route  = new RegExp("\/tickets\/(open|my|ongoing|closed|all)",'gm');
    const adminPage_route  = new RegExp("\/admin",'gm');
    const pathName = window.location.pathname;

    switch (true){
        case ticketView_route.test(pathName):
            ticketViewController();
            break;
        case ticketAdd_route.test(pathName):
            ticketAddController();
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
        default:
            console.log('route not set');
    }

});
