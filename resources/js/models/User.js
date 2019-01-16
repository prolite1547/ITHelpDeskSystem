export default class User {
    constructor(){
        this.getUser();
    }

    addUser(fname,mname,lname,store_id,role_id,position_id,token){
        this.fName = fname;
        this.mName = mname;
        this.lName = lname;
        this.store_id = store_id;
        this.role_id = role_id;
        this.position_id = position_id;
        this.uname = this.generateUname();
        this.email = this.generateEmail();
        this.password = '$2y$12$YctQtvgKFC/6Uje8.GuUQOA4SXSxMJu0V.v7IxX8BZq7NV9NjcqwO';
        this._token = token;
    }

    generateUname(){
        return this.getFirstNameInitials().concat('',this.mName[0]).concat('',this.lName).toLowerCase();
    }

    generateEmail(){
        let mail = '@citihardware.com'
        return this.generateUname().concat('',mail);
    }

    getFirstNameInitials(){
        let names,initals;
        initals = '';
        names = this.fName.split(' ');
        names.forEach((cur) => {
            initals+= cur[0];
        });

        return initals;
    }

    getUser(){
        $.ajax(`/api/user/${window.authUserID}`,{
            type: 'GET'
        }).done(data => {
            const user = data.data;
            this.id = user.id;
            this.fName = user.fName;
            this.mName = user.mName;
            this.lName = user.lName;
            this.role_id = user.role_id;
        }).fail(() => {
            alert('failed to get user api');
        })
    }
}
