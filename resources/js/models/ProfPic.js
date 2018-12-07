export default class ProfPic {
    constructor(files){
        this.error = [];
        this.validate(files)
    }

    validate(files){

        this.validateLength(files);
        this.validateType(files[0]);
        this.validateSize(files[0]);
        if(this.error.length != 0){
            return alert(`${this.error}`);
        }else{
            this.error = [];
            return this.file = files[0];
        }
    }

    validateLength(files){
        if(files.length !== 1){
            this.error.push('Uploaded nothing or uploaded more than one file!! ');
            return false;
        }
    }

    validateType(file) {

        if (!file['type'].includes('image')) {
            this.error.push('Invalid file type! ');
            return false;
        }
    }

    validateSize(file){

        if(file.size >= 100000){
            this.error.push('Exceeded the file size limit of 100kb! ');
            return false;
        }

    }

    saveImage(){

        const formData = new FormData();


        formData.append("image", this.file);
        var request = new XMLHttpRequest();
        request.open("POST", "/image");
        request.send(formData);
    }
}
