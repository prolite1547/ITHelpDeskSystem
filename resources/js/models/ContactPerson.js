export default class ContactPerson {
    storeData(data){
        return $.ajax('/contact_person/add',{
            type: 'POST',
            data: data,
        })
    }
}