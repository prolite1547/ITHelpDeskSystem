export default class Caller {


    storeData(data){

        return $.ajax('/caller/save',{
            type: 'POST',
            data: data,
        })
    }
}
