import {elementStrings,elements} from "./views/base";
import * as datatableOption from './views/datatablesOptions';

export const ticketPageController = () => {
    let table;

    /*GET DATETABLE OPTION FOR INITIALIZATIONoptions*/
    table = datatableOption.initDataTables();



    elements.filterTicketsIcon.addEventListener('click', () => {
        elements.filterContent.classList.toggle('u-display-n');
    });


    elements.filterTicketForm.addEventListener('submit', (e) => {

        /*CHECK FORM THROUGH HTML 5 VALIDATION */
       if(e.target.checkValidity()){
           let filterFormData,category,catOptions,categorySelectElement;

            e.preventDefault();
            let inputs = $(e.target).serializeArray();

            inputs.forEach((currentValue) => {
                table.column(currentValue['name']).search(currentValue['value']).draw();
            });


            // categorySelectElement = e.target.querySelector('select');
            // catOptions = categorySelectElement.options;
            // category = catOptions[catOptions.selectedIndex].text;



       }
    });

};
