import {clearLoader, elements, elementStrings, insertToModal, renderLoader, showModal} from "./base";

export const makeElementsEditable = () => {

    elements.ticketDetails.contentEditable = "true";
    elements.ticketSubject.contentEditable = "true";
    elements.ticketDetails.style.border = '1px solid #999';
    elements.ticketSubject.style.border = '1px solid #999';
    elements.ticketDetails.style.padding = '0 1rem';
    elements.ticketSubject.style.padding = '0 1rem';

};

export const makeElementsNotEditable = () => {

    elements.ticketDetails.contentEditable = "false";
    elements.ticketSubject.contentEditable = "false";
    elements.ticketDetails.style.border = 'none';
    elements.ticketSubject.style.border = 'none';
    elements.ticketDetails.style.padding = '';
    elements.ticketSubject.style.padding = '';
};


export const showButtons = () => {
    elements.updateButtonsContainer.style.display = 'block';
};


export const hideButtons = () => {
    elements.updateButtonsContainer.style.display = 'none';
};

export const restoreElementsTextContent = (ticket) => {
    elements.ticketDetails.textContent = ticket.details;
    elements.ticketSubject.textContent = ticket.subject;
};


export const getResolveFormMarkUp = (lookup = false,ticketID = 0) => {
    let ajax;

    if(!lookup){
         ajax = $.ajax('/modal/form/resolve',{
                    type: 'GET'
                });
    }else{
        ajax = $.ajax(`/modal/form/resolve/${ticketID}`,{
            type: 'GET'
        });
    }

    return ajax;

}


export const addEventListenerToEditInputs = (ticket) => {
    const inputs = document.querySelectorAll('.ticket-details__select');

    inputs.forEach(el => {
        el.addEventListener('input',ticket.storeEditData.bind(ticket));
    });
}

export const addFileMarkup = `<div class="dropzone" id="addFiles"><button type="button" class="dropzone__upload btn">Upload</button></div>`;

export const getMessageData = () => {
  return elements.reply.value;
};

export const resetReply = () => {
  elements.reply.value = "";
};

export const showResolveButton = () => {
    elements.resolveButton.classList.remove('u-display-n');

};

export const getModalWithData = (ticketID) => {
        showModal();
        renderLoader(elements.modalContent);
        getResolveFormMarkUp(true,ticketID)
            .done(data => {
                clearLoader();
                insertToModal(data);
            });
}

export const getMessageMarkup = (e) => {
    let messageMarkup;
    console.log(authUserID,e.userID);
    /*ADD CLOSE BUTTON IF THE RECIEVED MESSAGE IS EQUAL TO THE AUTHENTICATED USER*/
    if (authUserID === e.userID){
        messageMarkup = `<div class="message" data-id="${e.messageID}">
                                    <div class="message__img-box">
                                        <img src="/storage/profpic/${e.image}" alt="${e.user}" class="message__img">
                                    </div>
                                    <div class="message__content">
                                        <div class="message__message-box">
                                            <span class="message__close-icon">
                                            X
                                            </span>
                                            <div class="message__name">${e.user}</div>
                                            <div class="message__message">${e.message}</div>
                                        </div>
                                        <span class="message__time">${moment().fromNow()}</span>
                                    </div>
                                 </div>`;
    } else {
        messageMarkup = `<div class="message" data-id="${e.messageID}">
                                    <div class="message__img-box">
                                        <img src="/storage/profpic/${e.image}" alt="${e.user}" class="message__img">
                                    </div>
                                    <div class="message__content">
                                        <div class="message__message-box">
                                            <div class="message__name">${e.user}</div>
                                            <div class="message__message">${e.message}</div>
                                        </div>
                                        <span class="message__time">${moment().fromNow()}</span>
                                    </div>
                                 </div>`;
    };

    return messageMarkup;
};


