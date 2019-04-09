import {posTickets} from "../views/datatablesOptions";
import {elements, showModal} from "../views/base";
import * as editTicketView from "../views/editIicketView";

export const treasuryDashboardController = () => {
    $('.table--pos').dataTable(posTickets);

    $('.table--pos').on('click','.table__subject',(e) => {
        const ticket_id = e.currentTarget.dataset.id;
        $.ajax(`/tickets/view/${ticket_id}`,{
           type: 'GET'
        }).done(data => {
            showModal(data);
            $('.treasury-lookup').on('click','button[data-action=viewFixDtls]',()=>editTicketView.getModalWithData.bind(null, data));
        }).fail(() => alert('failed to get treasury ticket lookup data!'));
    });



};
