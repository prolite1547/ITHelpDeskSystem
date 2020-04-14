import {displayError, elements, elementStrings, setDisable, toggleFormGroups} from "./views/base";
import * as globalScript from "./global";
import {branchSelect2} from "./select2";
import * as maintenanceView from "./views/v_maintenance";
import CategoryA from "./models/CategoryA";
import CategoryB from "./models/CategoryB";
import CategoryC from "./models/CategoryC";
import EmailGroup from "./models/EmailGroup";

export const maintenancePageController = () => {
    let m_email_group = {
        id: 0
    };

    window.test = m_email_group;
    $(elementStrings.branchSelectContact).on('select2:select', globalScript.toggleHiddenGroup);
    elements.addContactForm.addEventListener('submit',globalScript.sendForm);
    elements.addContactPersonForm.addEventListener('submit', globalScript.sendForm);
    elements.addPidForm.addEventListener('submit', globalScript.sendForm);
    $('#contactBranchSelect').select2(branchSelect2);
    $('#contactPersonBranchSelect').select2(branchSelect2);
    $('#pidBranchSelect').select2(branchSelect2);
    elements.maintenanceCol.addEventListener('click',toggleFormGroups); /*EVENT LISTENER ON PLUS ICONS*/
    elements.contactTypeSelect.on('change', {
        form: elements.telAccountSelectDisplay ,
        value: 1,
        element : elements.telAccountSelect,
        element2 : elements.telCompanySelect,
    } ,ToggleElementwithCondition );
    /*category radio inputs*/
    const categories_select = elements.plusToggleContainer.querySelectorAll('input[name=category]');
    /*add new categories form*/
    const addCatForm = elements.plusToggleContainer.querySelector('.form');

    /*Generate default form base on current selected category*/
    categories_select.forEach(el => {
        if(el.checked){
            maintenanceView.dynamicFormContent(el.id);
        }
    });

    /*Listen if a category is selected*/
    categories_select.forEach(el => {
        el.addEventListener('change', (e) => {
            if(e.target.checked){
                maintenanceView.dynamicFormContent(e.target.id);
            }
        })
    });

    /*listen for sumbit event on adding of category*/
    addCatForm.addEventListener('submit',(e) => {
        e.preventDefault();
        const form = e.target;
        console.log(form.elements);
        const submitBtn = form.elements[6];
        const originalText = submitBtn.textContent;
        submitBtn.textContent = 'Please Wait..,';
        setDisable(submitBtn,true);
        const data = $(form).serialize();
        let model = '';
        switch (form.id) {
            case 'category_a':
                model = CategoryA;
                break;
            case 'category_b':
                model = CategoryB;
                break;
            case 'category_c':
                model = CategoryC;
                break;
            default:
                alert('Form not found!');
        }

        model.store(data)
            .done(() => {
                alert('Successfully added category!');
                submitBtn.textContent = originalText;
                setDisable(submitBtn,false);
            })
            .fail(data => {
                submitBtn.textContent = originalText;
                setDisable(submitBtn,false);
                displayError(data)
            });
    })


    $('select[name=email_group_id]').on('change',(e) => {
        /*get emails depending on select value*/
        m_email_group.id = $(e.target).val();
        EmailGroup.getEmails(m_email_group.id);
    });

    $('#email2Add2Group').select2({
        placeholder: 'Enter emails to be added to the group...',
        width: '20%',
        tags: true,
        tokenSeparators: [',', ' ']
    });

    $('#addEmailToGroup').on('submit', (e) => {
        const form = e.target;
        if(form.checkValidity()){
            e.preventDefault();
            const email_group_id = e.target.elements.emailGroupSelect.value;

            $.ajax('/email/group/add',{
                type: 'POST',
                data: $(form).serialize()
            }).done(() => {
                EmailGroup.getEmails(email_group_id);
            }).fail(() => alert('failed to add email to the group'));
        }
    });

    $('.form-emailGroupAdd__email-table').on('click','.form-emailGroupAdd__remove-mail',(e)  => {
        $.ajax(`/email/group/delete/pivot/${e.target.id}`,{
            type:'DELETE'
        }).done(() => EmailGroup.getEmails(m_email_group.id)).fail(() => alert('failed to delete email from the group'));
    });

    document.getElementById('addEmail').addEventListener('submit',(e) => {
       e.preventDefault();

       $.ajax('/email/add',{
           type: 'POST',
           data: $(e.target).serialize()
       }).done(() => alert('Successfully added email!'))
           .fail((jqXHR) => {
            displayError(jqXHR)
       });

    });

    document.getElementById('addEmailGroup').addEventListener('submit',(e) => {
        e.preventDefault();

        $.ajax('/email-group/add',{
            type: 'POST',
            data: $(e.target).serialize()
        }).done(() => alert('Successfully added email group!'))
            .fail((jqXHR) => {
                displayError(jqXHR)
        });

    });

    document.getElementById('addItemCategory').addEventListener('submit', (e)=>{
        e.preventDefault();
  
        let frmElements = e.target.elements;
        let txtCateg = $(frmElements.item_categ);
          console.log($(e.target).serialize());
        $.ajax('/item-category/add',{
            type: 'POST',
            data: $(e.target).serialize()
        }).done((data) => {
            alert('Successfully added item category!')
            txtCateg.val('');
        }).fail((jqXHR) => {
                displayError(jqXHR)
        });

    })


};

const ToggleElementwithCondition = (e) => {
    let currVal = $(e.target).val();
        if(currVal == e.data.value){
            e.data.form.css('display', 'inline-block')
            e.data.element.prop('required', true)
            e.data.element2.prop('required', true)
        }else{
            e.data.form.css('display', 'none')
            e.data.element.prop('required', false)
            e.data.element2.prop('required', false)
            e.data.element.val('').trigger('change')
            e.data.element2.val('').trigger('change')
        }
}
