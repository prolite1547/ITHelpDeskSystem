export default class Fix {
    constructor(ticketID,data){
        this.ticketID = ticketID;
        this.data = data;
    }


    createFix(){

        return $.ajax(`/ticket/${this.ticketID}/fix/create`,{
            type: 'POST',
            data: this.data
        })
    }
}
