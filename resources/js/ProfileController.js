import {elements,elementStrings} from "./views/base";
import ProfPic from "./models/ProfPic";


export const profileController  = () => {


elements.profilePicEditIcon.addEventListener('change', (e) => {

    const input = e.target;

    const image = new ProfPic(input.files);

    if(image.file){
        image.saveImage();
    }
    window.asd = image;



});

}
