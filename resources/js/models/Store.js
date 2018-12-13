export default class Store {
    constructor(store_name){
        this.stoer_name =  store_name;
    }

    storeData(data){

        return $.ajax('/store/save',{
            type: 'POST',
            data: data,
        })
    }


    getStoreResource(){
        return $.ajax('/select/store',{
            type: 'GET',
        })
    }
}
