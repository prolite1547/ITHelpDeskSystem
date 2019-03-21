export default class Message {

    saveMessage (ticket_id,message) {

        return $.ajax(`/message/new`,{
           method: 'POST',
           data: {message:message,ticket_id:ticket_id}
        });
    }
}
