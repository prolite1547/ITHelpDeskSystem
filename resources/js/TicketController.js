import {elements,elementStrings} from "./views/base";
import * as editTicketView from './views/editIicketView';
import Ticket from './models/Ticket';
import Message from './models/Message';
import {renderLoader,clearLoader,showModal,insertToModal,hideModal} from "./views/base";





////////////////////////////////
////////////////////////////////
////*ADD TICKET CONTROLLER*/////
////////////////////////////////
////////////////////////////////

if(elements.categoryInput){

elements.categoryInput.addEventListener('change',e => {

   let category ,date;
   category = e.target.options[e.target.selectedIndex].text.toLowerCase();

   switch (category) {
       case 'hardware':
            date = moment().add(3,'days').format('YYYY-MM-DD HH:mm:ss');
           break;
       case 'software':
            date = moment().add(7,'days').format('YYYY-MM-DD HH:mm:ss');
           break;
       default:
            date = moment().format();
   }

   const expirationInput = `<input name="expiration" value="${date}" hidden>`

    e.target.parentNode.insertAdjacentHTML('beforeend',expirationInput);


});
}

////////////////////////////////
////////////////////////////////
////*LOOK UP TICKET CONTROLLER*/////
////////////////////////////////
////////////////////////////////

if(window.location.pathname === '/tickets/view/2'){

const ticket = new Ticket(elements.ticketID,elements.ticketSubject,elements.ticketDetails);


/*ADD CLICK EVENT LISTENER */
elements.ticketContent.addEventListener('click', e => {


    /*IF USER CLICK THE EDIT INSIDE THE MORE*/
    if(e.target.matches(elementStrings.ticketContentEditIcon)){

        /*make elements editable*/
        editTicketView.makeElementsEditable();

        /*show save button*/
        editTicketView.showButtons();

    }


    /*IF USER CLICK THE BUTTONS CANCEL AND DONE*/
    if(e.target.matches('#contentEditSave')){

        /*PLACE DATA TO THE TICKET OBJECT*/
        ticket.storeContentEditTicket(elements.ticketSubject,elements.ticketDetails);

        /*XHR TO SAVE EDITED INPUTS*/
        ticket.saveEdit(ticket.detailsEditData).done(data => {
            if(data.success === true){
                editTicketView.makeElementsNotEditable();
                editTicketView.hideButtons();
                alert('Updated Successfully!');
            }else{
                alert('Failed to update...');
            }
        });
    }

    if(e.target.matches('#contentEditCancel')){
        /*GET LATEST DETAILS OF THE TICKET*/
        ticket.fetchOriginalData().done(() => {
            editTicketView.restoreElementsTextContent(ticket.originalData); /*RESTORE ORIGINAL INPUT VALUES*/
        });
        editTicketView.makeElementsNotEditable(); /*REMOVE THE EDITABLE MODE*/
        editTicketView.hideButtons(); /*HIDE THE CANCEL AND DONE BUTTONS*/
    }
});

/*EVENT LISTENER EDIT ICON CLICK*/
elements.ticketDetailsEditIcon.addEventListener('click',() => {

    ticket.createObjectForEditData(); /*CLEAR EDIT DATA*/


    showModal(); /*SHOW MODAL*/

    renderLoader(elements.modalContent); /*RENDER LOADER*/

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
    showModal(); /*SHOW MODAL*/
    insertToModal(editTicketView.addFileMarkup);

    const myDropzone = new Dropzone("#addFiles", {
        url: `/file/ticket/${ticket.ID}`,
        parallelUploads: 3,
        uploadMultiple: true,
        autoProcessQueue: false,
        addRemoveLinks: true,
        dictDefaultMessage: 'Drop files here to be uploaded'
    });

    myDropzone.on("complete", function(file) {
        myDropzone.removeAllFiles();
    });

    document.querySelector('.dropzone__upload').addEventListener('click',() => {
        myDropzone.processQueue();
    })

});

/*EVENT LISTENER ON CANCEL AND DONE BUTTON INSIDE TICKET DETAILS MODAL*/
elements.modal.addEventListener('click',e => {
    if(e.target.matches('button')){
        const action = e.target.dataset.action;
        if(action === 'cancel') {
            hideModal();
        }else if(action === 'confirm'){
            ticket.saveEdit(ticket.detailsEditData).done(data => {
                if(data.success === true){
                    alert('Updated Successfully!');
                    window.location.reload();
                }else{
                    alert('Failed to update...');
                }
            });

        }
    }else if(e.target.matches('.capsule__close')){

        const capsule  = e.target.closest('.capsule');

        const removedFile = capsule.parentNode.removeChild(capsule);

        const fileID = parseInt(removedFile.dataset.id);

        ticket.storeToBeDeletedFileID(fileID);
    }
});

elements.chatSendButton.addEventListener('click',function () {
    const newMessage = editTicketView.getMessageData()
        if(!newMessage){
            return alert(`What's the point of sending a message if its empty!! Message: ${newMessage}`);
        }
    editTicketView.resetReply();
    const newMessageObject = new Message(ticket.ID,newMessage);
    newMessageObject.saveMessage(newMessageObject);
});

}
