export default class Message {

    constructor(ticketID,message){
        this.ticketID = ticketID;
        this.message = message;
    }

    saveMessage () {

        return $.ajax(`/message/new`,{
           method: 'POST',
           data: {message:this.message,ticket_id:this.ticketID}
        });
    }
}
