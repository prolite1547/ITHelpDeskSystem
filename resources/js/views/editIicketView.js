import {
    clearLoader,
    elements, elementStrings,
    insertToModal,
    renderLoader,
    showModal
} from "./base";

import {exprtionSelect2} from '../select2';

export const getAutoGroup = () => {
    var group = $('#group');
    var assignSelect = $('#assigneeSelect');

    if(assignSelect.val() != ''){
        var id = assignSelect.val();
        var assign = 'assigned';
    }else{
        var id =  '';
        var assign = 'none';
    }
    
    $.ajax('/get/group', {
        type: 'POST',
        data:  {
            'assign' : assign,
            'id' : id
        }
    })
    .done((data) => {
        group.val(data.id);
    })
    .fail(() => {
        console.log("failed to get user group ")
    });
    
    
    assignSelect.on('change',function(){
        var id = $(this).val();
        var assign = 'assigned';
        if(id == ''){
            assign = 'none';
        }
    
        $.ajax('/get/group', {
            type: 'POST',
            data:  {
                'assign' : assign,
                'id' : id
            }
        })
        .done((data) => {
            group.val(data.id);
        })
        .fail(() => {
            console.log("failed to get user group")
        });
    
    });
}

export const makeElementsEditable = () => {

    elements.ticketDetails.contentEditable = "true";
    elements.ticketSubject.contentEditable = "true";
    elements.ticketDetails.style.border = '1px solid #999';
    elements.ticketSubject.style.border = '1px solid #999';
    elements.ticketDetails.style.padding = '0 1rem';
    elements.ticketSubject.style.padding = '0 1rem';

};

export const makeElementsNotEditable = () => {

    elements.ticketDetails.contentEditable = "false";
    elements.ticketSubject.contentEditable = "false";
    elements.ticketDetails.style.border = 'none';
    elements.ticketSubject.style.border = 'none';
    elements.ticketDetails.style.padding = '';
    elements.ticketSubject.style.padding = '';
};


export const showButtons = () => {
    elements.updateButtonsContainer.style.display = 'block';
};


export const hideButtons = () => {
    elements.updateButtonsContainer.style.display = 'none';
};

export const restoreElementsTextContent = (ticket) => {
    elements.ticketDetails.textContent = ticket.details;
    elements.ticketSubject.textContent = ticket.subject;
};


export const getFixFormMarkUp = (lookup = false,ticketID = 0) => {
    let ajax;

    if(!lookup){
         ajax = $.ajax('/modal/form/fix',{
                    type: 'GET'
                });
    }else{
        ajax = $.ajax(`/modal/form/fix/${ticketID}`,{
            type: 'GET'
        });
    }

    return ajax;

};


export const addEventListenerToEditInputs = (ticket) => {
    const inputs = document.querySelectorAll('.ticket-details__select');
    inputs.forEach(el => {
        el.addEventListener('input',ticket.storeEditData.bind(ticket));
    });
};

export const addFileMarkup = `<div class="dropzone" id="addFiles"><button type="button" class="dropzone__upload btn">Upload</button></div>`;

export const getModalWithData = (ticket) => {

        showModal();
        renderLoader(elements.modalContent);
        getFixFormMarkUp(true,ticket.id)
            .done(data => {
                clearLoader();
                insertToModal(data);

                /*show the reject form*/
                if(document.querySelector(elementStrings.rejectBtnShowForm))
                document.querySelector(elementStrings.rejectBtnShowForm).addEventListener('click',showRejectModal.bind(null, ticket.id));

                /*add event listenser when user resolves the fix ticket*/
                if(document.querySelector(elementStrings.resolveBtn))
                document.querySelector(elementStrings.resolveBtn).addEventListener('click',e => {
                    const fix_id = parseInt(elements.modalContent.querySelector('.resolve-details__fix-id').textContent);
                    $.ajax(`/ticket/resolve/${fix_id}`,{
                        type: 'POST'
                    }).done(() => {
                        alert('Ticket is now resolved!');
                        window.location.reload();
                    }).fail(() => {
                        alert('Failed to resolve the ticket!');
                    })
                })

            });
};

