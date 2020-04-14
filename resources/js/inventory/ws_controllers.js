export default class wsControllers {
    static getModalContent(){
        return $.ajax('/get/modal/ws',{
            type : 'GET',
            data:'',
            processData: false,
            contentType: false
        });
    }

    static getModalCompoContent(pdata){
        return $.ajax('/show/ws/partscompo/'+pdata.id, {
            type: 'GET',
            data: pdata,
            processData: false,
            contentType: false
        });
    }

    static getModalAddItemContent(idata){
        return $.ajax('/show/modal/additem/'+idata.id, {
            type: 'GET',
            data : idata,
            processData: false,
            contentType: false
        });
    }

    static getRepairedItemsContent(id,sid){
        return $.ajax('/show/repaired/modal/'+id+'/'+sid, {
            type: 'GET',
            data:'',
            processData: false,
            contentType: false
        });
    }

    static addItemWS(iData){
        return $.ajax('/add/itemws',{
            type: 'POST',
            data : iData
        });
    }

    static showWsUpdate(wid){
       
        return $.ajax('/get/modal/ws/up/'+wid, {
            type: 'GET',
            data: '',
            processData : false,
            contentType: false
        });
    }
}