import {elements,elementStrings} from "./views/base";

$.extend( true, $.fn.dataTable.defaults, {
    searching: false,
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

elements.table.addEventListener('click',e => {
  if(e.target.matches(elementStrings.ticketCheckbox)){

      //clear menu


      //show the menu
      e.target.closest('tr').classList.toggle('selected-row')
      console.log(e.target.parentNode.childNodes['1'].classList.toggle('u-display-n'));
  }
});