export const getMessageMarkup = (e) => {
    let messageMarkup;
    /*ADD CLOSE BUTTON IF THE RECIEVED MESSAGE IS EQUAL TO THE AUTHENTICATED USER*/
    if (authUserID === e.userID){
        messageMarkup = `<div class="message" data-id="${e.messageID}">
                                    <div class="message__img-box">
                                        <img src="/storage/profpic/${e.image}" alt="${e.user}" class="message__img">
                                    </div>
                                    <div class="message__content">
                                        <div class="message__message-box">
                                            <span class="message__close-icon">
                                            X
                                            </span>
                                            <div class="message__name">${e.user}</div>
                                            <div class="message__message">${e.message}</div>
                                        </div>
                                        <span class="message__time">${moment().fromNow()}</span>
                                    </div>
                                 </div>`;
    } else {
        messageMarkup = `<div class="message" data-id="${e.messageID}">
                                    <div class="message__img-box">
                                        <img src="/storage/profpic/${e.image}" alt="${e.user}" class="message__img">
                                    </div>
                                    <div class="message__content">
                                        <div class="message__message-box">
                                            <div class="message__name">${e.user}</div>
                                            <div class="message__message">${e.message}</div>
                                        </div>
                                        <span class="message__time">${moment().fromNow()}</span>
                                    </div>
                                 </div>`;
    }

    return messageMarkup;
};


export const displayContactNumbers = (e) => {
  e.preventDefault();
    showModal();
    renderLoader(elements.modalContent);
  let store_id = e.target.dataset.store;
  fetchContactDetails(store_id)
      .done(data => {
          clearLoader();
          insertToModal(data);

      });
};


function fetchContactDetails(store_id) {
    return $.ajax(`/modal/${store_id}/contacts`,{
        type: 'GET'
    }).fail(() => {
        alert('failed to get branch contacts');
    });
}

export const showRejectModal = (ticket_id,e) => {
    {
        e.preventDefault();
        e.target.disabled = true;
        showModal();
        renderLoader(elements.modalContent);
        getRejectForm(ticket_id)
            .then(response => {
                clearLoader();
                insertToModal(response);
            }).catch(() => {
                e.target.disabled = false;
                alert('Fail to Get Reject Form');
        });
    }
};

function getRejectForm(ticket_id) {
    return $.ajax(`/modal/form/reject/${ticket_id}`,{
        type:'GET'
    });
}

export const showRejectDetails = (ticket_id) => {
        showModal();
        renderLoader(elements.modalContent);
    return $.ajax(`/modal/lookup/reject/${ticket_id}`,{
        type: 'GET'
    })
        .done(response => {
            clearLoader();
            insertToModal(response);
        }).fail(() => {
            alert('error getting the rejection details');
        });
};

export const showExtendFormModal = (ticket_id,e) => {
    e.preventDefault();
    showModal();
    renderLoader(elements.modalContent);

    $.ajax(`/modal/form/extend/${ticket_id}`,{
       type: 'GET'
    }).done(form => {
        clearLoader();
        insertToModal(form);
        $('.extend-form__duration').select2(exprtionSelect2);
    }).fail(() => {
        alert('fail to get extend form');
    });

};

/*show the extend details form*/
export const showExtndMdl = (ticket_id,e) => {
    e.preventDefault();
    showModal();
    renderLoader(elements.modalContent);

    $.ajax(`/modal/form/ticketExtendDetails/${ticket_id}`,{
        type: 'GET'
    }).done(detailsMarkup => {
        clearLoader();
        insertToModal(detailsMarkup);
    }).fail(() => {
        alert('fail to get extend form');
    });
};

