export default class Ticket {

    constructor(ID){
        this.ID = parseInt(this.extractNumber(ID.textContent).join([]));;
        this.ticket = this.fetchOriginalData();
        this.originalData = {};

    }

    extractNumber(string){
        const numberPattern = /\d+/g;

        return string.match(numberPattern);
    };



     getEditModal() {
        return $.ajax(`/modal/ticketEdit/${this.ID}`,{
             method:'GET',
             success: data => {
                 this.editModal = data;
             }
         });
    }

    saveEdit(data) {
         return $.ajax(`edit/${this.ID}`,{
           method:'PATCH',
           data: data,
        });

    }

    fetchOriginalData() {

        return $.ajax(`/ticket/${this.ID}`,{
            method:'GET',
            success: data => {
                this.ticket = data;
                this.originalData.subject = data.incident.subject;
                this.originalData.details = data.incident.details;
            }
        });

    }

    storeEditData(e) {
        const val  = e.target.value;
        const name = e.target.name;

        if(name in this.ticket){
            this.detailsEditData['ticket'][`${name}`] = val;
        }else if(name in this.ticket.incident){

            this.detailsEditData['incident'][`${name}`] = val;
        }

    }

    storeToBeDeletedFileID(id){
        this.detailsEditData.fileID.push(id);
    }

    storeContentEditTicket(subject,details){
        this.detailsEditData = {incident:{}};

        this.detailsEditData.incident.subject = subject.textContent;
        this.detailsEditData.incident.details = details.textContent;
    }

    createObjectForEditData() {
        this.detailsEditData = {
            incident: {},
            ticket: {},
            fileID: []
        }
    }
}
