import * as ticketTablesView from  './views/ticketTablesPage.js';

export const ticketPageController = () => {

    /*SET DEFAULT CONFIG FOR DATATABLES*/
    ticketTablesView.setDataTablesConf();

    /*TOGGLE SUBMENU ON CHECKBOX*/
    ticketTablesView.checkBoxListen();

    /*THIS IS WHERE THE FILTER FUNCTIONALITY LIVES*/
    ticketTablesView.filterFunction();

};
