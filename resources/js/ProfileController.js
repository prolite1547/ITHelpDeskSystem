import {elements,
    elementStrings, 
    insertToModal,
    renderLoader,
    showModal,
    hideModal,
    displayError,
    clearLoader} from "./views/base";
import ProfPic from "./models/ProfPic";
import UserPassword from "./models/UserPassword";


export const profileController  = () => {


elements.profilePicEditIcon.addEventListener('change', (e) => {

    const input = e.target;

    const image = new ProfPic(input.files);

    if(image.file){
        image.saveImage();
    }
    window.asd = image;
});

elements.btn_changepass.on('click', (e)=>{
    showModal();
    renderLoader(elements.modalContent);
   const object = new UserPassword();
    object.changePassAjax().done(data => {
        clearLoader();
        insertToModal(data);
        let frmChangePass = $('#form_changepass');
        frmChangePass.on('submit', (e)=>{
            e.preventDefault();
            let newPass1 = $('#new_pass').val();
            let newPass2 = $('#rnew_pass').val();
            let frmData = $(e.target).serialize();
            if(object.checkPasswordMatched(newPass1, newPass2)){
                object.checkOldPassword(frmData).done( data => {
                    alert(data.text);
                    if(data.success){
                        document.getElementById('logout-form').submit();
                    }
                }).fail((jqXHR,textStatus,errorThrown) => {
                    if(jqXHR){
                        displayError(jqXHR)
                    }else if(errorThrown) {
                        alert(errorThrown);
                    }else if(textStatus){
                        alert(textStatus);
                    }else{
                        alert('Unable to process the request!')
                    }
            });
            }else{
                alert("New password fields not matched...");
            }
        })
    });
     
});

 

}
