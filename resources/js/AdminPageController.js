import {elements,showModal,insertToModal} from "./views/base";
import * as adminPageView from "./views/adminPageView"

export const adminPageController = () => {

    elements.addUserBtn.addEventListener('click', (e) => {
        e.preventDefault();

        /*SHOW ADD USER FORM MODAL*/
        adminPageView.showAddUserForm();

    });



};
