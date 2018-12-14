import {elementStrings,elements} from "./views/base";


elements.filterTicketsIcon.addEventListener('click', () => {
    elements.filterContent.classList.toggle('u-display-n');
});


elements.filterTicketForm.addEventListener('submit', (e) => {
   if(e.target.checkValidity()){
       alert('tae');
        e.preventDefault();
   }
});
