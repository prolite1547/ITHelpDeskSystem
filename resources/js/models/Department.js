export default class Department {
    storeData(data){
        return $.ajax('/add/department',{
           type: 'POST',
           data: data
        });
    }
}