export const showSelects = (e) => {

    const selectElement = e.target;

    if(selectElement.value){
        /*get option group name*/
        const option_group = selectElement.options[selectElement.selectedIndex].parentElement.getAttribute('label');

        /*generate selects to be show depend on the option group name*/
        if(option_group === 'Both'){
            elements.selectPID.removeClass('u-display-n');
            elements.selectPID.prop('required', true);
            elements.selectTel.removeClass('u-display-n');
            elements.selectTel.prop('required', true);
        }else if(option_group === 'Data'){
            elements.selectPID.removeClass('u-display-n');
            elements.selectPID.prop('required', true);
            elements.selectTel.addClass('u-display-n');
            elements.selectTel.prop('required', false);
        }else if(option_group === 'Voice'){
            elements.selectTel.removeClass('u-display-n');
            elements.selectTel.prop('required', true);
            elements.selectPID.addClass('u-display-n');
            elements.selectPID.prop('required', false);
        }else{
            elements.selectPID.addClass('u-display-n');
            elements.selectPID.prop('required', false);
            elements.selectTel.addClass('u-display-n');
            elements.selectTel.prop('required', false);
        }

    }else{
        elements.selectPID.addClass('u-display-n');
        elements.selectPID.prop('required', false);
        elements.selectTel.addClass('u-display-n');
        elements.selectTel.prop('required', false);
    }

};


// CREATE EMAIL ADD TICKET  EVENTS 

export const connBranchChanged = (e) => {
   var branchId = $(e.target).val();
   var telcoId = elements.telcoSelect.val();
   elements.form__issue_details.removeClass('u-display-n');
   elements.vpnCategorySelect.val('').trigger('change');
   elements.form__vpn.html('<p>Choose vpn group to show details..</p>');
//    getSelectAjaxData(`/get/pid/${branchId}`, elements.selectPID, '(choose pid/cid...)');
   getSelectAjaxData(`/get/tel/${branchId}/1/${telcoId}`, elements.selectTelNos, '');
   getSelectAjaxData(`/get/contact/${branchId}/2`, elements.selectContactNo, '(choose contact no..)'); 
//    getSelectAjaxData(`/get/cperson/${branchId}`, elements.selectContactP, '(choose contact person..)');
}

export const telcoSelectChanged = (e) => {
    let currIndex = $(e.target).prop('selectedIndex');
    if(currIndex != 0){
        elements.email_form.removeClass('u-display-n');
        let currVal = $(e.target).val();
        getSelectAjaxData(`/get/emails/${currVal}`,  elements.emailTo, '');
        getSelectAjaxData(`/get/emails/${currVal}`,  elements.emailCc, '');
    }else{
        elements.email_form.addClass('u-display-n');
    }
}

function getSelectAjaxData(url , element, placeholder){
    element.empty();
    element.append(new Option(placeholder, ''));
    $.ajax(url, {
        type: 'GET'
    }).done( data => {
        if(data != null){
            for(const el of data){
                    element.append(new Option(el.text, el.text));
            }
        }
    })
}

export const issueTypeChanged =  (e) => {
    var issue = $(e.target).val();
    if(issue == "VPN"){
        elements.vpnCategory.removeClass('u-display-n');
        elements.vpnCategorySelect.prop('required', true);
        getConcernsOnChange(`/get/concerns/${issue}`)
        elements.form__telephone.addClass('u-display-n');
        elements.form__vpn.removeClass('u-display-n');
        elements.selectTelNos.prop('required', false);
    }else if(issue == "Telephone"){
        elements.vpnCategory.addClass('u-display-n');
        elements.vpnCategorySelect.val('').trigger('change');
        elements.vpnCategorySelect.prop('required', false);
        getConcernsOnChange(`/get/concerns/${issue}`)
        elements.form__telephone.removeClass('u-display-n');
        elements.form__vpn.addClass('u-display-n');
        elements.selectTelNos.prop('required', true);
    }else{
        getConcernsOnChange(`/get/concerns/${issue}`)
        elements.vpnCategorySelect.prop('required', false);
        elements.selectTelNos.prop('required', false);
        elements.vpnCategory.removeClass('u-display-n');
        elements.vpnCategory.addClass('u-display-n');
        elements.form__vpn.removeClass('u-display-n');
        elements.form__telephone.removeClass('u-display-n');
        elements.form__telephone.addClass('u-display-n');
        elements.form__vpn.addClass('u-display-n');
    }

}

