import {setDisable, displayError, showModal, renderLoader, elements, clearLoader, hideModal, elementStrings} from "./views/base";
import Caller from './models/Caller';
import Store from './models/Store';
import Contact from './models/Contact';
import ContactPerson from './models/ContactPerson';
import ConnectionIssue from "./models/ConnectionIssue";
import Position from "./models/Position";
import Department from "./models/Department";
import Pid from "./models/Pid";
import StoreVisitTarget from "./models/StoreVisitTarget";
import StoreVisitDetail from "./models/StoreVisitDetail";
import {reloadTable} from "./views/storeVisit";
import * as addTicketView from './views/ticket_add';


export const sendForm = (e) => {
    if(e.target.checkValidity()){
        e.preventDefault();

        let formdata,form,object,formSbmtBtn;
        form = e.target;
        formSbmtBtn = form.querySelector('button[data-action]');

        setDisable(formSbmtBtn);

        /*SERIALIZE FORM DATA*/
        formdata = $(form).serialize();

        switch (form.id) {
            case 'addCaller':
                object =  new Caller();
                break;
            case 'addBranch':
                object = new Store();
                break;
            case 'addContact':
                object = new Contact();
                break;
            case 'addPLDTIssue':
                showModal(false,false);
                renderLoader(elements.modalContent);
                object = new ConnectionIssue();
                formdata = new FormData(form);
                break;
            case 'addPosition':
                object = new Position();
                break;
            case 'addDepartment':
                object = new Department();
                break;
            case 'addStoreVisitTarget':
                object = new StoreVisitTarget();
                break;
            case 'addStoreVisitDetail':
                object = new StoreVisitDetail();
                break;
            case 'addContactPerson':
                object = new ContactPerson();
                break;
            case 'addPid':
                object = new Pid();
                break;
            default:
                alert('form not found');
        }

        if(object){
            object.storeData(formdata)
                .done((data) => {
                        alert('Added Successfully!!');
                        console.log(data);
                        clearLoader();
                        hideModal();
                        form.reset();
                        $(elementStrings.select2element).val('').trigger('change');
                        setDisable(formSbmtBtn,false);
                        responseHandler(data);
                })
                .fail((jqXHR,textStatus,errorThrown) => {
                        clearLoader();
                        hideModal();
                        setDisable(formSbmtBtn,false);
                        if(jqXHR){
                          displayError(jqXHR);
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
       try{
         hiddenGroup.classList.toggle('u-display-n');
       }catch(err){
           
       }
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


function responseHandler(data){
    switch (data.response) {
        case 'emailConIssueSentSuccess':
            window.location = `/tickets/view/${data.data.ticket_id}`;
        break;
        case 'storeVisitTarget':
            data.success === true ? reloadTable('targetTable') : false;
        break;
        case 'storeVisitDetails':
            data.success === true ? reloadTable('detailsTable') : false;
            break;
        default:
            console.log('response not found!');
    }
}

export const categoryADynamicCategoryBSelect = () => {
    elements.categoryASelect.on('change',(e) => {
        const catAID = $(e.target).val();

        elements.categoryBSelect.empty().trigger('change');
        elements.categoryBSelect.select2({
            placeholder : '(select sub-B)'
        });
        elements.categoryBSelect.select2('data', null);
        $.ajax(`/categoryA/${catAID}/subBCategories`,{
            type: 'GET'
        }).done(subBArray => {
            for(const subB of subBArray) {
                // Create a DOM Option and pre-select by default
                // Append it to the select
                elements.categoryBSelect.append(new Option(subB.name, subB.id)).trigger('change');
            }
        }).fail(() => {
            alert('failed to get sub B categories!!');
        });
    });
};

export const dynamicContactBranchSelect = () => {
    elements.ticketBranchSelect.on('change', (e)=> {
         let branchId =  $(e.target).val();
          elements.contactBranchSelect.empty().trigger('change');
          elements.contactBranchSelect.select2({
              placeholder: '(contact)'
          });
         
          $.ajax(`/get/contactBranch/${branchId}`, {
              type: 'GET'
          }).done( contactData => {
               for(const contact of contactData.data ){
                   let display = contact.text + " ("+ contact.position+")"
                   elements.contactBranchSelect.append( new Option(display, contact.id)).trigger('change');
               }
               elements.contactBranchSelect.append( new Option('Others', 0)).trigger('change');
          }).fail(() => {
              alert("failed to get contacts from this branch")
          });
    });


    elements.contactBranchSelect.on('change', ()=> {

       let id =  elements.contactBranchSelect.val();
       
        if( parseInt(id) === 0) {
            addTicketView.showUserForm(true);
        }else {
            addTicketView.showUserForm(false);
        }
    });
}
