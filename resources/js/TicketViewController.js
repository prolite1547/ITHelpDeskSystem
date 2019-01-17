import {elements,elementStrings,displayError,toggleFormGroups} from "./views/base";
import * as editTicketView from './views/editIicketView';
import * as addTicketView from './views/ticket_add';
import Ticket from './models/Ticket';
import Message from './models/Message';
import Resolve from './models/Resolve';
import {branchSelect2, cntctSelect2, deptSelect2, psitionSelect2} from "./select2";
import * as glboalScript from './global';
import {renderLoader,clearLoader,showModal,insertToModal,hideModal} from "./views/base";





////////////////////////////////
////////////////////////////////
////*ADD TICKET CONTROLLER*/////
////////////////////////////////
////////////////////////////////

export const ticketAddController = () => {

    /*INITIALIZE*/
    (function(){

        /*ADD THE ACTIVE CLASS TO THE INCIDENT ITEM*/
        // elements.incidentFormItem.classList.add(elementStrings.ticketAddFormActive);
        elements.incidentFormItem.classList.add(elementStrings.ticketAddFormActive);

        /*DISPLAY THE FORM*/
        addTicketView.displayForm();
    })();

    $('#callerBranchSelect,#contactBranchSelect,#ticketBranchSelect').select2(branchSelect2);

    $('#ticketPositionSelect').select2(psitionSelect2);

    $('#positionDepSelect').select2(deptSelect2);

    $('#contact_id').select2(cntctSelect2);

    $('#assigneeSelect').select2({
        width: '30%',
    });

    /*DYNAMIC FORM*/
    document.querySelector('.window').addEventListener('click',e => {
       if(e.target.matches('.window__item')){
           let items,item;
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
    elements.addTicketForm.addEventListener('submit',(e) => {
        if(e.target.checkValidity()){
            e.preventDefault();
            e.target.classList.toggle('u-display-n');
            renderLoader(e.target.parentElement);

            $.ajax('/ticket/add',{
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


    $(elementStrings.depSelectpos).on('select2:select', glboalScript.toggleHiddenGroup);


    // elements.addCallerForm.addEventListener('submit', sendForm.bind(this,elementStrings.addCallerSubmit));
    elements.addPositionForm.addEventListener('submit', glboalScript.sendForm);
    elements.addDepartmentForm.addEventListener('submit', glboalScript.sendForm);
    elements.addBranchForm.addEventListener('submit', glboalScript.sendForm);
    elements.PLDTForm.addEventListener('submit',glboalScript.sendForm);
};

////////////////////////////////
////////////////////////////////
////*LOOK UP TICKET CONTROLLER*/////
////////////////////////////////
////////////////////////////////

export const ticketViewController = (user) => {
    const ticket = new Ticket(elements.ticketID,elements.ticketSubject,elements.ticketDetails);

    Echo.private(`chat.${ticket.ID}`)
        .listen('MessageSent', (e) => {
            document.querySelector('.thread').insertAdjacentHTML('afterbegin', editTicketView.getMessageMarkup(e));
        });

    ticket.fetchOriginalData()
        .done(data => {
            /*TICKET STATUS ID 3 IS == TO CLOSES*/
            if(data.status === 3){
                elements.resolveButton.addEventListener('click', editTicketView.getModalWithData.bind(this,data.id));

            }else {

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
                if(elements.ticketDetailsEditIcon){
                    elements.ticketDetailsEditIcon.addEventListener('click', () => {
                        ticket.createObjectForEditData(); /*CLEAR EDIT DATA*/

                        showModal(); /*SHOW MODAL*/

                        renderLoader(elements.modalContent);  /*RENDER LOADER*`/

                        /*GET THE MARKUP FOR THE MODAL*/
                        ticket.getEditModal()
                            .done(data => {
                                clearLoader();
                                insertToModal(data);
                                editTicketView.addEventListenerToEditInputs(ticket);
                            })
                            .fail(error => {
                                console.log(`Error on making edit modal markup!! Error: ${error}`);
                            });
                    });

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

                    /*EVENT LISTENER ON CANCEL AND DONE BUTTON INSIDE TICKET DETAILS MODAL*/
                    elements.modal.addEventListener('click', e => {
                        if (e.target.matches('button')) {
                            const action = e.target.dataset.action;
                            if (action === 'cancel') {
                                hideModal();
                            } else if (action === 'confirm') {
                                ticket.saveEdit(ticket.detailsEditData).done(data => {
                                    if (data.success === true) {
                                        alert('Updated Successfully!');
                                        window.location.reload();
                                    } else {
                                        alert('Failed to update...');
                                    }
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


                if (elements.resolve){
                /*CLICK EVENT LISTENER ON RESOLVE BUTTON*/
                    elements.resolve.addEventListener('click', (e) => {
                        e.preventDefault();
                        showModal();
                        renderLoader(elements.modalContent);
                        const resolveRequest = editTicketView.getResolveFormMarkUp();
                        resolveRequest.done(data => {
                            clearLoader();
                            insertToModal(data);

                            document.querySelector('button[data-action=resolved]').addEventListener('click', () => {

                                document.querySelector(elementStrings.resolve_form).addEventListener('submit', e => {
                                    e.preventDefault();
                                });

                                const formdata = $(elementStrings.resolve_form).serialize();

                                let resolve = new Resolve(ticket.ID, formdata);

                                resolve.createResolve()
                                    .done(() => {
                                        alert('Ticket marked as resolved successfully!!');
                                        window.location.reload();
                                        hideModal();
                                    })
                                    .fail((jqXHR) => {
                                        displayError(jqXHR);
                                    });
                            });
                        });
                    });


                }

                if(elements.reject){
                    elements.reject.addEventListener('click', editTicketView.showRejectModal.bind(null,ticket.ID));
                }


            }
        });



    // /*EVENT LISTENER ON SEND BUTTON*/
    elements.chatForm.addEventListener('submit', e => {
        if (e.target.checkValidity()) {
            e.preventDefault();
            const newMessage = editTicketView.getMessageData();
            if (!newMessage) {
                return alert(`What's the point of sending a message if its empty!! Message: ${newMessage}`);
            }
            editTicketView.resetReply();
            const newMessageObject = new Message(ticket.ID, newMessage);
            newMessageObject.saveMessage(newMessageObject)
                .done(() => {
                    alert('Message Sent Successfull!')
                })
                .fail((jqXHR) => {
                    displayError(jqXHR);
                    });
        }
    });


    /*DELETE MESSAGE*/
    document.querySelector('.thread').addEventListener('click', e => {

        if(e.target.matches('.message__close-icon')){
            let message,messageID;

            message = e.target.closest('.message');
            messageID = message.dataset.id;

            $.ajax(`/message/delete/${messageID}`,{
               type: 'delete'
            }).done(() => {
                e.target.parentNode.parentNode.parentNode.parentNode.removeChild(message);
            }).fail(() => {
                alert('Fail to delete message!');
            });
        }
    });

    elements.ticketDetailStore.addEventListener('click',editTicketView.displayContactNumbers);

    if(elements.fixBtn) elements.fixBtn.addEventListener('click',ticket.markAsFixed.bind(ticket,user));

    if(elements.rejectDetailsBtn) elements.rejectDetailsBtn.addEventListener('click',editTicketView.showRejectDetails.bind(null,ticket.ID))
};