function getConcernsOnChange(url){
    elements.concernSelect.empty().trigger('change');
    elements.concernSelect.append(new Option('(choose concern ...)','')).trigger('change');
    $.ajax(url, {
        type: 'GET',
    }).done( data =>{
        if(data != null){
            for(const el of data){
                elements.concernSelect.append(new Option(el.text, el.id)).trigger('change');
            }
        }
    });
}

export const generateVpn = (e)=> {
    let branch = elements.connBranchSelect.val();
    let category = $(e.target).val();
    let currIndex = $(e.target).prop('selectedIndex');
    if(currIndex != 0){
        $.ajax(`/get/vpn/${branch}/${category}`, {
            type: 'GET'
        }).done(response => {
           elements.form__vpn.html(response.markup) ;
        });
    }else{
        elements.form__vpn.html('<p>Choose vpn group to show details..</p>');
    }
}


// END OF EMAIL ADD 

/*generate form depending on the type of incident*/
export const generateForm = identifier => {
    const chat_form_inputs = elements.chatForm.elements;
    const chat_form_childElem = elements.chatForm.children;

    if(identifier === 'reply'){
        elements.chatForm.dataset.form = 'reply';
        chat_form_childElem[0].children[1].classList.remove('u-display-n'); /*chat menu*/
        chat_form_childElem[1].classList.remove('u-display-n');  /*to form__group*/
        chat_form_childElem['reply_attachments[]'].classList.remove('u-display-n'); /*attachments input*/
        elements.chatForm__reply.classList.remove('u-display-n');
        elements.chatForm__chat.classList.add('u-display-n');
        elements.reply.rows = 10;
        // chat_form_inputs.to.disabled = false;  /*to input*/
    }else if(identifier === 'chat'){
        elements.chatForm.dataset.form = 'chat';
        chat_form_childElem[1].classList.add('u-display-n');  /*to form__group*/
        //  chat_form_inputs.to.disabled = true;  /*to input*/
        chat_form_childElem['reply_attachments[]'].classList.add('u-display-n'); /*attachments input*/
        elements.chatForm__reply.classList.add('u-display-n');
        elements.chatForm__chat.classList.remove('u-display-n');
        elements.reply.rows = 5;
    }else{
        console.log('Error on retrieving chat form!');
    }

};

export const generateRepliesMarkup = (replies) => {
    let replyTemplate = `<div class="message" data-id="{%ID%}">
                <div class="message__content">
                    <div class="message__message-box">
                        <div class="message__name">{%FROM%}</div>
                        <div class="message__message">{%REPLY%}</div>
                        <div class="message__flex message__flex--sb">
                            <span class="message__time">{%REPLY_DATE%}</span>
                            <div>
                                {%attachment_count%}
                                <a class="message__conversation" href="/reply/conversation/{%ID%}" title="View conversation" target="_blank">👁️‍🗨️</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;

        const thread = replies.map(reply => {
            let markup,reply_from ;

            /*convert greater and less than symbols to html entities*/
            reply_from = reply.from.full.replace(/\</g,'&lt;');
            reply_from = reply_from.replace(/\>/g,"&gt;");

            markup = replyTemplate.replace(/{%ID%}/g,reply.id);
            markup = markup.replace('{%FROM%}',reply_from);
            markup = markup.replace('{%REPLY%}',reply.html_body);
            markup = markup.replace('{%REPLY_DATE%}',reply.reply_date);
            reply.hasAttachments !== 0 ? markup = markup.replace('{%attachment_count%}',`<span class="message__attachment-count">${reply.hasAttachments}📎</span>`) : markup = markup.replace('{%attachment_count%}','');

            return markup;
        });

        return thread.join('');

};
