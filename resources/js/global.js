import {setDisable,displayError} from "./views/base";
import Caller from './models/Caller';
import Store from './models/Store';
import Contact from './models/Contact';
export const sendForm = (button,e) => {


    if(e.target.checkValidity()){
        e.preventDefault();

        let submitBtn,formdata,form,object;
        form = e.target;
        submitBtn = form.querySelector(button);

        setDisable(submitBtn);


        /*SERIALIZE FORM DATA*/
        formdata = $(form).serialize();

        if(form.id === 'addCaller'){
            object =  new Caller();
        }else if(form.id === 'addBranch'){
            object = new Store();
        }else if(form.id === 'addContact'){
            object = new Contact();
        }else {
            alert('form not found');
        }


        object.storeData(formdata)
            .done(data => {
                setTimeout(() => {
                    alert('Added Successfully!!');
                    form.reset();
                    setDisable(submitBtn,false);
                },2000)
            })
            .fail((jqXHR, textStatus) => {
                setTimeout(() => {
                    displayError(jqXHR);
                    setDisable(submitBtn,false);
                },2000)
            });
    }

};
