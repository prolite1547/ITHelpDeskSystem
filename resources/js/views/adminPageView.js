import {elements,elementStrings, showModal,displayError,hideModal} from "./base";
import User from "./../models/User";
import {addData} from "../global";

export const showAddUserForm = () => {
    $.ajax('/modal/form/userAdd',{
        type: 'GET'
    }).done(data => {
        showModal(data);

        $(elementStrings.select2Elements).select2(); /*Initialize Select2 to all select elements*/

        document.getElementById(elementStrings.addUserFrom).querySelector('button[data-action=closeModal').addEventListener('click', () => {
           hideModal();
        });

        document.getElementById(elementStrings.addUserFrom).addEventListener('submit',e => {

            if (e.target.checkValidity()) {
                let user;
                e.preventDefault();

                let [token,fname,mname,lname,store,role,position,department] = $(e.target).serializeArray();

                user = new User;
                user.addUser(fname.value,mname.value,lname.value,store.value,role.value,position.value,department.value,token.value);

                addData('/user/add',user)
                    .done(() => {
                        alert('Added User Successfully');
                        e.target.reset();
                    })
                    .fail((jqXHR) => {
                        displayError(jqXHR);
                    })


            }
        });

    });
};

