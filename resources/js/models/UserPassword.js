export default class UserPassword {

    changePassAjax(userId){
        return $.ajax(`/modal/changep/${userId}`, {
            type : 'GET'
        });
    }

    changePassword(formData){
        return $.ajax('/change/pass',{
            type: 'POST',
            data: formData,
        }
        );
    }

    checkPasswordMatched(input1, input2){
        if(input1 == input2){
            return true;
        }
        return false;
    }

    checkOldPassword(frmData){
        return $.ajax('/check/pass',{
            type: 'POST',
            data: frmData
        });
    }
}