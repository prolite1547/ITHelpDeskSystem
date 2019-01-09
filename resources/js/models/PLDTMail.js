export default class PLDTMail {
    storeData(data){

        return $.ajax('/ticket/pldt/add',{
            type: 'POST',
            data: data,
        })
    }
}
