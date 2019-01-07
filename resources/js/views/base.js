export const elements = {
    table: document.querySelector('table'),
    select2elements: $('.form__input--select2'),
    editTicketButton: document.querySelector('.ticket-content__link--edit'),
    addTicketWindow: document.querySelector('.window__content'),
    ticketDetails: document.querySelector('p.ticket-content__details'),
    ticketSubject: document.querySelector('.ticket-content__subject'),
    updateButtonsContainer: document.querySelector('.ticket-content__updateBtns'),
    ticketContent: document.querySelector('.ticket-content'),
    ticketID: document.querySelector('.ticket-details__id'),
    modal: document.querySelector('.popup'),
    modalContent: document.querySelector('.popup__body'),
    container: document.querySelector('.container'),
    ticketDetailsEditIcon: document.querySelector('.ticket-details__icon--edit'),
    ticketDetailsAddFilesIcon: document.querySelector('.ticket-details__icon--add'),
    popupClose: document.querySelector('.popup__close'),
    chatSendButton: document.querySelector('.chat__button'),
    reply: document.querySelector('.chat__textarea'),
    categoryInput: document.querySelector('.form__input[name="category"]'),
    resolve: document.querySelector('.ticket-content__link--resolve'),
    profilePicEditIcon: document.getElementById('profImage'),
    ticketAddSubmitBtn: document.getElementById('ticketAdd'),
    addCallerForm: document.getElementById('addCaller'),
    addBranchForm: document.getElementById('addBranch'),
    addContactForm: document.getElementById('addContact'),
    addTicketForm: document.querySelector('.form-addTicket'),
    contactFormGroup: document.getElementById('contactFormGroup'),

    incidentFormItem: document.getElementById('incidentForm'),
    PLDTFormItem: document.getElementById('PLDTForm'),
    incidentFormContainerAdd: document.getElementById('incidentFormContainer'),
    PLDTFormContainerAdd: document.getElementById('PLDTFormContainer'),
    formItems: document.getElementsByClassName('window__item'),

    resolveButton: document.querySelector('button[data-action=viewRslveDtls'),
    chatForm: document.querySelector('.chat'),


    filterTicketsIcon:document.querySelector('#ticketFilter'),
    filterContent: document.querySelector('.filter'),
    filterTicketForm: document.querySelector('.form-ticketFilter'),
    clearFilter: document.querySelector('#clearFilter'),


    /*ADMIN PAGE*/
    addUserBtn: document.querySelector('[data-action=addUserBtn]'),
}


export const elementStrings = {
    ticketCheckbox: '.menu__checkbox',
    select2element: '.form__input--select2',
    loader2: 'loader2',
    ticketContentEditIcon: '.ticket-content__link--edit',
    resolve_form: '.form-resolve',
    addCallerSubmit: 'button[data-action=addCaller]',
    addBranchSubmit: 'button[data-action=addBranch]',
    addContactSubmit: 'button[data-action=addContact]',
    branchSelectContact: 'select[data-select=contact]',
    ticketAddBtn: '#ticketAdd',

    /*TICKET ADD*/
    ticketAddFormActive: 'window__item--active',

    /*ADMIN PAGE*/
    addUserFrom: 'addUser'
}


export const renderLoader = parent => {
    const loader = `
        <div class="${elementStrings.loader2}">
            <svg>
                <use href="/images/loader/icons.svg#icon-cw"></use>
            </svg>
        </div>
    `;
    parent.insertAdjacentHTML('afterbegin', loader);
};

export const clearLoader = () => {
    const loader = document.querySelector(`.${elementStrings.loader2}`);
    if (loader) loader.parentElement.removeChild(loader);
};

export const showModal= (markup = false) => {
    if(markup){
        elements.modalContent.innerHTML = markup;
    }else{
        elements.modalContent.innerHTML = "";
    }
    elements.container.style.filter = 'blur(1px)';
    elements.modal.style.visibility = 'visible';
    elements.modal.style.opacity = '1';
}

export const insertToModal = (markup) => {
    elements.modalContent.insertAdjacentHTML('beforeend',markup);
};

export const hideModal= () => {
    elements.container.style.filter = '';
    elements.modal.style.visibility = 'hidden';
    elements.modal.style.opacity = '0';
};

export const displayError = (jqXHR) => {
    let errorMessage = '';
    Object.entries(jqXHR.responseJSON.errors).forEach(([key, value]) => errorMessage+=value);
    alert(errorMessage);
};

export const setDisable = (el,bool = true) => {
      el.disabled = bool;
};

export const addUserMarkup = ``;
