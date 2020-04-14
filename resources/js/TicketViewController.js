import {elements, elementStrings, displayError} from "./views/base";
import * as editTicketView from './views/editIicketView';
import * as addTicketView from './views/ticket_add';
import Ticket from './models/Ticket';
import Message from './models/Message';
import Fix from './models/Fix';
import {branchSelect2, cntctSelect2, deptSelect2, psitionSelect2,userSelect2} from "./select2";
import * as globalScript from './global';
import {renderLoader, clearLoader, showModal, insertToModal, hideModal,showPModal,closePModal,insertPModalContent} from "./views/base";
import ConnectionIssueReply from "./models/ConnectionIssueReply";
import {disableSubmitBtn} from "./global";
import {categoryADynamicCategoryBSelect, dynamicContactBranchSelect} from "./global";
import wsControllers from "./inventory/ws_controllers";


////////////////////////////////
////////////////////////////////
////*ADD TICKET CONTROLLER*/////
////////////////////////////////
////////////////////////////////

const emailSelect2Options = {
    placeholder: "",
    width: '100%',
    tokenSeparators: [',']
};

const contactsSelect2Options = {
    placeholder: "",
    width:  '100%',
    tokenSeparators: [',',]
};


 

export const ticketAddController = () => {
    /*INITIALIZE*/
    (function () {
        /*ADD THE ACTIVE CLASS TO THE INCIDENT ITEM*/
        // elements.incidentFormItem.classList.add(elementStrings.ticketAddFormActive);
        elements.incidentFormItem.classList.add(elementStrings.ticketAddFormActive);

        /*DISPLAY THE FORM*/
        addTicketView.displayForm();
        addTicketView.genUserGroup();
    })();

    categoryADynamicCategoryBSelect();
    // dynamicContactBranchSelect();

    $('#emailTo').select2(emailSelect2Options);
    $('#emailCc').select2(emailSelect2Options);
    $('#telnos').select2(contactsSelect2Options);
    $('#contactNums').select2(contactsSelect2Options);
    
    $('#callerBranchSelect,.branchSelect').select2(branchSelect2);
    elements.connBranchSelect.on('change', editTicketView.connBranchChanged);
    $('#ticketPositionSelect').select2(psitionSelect2);
    $('#positionDepSelect').select2(deptSelect2);
    $('#contact_id').select2(cntctSelect2);
    $('#assigneeSelect').select2();

    const userSelect = $('.userSelect');
    if(userSelect) {
        userSelect.select2(userSelect2);

        userSelect.on('change',() => {
            if(parseInt(userSelect.select2('data')[0].id) === 0) {
                addTicketView.showUserForm(true);
            }else {
                addTicketView.showUserForm(false);
            }
        });
    }



    /*DYNAMIC FORM*/
    document.querySelector('.window').addEventListener('click', e => {
        if (e.target.matches('.window__item')) {
            let items, item;
            items = e.target.parentNode.querySelectorAll('.window__item');
            item = e.target;

            /*REMOVE THE ACTIVE CLASS FROM THE ITEMS*/
            items.forEach(el => {
                el.classList.remove(elementStrings.ticketAddFormActive);
            });

            /*ADD THE ACTIVE CLASS TO THE CLICKED ITEM*/
            item.classList.add(elementStrings.ticketAddFormActive);

            /*DISPLAY THE FORM*/
            addTicketView.displayForm();
        }
    });

    /*ADD EVENT LISTENER ON ADD TICKET FORM*/
    elements.addTicketForm.addEventListener('submit', (e) => {
        if (e.target.checkValidity()) {
            e.preventDefault();
            e.target.classList.toggle('u-display-n');
            renderLoader(e.target.parentElement);

            $.ajax('/ticket/add', {
                type: 'POST',
                data: $(e.target).serialize()
            })
                .done((data) => {
                    elements.addTicketDetailsFormTicketEl.value = data.ticket_id;
                    elements.addTicketDetailsForm.classList.toggle('u-display-n');
                    clearLoader();
                })
                .fail(() => {
                    alert('Fail To Add Ticket;');
                    clearLoader();
                });
        }
    });


    $(elementStrings.depSelectpos).on('select2:select', globalScript.toggleHiddenGroup);


    // elements.addCallerForm.addEventListener('submit', sendForm.bind(this,elementStrings.addCallerSubmit));
    
    if(elements.windowMaintenance.childElementCount !== 0){
        elements.addPositionForm.addEventListener('submit', globalScript.sendForm);
        elements.addDepartmentForm.addEventListener('submit', globalScript.sendForm);
        elements.addBranchForm.addEventListener('submit', globalScript.sendForm);
    }
    
    elements.PLDTForm.addEventListener('submit', globalScript.sendForm);


    /*get concern element*/
    elements.selectConcern.on('change', editTicketView.showSelects);

    /* telco changed event */
    elements.telcoSelect.on('change', editTicketView.telcoSelectChanged);

    /* issue changed event */
    elements.issueSelect.on('change', editTicketView.issueTypeChanged);

    /* vpn category changed event */
    elements.vpnCategorySelect.on('change', editTicketView.generateVpn);
};

