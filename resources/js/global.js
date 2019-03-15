import {setDisable, displayError, showModal, renderLoader, elements, clearLoader, hideModal} from "./views/base";
import Caller from './models/Caller';
import Store from './models/Store';
import Contact from './models/Contact';
import ConnectionIssue from "./models/ConnectionIssue";
import Position from "./models/Position";
import Department from "./models/Department";
import ConnectionIssueReply from "./models/ConnectionIssueReply";
import Ticket from "./models/Ticket";

export const sendForm = (e) => {
    if(e.target.checkValidity()){
        e.preventDefault();

        let formdata,form,object,formSbmtBtn;
        form = e.target;
        formSbmtBtn = form.querySelector('button[data-action]');

        setDisable(formSbmtBtn);

        /*SERIALIZE FORM DATA*/
        formdata = $(form).serialize();

        if(form.id === 'addCaller'){
            object =  new Caller();
        }else if(form.id === 'addBranch'){
            object = new Store();
        }else if(form.id === 'addContact'){
            object = new Contact();
        }else if(form.id === 'addPLDTIssue'){
            showModal(false,false);
            renderLoader(elements.modalContent);
            object = new ConnectionIssue();
            formdata = new FormData(form);
        }else if(form.id === 'addPosition'){
            object = new Position();
        }else if(form.id === 'addDepartment'){
            object = new Department();
        }else {
            alert('form not found');
        }


        if(object){
            object.storeData(formdata)
                .done((data) => {
                        alert('Added Successfully!!');
                        clearLoader();
                        hideModal();
                        form.reset();
                        setDisable(formSbmtBtn,false);

                        if(data.response){
                            if(data.response === 'emailConIssueSentSuccess'){
                                window.location = `/tickets/view/${data.data.ticket_id}`;
                            }
                        }
                })
                .fail((jqXHR,textStatus,errorThrown) => {
                        clearLoader();
                        hideModal();
                        setDisable(formSbmtBtn,false);
                        if(jqXHR){
                            displayError(jqXHR)
                        }else if(errorThrown) {
                            alert(errorThrown);
                        }else if(textStatus){
                            alert(textStatus);
                        }else{
                            alert('Unable to process the request!')
                        }
                });
        }
    }

};

export const addData = (url,data) => {

    return $.ajax(url,{
        type: 'POST',
        data: data
    });

};

export const toggleHiddenGroup = (e) => {
    let data,form,hiddenGroup;
    data = e.params.data;
    form = e.delegateTarget.form;
    hiddenGroup = form.querySelector('.u-display-n');
    if(data.id !== ""){
        // addTicketView.showContactFormGroup();
        hiddenGroup.classList.toggle('u-display-n');
    }else{
        // addTicketView.hideContactFormGroup();
    }
};


export const disableSubmitBtn = (btn,text = '',disable = true) => {

    if(disable === true){
        btn.value = 'Please Wait...';
        btn.disabled = true;
    }else{
        btn.value = text;
        btn.disabled = false;
    }

};


export const disableInputElements = (nodeList,disable) => {
    for (let input of nodeList) input.disabled = disable;
};
