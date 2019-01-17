import {elements, elementStrings, toggleFormGroups} from "./views/base";
import * as glboalScript from "./global";
import {branchSelect2} from "./select2";

export const maintenancePageController = () => {
    $(elementStrings.branchSelectContact).on('select2:select', glboalScript.toggleHiddenGroup);
    elements.addContactForm.addEventListener('submit',glboalScript.sendForm);
    $('#contactBranchSelect').select2(branchSelect2);
    elements.maintenanceCol.addEventListener('click',toggleFormGroups); /*EVENT LISTENER ON PLUS ICONS*/
};
