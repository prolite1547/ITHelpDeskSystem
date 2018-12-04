export default class Resolve {
    constructor(ticketID,data){
        this.ticketID = ticketID;
        this.data = data;
    }


    createResolve(){

        $.ajax(`/ticket/${this.ticketID}/resolve/create`,{
            type: 'POST',
            data: this.data
        })
    }
}
