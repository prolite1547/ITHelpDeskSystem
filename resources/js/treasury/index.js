import {posTickets} from "../views/datatablesOptions";

export const treasuryDashboardController = () => {
    $('.table--pos').dataTable(posTickets);
};
