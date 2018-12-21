import {elements,showModal,insertToModal} from "./views/base";


export const adminPageController = () => {

    elements.addUserBtn.addEventListener('click', (e) => {
        e.preventDefault();


        $.ajax('/modal/form/userAdd',{
           type: 'GET'
        }).done(data => {
            showModal(data);
        });
    });


};
