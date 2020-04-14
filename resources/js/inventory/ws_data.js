import {
    clearLoader,
    elements, elementStrings,
    insertToModal,
    renderLoader,
    showModal,
    hideModal,
    showPModal,
    closePModal,
    insertPModalContent,
    clearFormInputs
} from "../views/base";

import wsControllers from "./ws_controllers.js";
import {disableSubmitBtn} from "../global";

export const InventoryController = () => {

    let ws_table = $('#inv-table').DataTable({
        dom: 'lrtip',
        processing: true,
        serverSide: true,
        order: [[0, 'asc']],
        "bPaginate": true,
        "sPaginationType": "full_numbers",
        ajax: '/get/ws',
        columns: [
            { data: 'ws_description', name: 'ws_description' },
            { data: 'store_name', name: 'store_name' },
            { data: 'store_name', name: 'store_name' },
            { data: 'department', name: 'department' },
            { data: 'department', name: 'department' },
        ],
        columnDefs: [
            { 
              orderable: true, 
              targets: [0,1,2,3]
            },
            {
                targets: 1, /*ACTIONS*/
                orderable: false,
                render: (data, type, row) => {
                    return `<button data-action='view-details'  data-sbj='${row.ws_description}'   data-store='${row.store_name}' data-wid='${row.id}'   class='btn-edit btn btn--blue' title='View Details'>VIEW DETAILS</button>`
                }

           },
            {
                targets: 4, /*ACTIONS*/
                orderable: false,
                render: (data, type, row) => {
                   
                    return `<button data-action='edit' data-wid='${row.id}'   class='btn-edit btn btn--blue' title='Update Details'><i class='fa fa-pen'></i></button> 
                            <button data-action='delete' data-wid='${row.id}' class='btn-delete btn btn--red' title='Delete Report'><i class='fa fa-trash'></i></button>`
                }

           }

            
        ]
    });

    

$(elements.btnAddWs).on('click', ()=>{
    let modalAjax  = wsControllers.getModalContent();
    showModal();
    renderLoader(elements.modalContent);
    modalAjax.done((data)=>{
        clearLoader();
        insertToModal(data);
    })
    .fail(()=>{

    });
});

// VIEWING DETAILS
$('#inv-table').on('click', 'button[data-action=view-details]', (e) => {
   let wsData = {
        id : $(e.currentTarget).data('wid')
    };
    let modalAjax  = wsControllers.getModalCompoContent(wsData);
    let workstation = $(e.currentTarget).data("sbj");
    let store = $(e.currentTarget).data("store");
    // showModal();
    // renderLoader(elements.modalContent);
    modalAjax.done((data)=>{
        $(elements.headerPModalTitle).html(workstation + " | " + store);
        insertPModalContent(data);
        showPModal();
        // clearLoader();
        // insertToModal(data);
        getDatatable_button(e);
        
    })
    .fail(()=>{

    });
});

// EDIT SELECTED WORKSTATION
$('#inv-table').on('click', 'button[data-action=edit]', (e) => {
 
   
    let wid = $(e.currentTarget).data('wid');
    showModal();
    renderLoader(elements.modalContent);
    let modalUpdate = wsControllers.showWsUpdate(wid);

    modalUpdate.done((data)=>{
        clearLoader();
        insertToModal(data);
    })
    .fail(()=>{

    });
});


// DELETING SELECTED WORKSTATION
$('#inv-table').on('click', 'button[data-action=delete]', (e) => {
    let wid = $(e.currentTarget).data('wid');
    $.ajax(`/delete/ws/${wid}`, {
        type: 'delete'
    }).done(() => {
        window.alert("Workstation has been successfully deleted");
        window.location.reload();
    }).fail(() => {
        alert('Fail to delete workstation!');
    });
});

 elements.filterWorkstations.addEventListener('submit', (e)=>{
    e.preventDefault();
   let inputs = $(e.target).serializeArray(); 
    inputs.forEach((curreElement) => {
        ws_table.column(curreElement["name"]).search(curreElement["value"], true).draw();
    });
 });

 elements.clearFilter.addEventListener('click',() => {
    clearFormInputs(elements.filterWorkstations);
    ws_table.columns().search('').draw();

});



function getDatatable_button(e){
    let wid = $(e.currentTarget).data('wid');
        let item_table = $('#item-table').DataTable({
            dom: 'lrtip',
            processing: true,
            serverSide: true,
            order: [[0, 'asc']],
            "bPaginate": true,
            "sPaginationType": "full_numbers",
            ajax: '/get/items/'+wid,
            columns : [
                { data: 'serial_no', name: 'serial_no' },
                { data: 'item_description', name: 'item_description' },
                { data: 'item_category', name: 'item_category' },
                { data: 'no_repaired', name: 'no_repaired' },
                { data: 'no_replace', name: 'no_replace' },
                { data: 'date_used', name: 'date_used' },
                { data: 'updated_at', name: 'updated_at' },
            ],
        });

    $('#addNewItem').on('click', ()=>{
         let iData = {id : wid};
         let modalAjax = new wsControllers.getModalAddItemContent(iData);
        //  closePModal();
         $(elements.modal).css('z-index', '3');
         showModal();
         renderLoader(elements.modalContent);
         modalAjax.done((data)=>{
            clearLoader();
            insertToModal(data);
            let frmAddItemWs = document.querySelector('#frmAddItemWs');
           
            frmAddItemWs.addEventListener('submit', (e) => {
                e.preventDefault();
                const frmElements = e.target.elements;
                const submitBtn =   frmElements.addWsItem;
                $(submitBtn).text('Sending data..');
                $(submitBtn).attr('disabled', true);
                let reqData = $(e.target).serialize();
                let addAjax = wsControllers.addItemWS(reqData);
                
                addAjax.done((data)=>{
                    $(submitBtn).attr('disabled', false);
                    $(submitBtn).text('SUBMIT');
                    window.alert("Item has been successfully added");
                    hideModal();
                    item_table.ajax.reload();
                })
                .fail(()=>{

                });
            });
         })
         .fail(()=>{

         });
    });
}





}