export default class Position {

    storeData (data) {
        return $.ajax('/add/position',{
           type: 'POST',
           data: data
        });
    }


}
