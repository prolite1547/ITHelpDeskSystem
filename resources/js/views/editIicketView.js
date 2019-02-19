import {
    clearLoader,
    elements,
    insertToModal,
    renderLoader,
    showModal
} from "./base";

import {exprtionSelect2} from '../select2';

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

};


export const addEventListenerToEditInputs = (ticket) => {
    const inputs = document.querySelectorAll('.ticket-details__select');

    inputs.forEach(el => {
        el.addEventListener('input',ticket.storeEditData.bind(ticket));
    });
};

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
};

export const getMessageMarkup = (e) => {
    let messageMarkup;
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
    }

    return messageMarkup;
};


export const displayContactNumbers = (e) => {
  e.preventDefault();
    showModal();
    renderLoader(elements.modalContent);
  let store_id = e.target.dataset.store;
  fetchContactDetails(store_id)
      .done(data => {
          clearLoader();
          insertToModal(data);

      });
};


function fetchContactDetails(store_id) {
    return $.ajax(`/modal/${store_id}/contacts`,{
        type: 'GET'
    }).fail(() => {
        alert('failed to get branch contacts');
    });
}

export const showRejectModal = (ticket_id,e) => {
    {
        e.preventDefault();
        e.target.disabled = true;
        showModal();
        renderLoader(elements.modalContent);
        getRejectForm(ticket_id)
            .then(response => {
                clearLoader();
                insertToModal(response.data);
            }).catch(() => {
                e.target.disabled = false;
                alert('Fail to Get Reject Form');
        });
    }
};

function getRejectForm(ticket_id) {
    return axios.get(`/modal/form/reject/${ticket_id}`);
}

export const showRejectDetails = (ticket_id) => {
        showModal();
        renderLoader(elements.modalContent);
    return axios.get(`/modal/lookup/reject/${ticket_id}`)
        .then(response => {
            clearLoader();
            insertToModal(response.data);
        }).catch(() => {
            alert('error getting the rejection details');
        });
};

export const showExtendFormModal = (ticket_id,e) => {
    e.preventDefault();
    showModal();
    renderLoader(elements.modalContent);

    $.ajax(`/modal/form/extend/${ticket_id}`,{
       type: 'GET'
    }).done(form => {
        clearLoader();
        insertToModal(form);
        $('.extend-form__duration').select2(exprtionSelect2);
    }).fail(() => {
        alert('fail to get extend form');
    });

};

/*show the extend details form*/
export const showExtndMdl = (ticket_id,e) => {
    e.preventDefault();
    showModal();
    renderLoader(elements.modalContent);

    $.ajax(`/modal/form/ticketExtendDetails/${ticket_id}`,{
        type: 'GET'
    }).done(detailsMarkup => {
        clearLoader();
        insertToModal(detailsMarkup);
    }).fail(() => {
        alert('fail to get extend form');
    });
};

export const showSelects = (e) => {
    const selectElement = e.target;

    if(selectElement.value){
        const option_group = selectElement.options[selectElement.selectedIndex].parentElement.getAttribute('label');

        if(option_group === 'Both'){
            elements.selectPID.classList.remove('u-display-n');
            elements.selectTel.classList.remove('u-display-n');
        }else if(option_group === 'Data'){
            elements.selectPID.classList.remove('u-display-n');
            elements.selectTel.classList.add('u-display-n');
        }else if(option_group === 'Voice'){
            elements.selectTel.classList.remove('u-display-n');
            elements.selectPID.classList.add('u-display-n');
        }else{
            elements.selectPID.classList.add('u-display-n');
            elements.selectTel.classList.add('u-display-n');
        }

    }else{
        elements.selectPID.classList.add('u-display-n');
        elements.selectTel.classList.add('u-display-n');
    }

};
