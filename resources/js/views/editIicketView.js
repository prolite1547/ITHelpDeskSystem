import {elements,elementStrings} from "./base";

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







export const addEventListenerToEditInputs = (ticket) => {
    const inputs = document.querySelectorAll('.ticket-details__select');

    inputs.forEach(el => {
        el.addEventListener('input',ticket.storeEditData.bind(ticket));
    });
}

export const addFileMarkup = `<div class="dropzone" id="addFiles"><button type="button" class="dropzone__upload btn">Upload</button></div>`;
