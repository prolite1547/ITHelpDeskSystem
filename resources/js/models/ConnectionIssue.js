export default class ConnectionIssue {


     storeData(data){
        return $.ajax('/ticket/pldt/add',{
            type: 'POST',
            data: data,
            processData: false,
            contentType: false,
        })
    }


}
