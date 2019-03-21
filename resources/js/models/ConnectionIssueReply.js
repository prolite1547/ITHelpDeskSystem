export default class ConnectionIssueReply {

    static sendMailReply(data){
        return $.ajax('/reply/support',{
            type: 'POST',
            data,
            processData: false,
            contentType: false
        })
    }
}
