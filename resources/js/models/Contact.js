export default class Contact {


    storeData(data){

        return $.ajax('/contact/save',{
            type: 'POST',
            data: data,
        })
    }
}