////////////////////////////////
////////////////////////////////
////*LOOK UP TICKET CONTROLLER*/////
////////////////////////////////
////////////////////////////////

export const ticketViewController = () => {
    const ticket = new Ticket(elements.ticketID, elements.ticketSubject, elements.ticketDetails);
    Echo.private(`chat.${ticket.ID}`)
        .listen('MessageSent', (e) => {
            document.querySelector('.thread').insertAdjacentHTML('afterbegin', editTicketView.getMessageMarkup(e));
        });
    ticket.fetchOriginalData()
        .done(data => {
            /*TICKET STATUS IS EQUAL TO FIX(4)*/
            if (data.status == 4 || data.status == 3) {
                document.querySelector('button[data-action=viewFixDtls').addEventListener('click', editTicketView.getModalWithData.bind(null, data));
            } else {

                /*ADD CLICK EVENT LISTENER */
                elements.ticketContent.addEventListener('click', e => {
                    /*IF USER CLICK THE EDIT INSIDE THE MORE*/
                    if (e.target.matches(elementStrings.ticketContentEditIcon)) {
                        /*make elements editable*/
                        editTicketView.makeElementsEditable();

                        /*show save button*/
                        editTicketView.showButtons();
                    }


                    /*IF USER CLICK THE BUTTONS CANCEL OR DONE*/
                    if (e.target.matches('#contentEditSave')) {

                        /*PLACE DATA TO THE TICKET OBJECT*/
                        ticket.storeContentEditTicket(elements.ticketSubject, elements.ticketDetails);

                        /*XHR TO SAVE EDITED INPUTS*/
                        ticket.saveEdit(ticket.detailsEditData).done(data => {
                            if (data.success === true) {
                                editTicketView.makeElementsNotEditable();
                                editTicketView.hideButtons();
                                alert('Updated Successfully!');
                            } else {
                                alert('Failed to update...');
                            }
                        }).fail((jqXHR) => {
                            displayError(jqXHR);
                        });
                    }

                    if (e.target.matches('#contentEditCancel')) {
                        /*GET LATEST DETAILS OF THE TICKET*/
                        ticket.fetchOriginalData().done(() => {
                            editTicketView.restoreElementsTextContent(ticket.originalData);
                            /*RESTORE ORIGINAL INPUT VALUES*/
                        });
                        editTicketView.makeElementsNotEditable();
                        /*REMOVE THE EDITABLE MODE*/
                        editTicketView.hideButtons();
                        /*HIDE THE CANCEL AND DONE BUTTONS*/
                    }
                });

                /*EVENT LISTENER EDIT ICON CLICK*/
                if (elements.ticketDetailsEditIcon) {
                    elements.ticketDetailsEditIcon.addEventListener('click', () => {
                        ticket.createObjectForEditData(); /*CLEAR EDIT DATA*/

                        showModal(); /*SHOW MODAL*/

                        renderLoader(elements.modalContent);  /*RENDER LOADER*`/

                        /*GET THE MARKUP FOR THE MODAL*/
                        ticket.getEditModal()
                            .done(data => {
                                clearLoader();
                                insertToModal(data);
                                // editTicketView.addEventListenerToEditInputs(ticket);
                                editTicketView.getAutoGroup();
                                editTicketView.addEventListenerToEditInputs(ticket);
                            })
                            .fail(error => {
                                console.log(`Error on making edit modal markup!! Error: ${error}`);
                            });
                    });
                    if (elements.ticketDetailsAddFilesIcon) {
                        elements.ticketDetailsAddFilesIcon.addEventListener('click', () => {
                            showModal();
                            /*SHOW MODAL*/
                            insertToModal(editTicketView.addFileMarkup);

                            const myDropzone = new Dropzone("#addFiles", {
                                url: `/file/ticket/${ticket.ID}`,
                                parallelUploads: 3,
                                uploadMultiple: true,
                                autoProcessQueue: false,
                                addRemoveLinks: true,
                                dictDefaultMessage: 'Drop files here to be uploaded'
                            });

                            myDropzone.on("complete", function () {
                                myDropzone.removeAllFiles();
                            });

                            document.querySelector('.dropzone__upload').addEventListener('click', () => {
                                if (myDropzone.files.length !== 0) {
                                    myDropzone.processQueue();
                                } else {
                                    return alert('No files found to be uploaded!!');
                                }
                            })

                        });
                    }
                    /*EVENT LISTENER ON CANCEL AND DONE BUTTON INSIDE TICKET DETAILS MODAL*/
                    elements.modal.addEventListener('click', e => {
                        if (e.target.matches('button')) {
                            const action = e.target.dataset.action;
                            if (action === 'cancel') {
                                hideModal();
                            } else if (action === 'confirm') {
                                ticket.detailsEditData['ticket']['group'] = $('#group').val();
                                // console.log(ticket);
                                ticket.saveEdit(ticket.detailsEditData).done(data => {
                                    if (data.success === true) {
                                        alert('Updated Successfully!');
                                        window.location.reload();
                                    } else {
                                        alert('Failed to update...');
                                    }
                                }).fail(data => {
                                    // alert('tae');
                                });

                            }
                        } else if (e.target.matches('.capsule__close')) {

                            const capsule = e.target.closest('.capsule');

                            const removedFile = capsule.parentNode.removeChild(capsule);

                            const fileID = parseInt(removedFile.dataset.id);

                            ticket.storeToBeDeletedFileID(fileID);
                        }
                    });
                }


                if (elements.fixBtn) {
                    /*CLICK EVENT LISTENER ON RESOLVE BUTTON*/
                    elements.fixBtn.addEventListener('click', (e) => {
                        e.preventDefault();
                        showModal();
                        renderLoader(elements.modalContent);

                        editTicketView.getFixFormMarkUp()
                        .done(data => {
                            clearLoader();
                            insertToModal(data);
                            document.querySelector(elementStrings.fix_form).addEventListener('submit', e => {
                                e.preventDefault();
                                const formdata = $(e.target).serialize();
                                const fix = new Fix(ticket.ID, formdata);
                                fix.createFix()
                                    .done((data) => {
                                       alert(data.result);
                                       if(data.able){
                                            window.location.reload();
                                            hideModal();
                                       }
                                    })
                                    .fail((jqXHR) => {
                                        displayError(jqXHR);
                                    });
                            });

                        });
                    });


                }




            }


            // /*EVENT LISTENER ON SEND BUTTON*/
            if (elements.chatForm) {

                const incident_type = data.issue.incident_type;
                /*generate input depending if its mail or call*/
                if(incident_type === "App\\ConnectionIssue"){
                    editTicketView.generateForm('reply');
                }else if(incident_type === "App\\Incident"){
                    editTicketView.generateForm('chat');
                }

                /*generate inputs whenever user clicks that chat or reply menu*/
                elements.chatForm.addEventListener('click',e => {
                    if(e.target.matches('li')){
                        const form = e.target.dataset.form;
                        editTicketView.generateForm(form);
                    }
                });

                /*refreshes the thread of replies*/
                elements.refreshBtn.addEventListener('click',(e) => {
                    const threadEl = e.target.parentElement;
                    const refreshBtn = e.target;
                    let issue_id = $(e.target).data('issue');
                    threadEl.innerHTML = "";
                    renderLoader(threadEl);
                    ticket.getRepliesfromMail(issue_id).done(data => {
                        ticket.getReplies()
                        .done(data => {
                            const replies = editTicketView.generateRepliesMarkup(data.data);
                            threadEl.innerHTML = replies;
                            threadEl.insertAdjacentElement('afterbegin',refreshBtn);
                        }).fail(() => {
                            alert('Failed to get replies!');
                    });
                    });
                  
                });

                elements.chatForm.addEventListener('submit', e => {
                    if (e.target.checkValidity()) {
                        e.preventDefault();
                        let promise,error;
                        const action = e.target.dataset.form;
                        const form_elements = e.target.elements;
                        const reply = form_elements.reply.value;
                        const submitBtn = form_elements.chat__button;
                        const original_text = submitBtn.value;
                        disableSubmitBtn(submitBtn);

                        if(action === 'chat'){
                            const message = new Message;
                            promise = message.saveMessage(ticket.ID,reply);

                        }else if(action === 'reply'){
                            let subject;
                            const formData = new FormData(e.target);

                            subject = `Re: ${data.issue.subject} (TID#${data.id})`;

                            formData.append('subject',subject);
                            promise = ConnectionIssueReply.sendMailReply(formData);
                        }else{
                            error = 'Error on sending data!'
                        }

                        if(!error){
                            promise.done(() => {
                                alert('Message Sent Successfully!');
                                disableSubmitBtn(submitBtn,original_text,false);
                                e.target.reset();
                            })
                            .fail((jqXHR) => {
                                disableSubmitBtn(submitBtn,original_text,false);
                                displayError(jqXHR);
                            });
                        }else{
                            alert(error);
                            disableSubmitBtn(submitBtn,original_text,false);
                        }
                    }
                });
            }

        });


    /*DELETE MESSAGE*/
    document.querySelector('.thread').addEventListener('click', e => {

        if (e.target.matches('.message__close-icon')) {
            let message, messageID;

            message = e.target.closest('.message');
            messageID = message.dataset.id;

            $.ajax(`/message/delete/${messageID}`, {
                type: 'delete'
            }).done(() => {
                e.target.parentNode.parentNode.parentNode.parentNode.removeChild(message);
            }).fail(() => {
                alert('Fail to delete message!');
            });
        }
    });

    if (elements.btnShwExtndDtails) {
        elements.btnShwExtndDtails.addEventListener('click', editTicketView.showExtndMdl.bind(null, ticket.ID));
    }


    /*EXTEND*/
    if (elements.extendFormBtn) elements.extendFormBtn.addEventListener('click', editTicketView.showExtendFormModal.bind(null, ticket.ID));

    elements.ticketDetailStore.addEventListener('click', editTicketView.displayContactNumbers);

    // if (elements. fixBtn) elements.fixBtn.addEventListener('click', ticket.markAsFixed.bind(ticket, user));

    if (elements.rejectDetailsBtn) elements.rejectDetailsBtn.addEventListener('click', editTicketView.showRejectDetails.bind(null, ticket.ID))

  if(elements.btnAddRelated){
    elements.btnAddRelated.addEventListener('click', function(){
        let id = $(this).data('rid');
        showModal();
        renderLoader(elements.modalContent);
        $.ajax({
                url : '/relate/'+id+'/ticket',
                type: 'GET',
                success : function(data){
                    clearLoader();
                       insertToModal(data);
                }
        });
    });
  }

  if(elements.btnShowAppStats){
    elements.btnShowAppStats.addEventListener('click',function(){
        showModal();
        renderLoader(elements.modalContent);
        let sdcid =  $(this).data('sdcid');
        $.ajax({
                url : '/show/'+sdcid+'/approverstats',
                type: 'GET',
                success : function(data){
                    clearLoader();
                       insertToModal(data.view);
                       $('#appstats_tbody').html(data.data);
                }
        });
    });
  }

  if(elements.vwrepairedItems){
      elements.vwrepairedItems.addEventListener('click', function(e){
        let tID = $(e.currentTarget).data('tid');
        let sID = $(e.currentTarget).data('sid');
        let modalAjax = wsControllers.getRepairedItemsContent(tID,sID);
        modalAjax.done((data)=>{
            showPModal();
            $(elements.headerPModalTitle).html("Repaired items");
            insertPModalContent(data);
            let cbws = $('#workstation_id');
            let cvitm = $('#item_description');
            cbWSAction(cbws,cvitm);
            getRepairedItems(tID)
        })
        .fail(()=>{

        })
      });
  }

  if(elements.vwcanvassForm){
      $(elements.vwcanvassForm).on('click', (e) => {
         let ticketId = $(e.currentTarget).data('tid');
         let storeId = $(e.currentTarget).data('sid');
         let tData = {id: ticketId};
            $.ajax('/show/canvass/form/'+ticketId,{
                type: "GET",
                data : tData
            }).done((data)=>{
                showPModal();
                $(elements.headerPModalTitle).html("Canvass form");
                insertPModalContent(data);
                getCanvassItems(ticketId, storeId);
                let frmCanvass = $('#frmPostCanvass');
                postCanvass(frmCanvass);
            }).fail(()=>{

            });
      });
  }

  function postCanvass(form){
        $(form).on('submit', (e)=>{
                e.preventDefault();
                let btnPost = $('#postCanvass');
                    btnPost.text("Posting Canvass");
                    btnPost.attr('disabled', true);
                // var frmData = $(e.target).serialize();
                var formData = new FormData(e.target);
                $.ajax('/post/canvass',{
                    type: "POST",
                    data : formData,
                    contentType: false,
                    cache: false,
                    processData: false
                }).done((data)=>{
                        // console.log(data); 
                        btnPost.text("Post Canvass");
                        btnPost.attr('disabled', false);
                        window.alert(data.result);
                        if(data.success == true){
                            closePModal();
                        }
                        
                }).fail((jqXHR)=>{
                    displayError(jqXHR);
                });
        });
  }



  function getRepairedItems(ticket_id){
    
    let addRepaired = document.querySelector('button[data-action=addtorepairlist]');
    let frmAdd = document.querySelector('#frmAddToList');
    var table = $('#itemrepaired-table').DataTable({
        dom: 'lrtip',
        processing: true,
        serverSide: true,
        order: [[0, 'asc']],
        "bPaginate": true,
        "sPaginationType": "full_numbers",
        ajax: '/get/repaired/'+ticket_id,
        columns: [
            { data: 'ws_description', name: 'ws_description' },
            { data: 'serial_no', name: 'serial_no' },
            { data: 'item_description', name: 'item_description' },
            { data: 'category', name: 'category' },
            { data: 'date_repaired', name: 'date_repaired'},
            { data: 'reason', name: 'reason'},
        ],

    });



    frmAdd.addEventListener('submit', (e) => {
        let cbItems = $('#item_description');
        e.preventDefault();
        let frmAddElements = e.target.elements;
        let txtSerialNo = frmAddElements.serial_no;
        let reqData = $(e.target).serialize();
        $.ajax('/add/tolist/repair',{
            type: 'POST',
            data : reqData,
        }).done(()=>{
            window.alert("Item successfully added to list");
            table.ajax.reload();
            frmAdd.reset();
            cbItems.empty();
            cbItems.append(new Option('(select item)','')).focus().blur();
        }).fail((error)=>{
           
        });
    });
   // table.ajax.reload();
     

  }

  function getCanvassItems(ticket_id, storeId){
   var c_table = $('#canvass-table').DataTable({
        dom: 'lrtip',
        processing: true,
        serverSide: true,
        order: [[0, 'asc']],
        "bPaginate": true,
        "sPaginationType": "full_numbers",
        ajax: '/get/canvass/data/'+ticket_id,
        columns: [
            { data: 'c_storename', name: 'c_storename' },
            { data: 'c_itemdesc', name: 'c_itemdesc' },
            { data: 'c_qty', name: 'c_qty' },
            { data: 'c_price', name: 'c_price' },
            { data: 'is_approved', name: 'is_approved'},
            { data: 'approval_type', name: 'approval_type'},
            { data: 'app_code', name: 'app_code'},
            { data: 'purchase_date', name: 'purchase_date'},
            { data: 'date_installed', name: 'date_installed'},
            { data: 'id', name: 'id' }
        ],
        columnDefs: [
            {targets: 9, orderable: false, render: (data)=>{
                return `<button title='Update item' data-id='${data}' data-action='update' class='btn btn--action'><i class='fa fa-pen'></i></button><button title='Delete item' data-id='${data}' data-action='delete' class='btn btn--action'><i class='fa fa-trash'></i></button>`;
            }},
            {targets: 4, orderable: false, render: (data,type,row)=> { 
                let ischecked = '';
                if(data != '0'){
                    ischecked =  "checked";
                }
                return `<input type='checkbox' class='chk_approved' name='is_approved${data}' ${ischecked} disabled='disabled' >`;
            }},
        ]
    });
    let posted_table = $('#canvass-table').data('posted');
    if(posted_table != '0'){
        c_table.column(9).visible(false);
    }else{
        btnAddNewItem(storeId,c_table);
    }
    // let btnRefresh = document.querySelector('button[data-action=refreshTable]');
    // btnRefresh.addEventListener('click', ()=>{ c_table.ajax.reload()});
    // $('#canvass-table tbody').css('cursor', 'pointer');
    
    $('#canvass-table tbody').on('click', 'tr', (e) => {
       
        if($(e.currentTarget).hasClass('selected')){
            $(e.currentTarget).removeClass('selected')
        }else{
            $('#canvass-table tr.selected').removeClass('selected');
            $(e.currentTarget).addClass('selected')
            // console.log(e.currentTarget);
        }
    });

     $('#canvass-table').on('click', '.btn--action', (e) =>{
          let action = $(e.currentTarget).data('action');
          let rowid = $(e.currentTarget).data('id');
          let url = "";
          if(action == "update"){
               url = `/show/update/citem/${rowid}/${storeId}`;
               $(elements.modal).css('z-index', '3');
               showModal();
               renderLoader(elements.modalContent);

            $.ajax(url,{
                type: 'GET',
                data : '',
                processData: false,
                contentType : false
            }).done((data)=>{
                  clearLoader();
                  insertToModal(data);
                  let wks = $('#wks_id');
                  let itms = $('#items');
                  cbWSAction(wks, itms);
                  let frmupdate = document.querySelector('#frmUpdateitem2Canvass');
                  approvalChkAction();
                  frmUpdateitem2Canvass(frmupdate, c_table);
                 
            }).fail((jqXHR)=>{
                displayError(jqXHR);
            });


          }else{
              url = `/delete/item/canvass/${rowid}`;
              $.ajax(url,{
                type: "DELETE"
              }).done((data)=>{
                    window.alert(data.result);
                    c_table.ajax.reload();
                    
              }).fail((jqXHR)=>{
                    displayError(jqXHR);
              });
          }
    
        
     });
    
}

function btnAddNewItem(storeId,table){
    let btnAdditem = document.querySelector('button[data-action=addNewcItem]');
    btnAdditem.addEventListener('click',(e)=>{
        let tid = $(e.currentTarget).data('tid');
        showModal();
        renderLoader(elements.modalContent);
        $(elements.modal).css('z-index', '3');
        $.ajax('/show/add/citem/'+storeId+'/'+tid,{
            type: 'GET',
            data: '',
            processData : false,
            contentType: false
        }).done((data)=>{
            clearLoader();
            insertToModal(data);
            let wks = $('#wks_id');
            let itms = $('#items');
            cbWSAction(wks, itms);
            let form = document.querySelector('#frmAdditem2Canvass');
            approvalChkAction();
            frmAdditem2Canvass(form, table);
        })
    });
}

  function getSerial(item_id){
        $.ajax('/get/serial_no', {
            type: "POST",
            data: { id: item_id},
        }).done((data)=> {
            $('#serial_no').val(data);
        }).fail((error)=>{
            $('#serial_no').val('');
        });
  }

  function frmAdditem2Canvass(form, table){
        form.addEventListener('submit',(e)=>{
            e.preventDefault();
            let frmElements = e.target.elements;
            let idata = $(e.target).serialize();
            $.ajax('/add/to/canvass',{
                type: 'POST',
                data: idata
            }).done((data)=>{
                window.alert(data.result);
                hideModal();
                table.ajax.reload();
            }).fail(()=>{

            });
 

        });
  }

  function frmUpdateitem2Canvass(form, table){
        form.addEventListener('submit', (e)=>{
            e.preventDefault();
            let frmData = $(e.target).serialize();
            $.ajax('/update/item/canvass',{
                type: 'POST',
                data: frmData,
            }).done((data)=>{
                window.alert(data.result);
                hideModal();
                table.ajax.reload();
            }).fail((jqXHR)=>{
                displayError(jqXHR);
            })
        });
  }

 

  function cbWSAction(cbWorkstation, cbItems){
    // let cbItems = $('#item_description');
        $(cbWorkstation).on('change', (e)=>{
            const ws_id = $(e.target).val();
            var url = "/get/item/ws/"+ws_id;
            $.ajax(url,{
                type: 'GET',
                data: '',
                processData: false,
                contentType: false
            }).done((data) => {
                cbItems.empty();
                cbItems.append(new Option('(select item)','')).focus().blur();
                $('#serial_no').val('');
                for(const item of data){
                    cbItems.append(new Option(item.item_description,item.id));
                }
            }).fail(()=>{
                cbItems.empty();
                cbItems.append(new Option('(select item)','')).focus().blur();
                $('#serial_no').val('');
            });
        });

        $(cbItems).on('change', (e)=>{
            var id = $(e.target).val();
            getSerial(id);
        });
  }

  function approvalChkAction(){
    let approval_chk = $('#approval_id');
    let appcode = $('#appcode');
    let is_approved = $('#is_approved');
    changePropchk(approval_chk, appcode);

    $(approval_chk).on('change', (e) => {
        changePropchk(e.target, appcode);
        if($(e.target).val() != ''){
            $(is_approved).val(1);
        }else{
            $(is_approved).val(0);
        }
    });
  }

  function changePropchk(approval_chk, appcode){
    if($(approval_chk).val() == '1'){
        $(appcode).prop('required',true);
    }else{
        $(appcode).prop('required',false);
    }
    if($(approval_chk).val() != ''){
        $(appcode).prop('disabled', false);
         
    }else{
        $(appcode).prop('disabled', true);
        $(appcode).val('');
    }
  }

 
  if(elements.emailsToCC_Telco != null){
  
    let currVal = elements.emailsToCC_Telco;
    $('#to-email').select2(emailSelect2Options);
    $('#cc-email').select2(emailSelect2Options); 
    getSelectAjaxData(`/get/emails/${currVal}`,  $('#to-email'), '', $('#to-email').data('emailto'));
    getSelectAjaxData(`/get/emails/${currVal}`,  $('#cc-email'), '', $('#cc-email').data('emailcc'));   
   
  }

  function getSelectAjaxData(url , element, placeholder, textVal){
    element.empty();
    element.append(new Option(placeholder, ''));
    let emails = textVal.split(",");
    $.ajax(url, {
        type: 'GET'
    }).done( data => {
        if(data != null){
            for(const el of data){
                    element.append(new Option(el.text, el.text));
            }
           if(textVal != null){
               element.val(emails).trigger('change');
           }
        }
    })
}

  


 
};
