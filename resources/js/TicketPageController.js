import {elements,clearFormInputs} from "./views/base";
import * as datatableOption from './views/datatablesOptions';

export const ticketPageController = () => {
    let table;

    /*GET DATETABLE OPTION FOR INITIALIZATIONoptions*/
    table = datatableOption.initDataTables();

    elements.filterTicketsIcon.addEventListener('click', () => {
        elements.filterContent.classList.toggle('u-display-n');
    });

    elements.clearFilter.addEventListener('click',() => {
        clearFormInputs(elements.filterTicketForm);
        table.columns().search('').draw();

    });

    elements.filterTicketForm.addEventListener('submit', (e) => {

        /*CHECK FORM THROUGH HTML 5 VALIDATION */
       if(e.target.checkValidity()){
            e.preventDefault();
            let inputs = $(e.target).serializeArray();

            inputs.forEach((currentValue) => {
                table.column(currentValue['name']).search(currentValue['value']).draw();
            });
       }
    });

};
