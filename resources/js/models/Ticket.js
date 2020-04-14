export default class Ticket {

    constructor(ID){
        this.ID = parseInt(this.extractNumber(ID.textContent).join([]));;
        this.fetchOriginalData();
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
         return $.ajax(`/ticket/edit/${this.ID}`,{
           method:'PATCH',
           data: data,
        });
    }

    fetchOriginalData() {

        return $.ajax(`/ticket/${this.ID}`,{
            method:'GET',
            success: data => {
                this.originalData.subject = data.issue.subject;
                this.originalData.details = data.issue.details;
                this.data = data;
            }
        });

    }

    storeEditData(e) {
        const val  = e.target.value;
        const name = e.target.name;

        if(name in this.data){
            this.detailsEditData['ticket'][`${name}`] = val;
        }else if(name in this.data.issue){
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

    markAsFixed(user,e){
        e.preventDefault();
         $.ajax(`/tickets/status/fixed/${this.ID}`,{
             type: 'PATCH',
             data: {fixed_by: user.id}
         }).done(() => {
             window.location.reload();
         });
    }

    getReplies(){
        return $.ajax(`/api/connIssReply/${this.ID}`,{
            type: 'GET'
        })
    }

    getRepliesfromMail(id){
        return $.ajax(`/get/replyfrommail/${id}`, {
            type : 'GET'
        });
    }
}
