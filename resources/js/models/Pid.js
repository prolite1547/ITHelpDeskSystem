export default class Pid{

    storeData(data){
        return $.ajax('/add/pid',{
            type: 'POST',
            data: data,
        })
    }

}