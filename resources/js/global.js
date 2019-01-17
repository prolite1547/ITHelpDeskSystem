import {setDisable,displayError} from "./views/base";
import Caller from './models/Caller';
import Store from './models/Store';
import Contact from './models/Contact';
import PLDTMail from "./models/PLDTMail";
import Position from "./models/Position";
import Department from "./models/Department";

export const sendForm = (e) => {
    if(e.target.checkValidity()){
        e.preventDefault();

        let formdata,form,object,formSbmtBtn;
        form = e.target;
        formSbmtBtn = form.querySelector('button[data-action]');

        setDisable(formSbmtBtn);

        if(form.id === 'addCaller'){
            object =  new Caller();
        }else if(form.id === 'addBranch'){
            object = new Store();
        }else if(form.id === 'addContact'){
            object = new Contact();
        }else if(form.id === 'addPLDTIssue'){
            object = new PLDTMail();
        }else if(form.id === 'addPosition'){
            object = new Position();
        }else if(form.id === 'addDepartment'){
            object = new Department();
        }else {
            alert('form not found');
        }

        /*SERIALIZE FORM DATA*/
        formdata = $(form).serialize();

        if(object){
            object.storeData(formdata)
                .done(() => {
                        alert('Added Successfully!!');
                        form.reset();
                        setDisable(formSbmtBtn,false);
                })
                .fail((jqXHR) => {
                        setDisable(formSbmtBtn,false);
                        displayError(jqXHR);
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
