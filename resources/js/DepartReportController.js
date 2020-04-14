import {elements, elementStrings, displayError} from "./views/base";
import {renderLoader, clearLoader} from "./views/base";
import {categoryADynamicCategoryBSelect} from "./global";

export const DepartReportAddController = () => {
    elements.addDeptReportForm.on('submit', (e)=>{
        let currentForm = $(e.target);
        e.preventDefault();
        let formdata  =  new FormData(e.target);
        e.target.classList.toggle('u-display-n');
        renderLoader(e.target.parentElement);
        $.ajax('/add/dept/report',{
            type: 'POST',
            data : formdata,
            contentType: false,
            cache: false,
            processData: false
        }).done(retData =>{
            clearLoader();
             alert(retData.response);
             currentForm.trigger('reset');
             e.target.classList.toggle('u-display-n');
        }).fail((jqXHR)=>{
            clearLoader();
            displayError(jqXHR);
        });
    });

    categoryADynamicCategoryBSelect();
    getAutoGroup();
    // addTicketFromReported();
    
}

const addTicketFromReported = () => {
    elements.addTicketFromReported.on('submit', (e)=>{
        e.preventDefault();
        let formData = new FormData(e.target);
        e.target.classList.toggle('u-display-n');
        renderLoader(e.target.parentElement);
        $.ajax('/add/reported/ticket', {
            type: 'POST',
            data: formData,
            contentType: false,
            cache: false,
            processData: false
        }).done( response =>{
            clearLoader();
            e.target.classList.toggle('u-display-n');
           
        }).fail((jqXHR)=>{
            clearLoader();
            e.target.classList.toggle('u-display-n');
            displayError(jqXHR);
        });
    });
}

const getAutoGroup = () => {
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


export const DepartReportViewController = () => {
    let department_id = $('#reported-table').data('department');
    $('#reported-table').DataTable({
        dom: 'lrtip',
        processing: true,
        serverSide: true,
        order: [[0, 'asc']],
        "bPaginate": true,
        "sPaginationType": "full_numbers",
        ajax: `/get/reported/${department_id}`,
        columns: [
            { data: 'subject', name: 'subject' },
            { data: 'branch', name: 'branch' },
            { data: 'caller_name', name: 'caller_name' },
            { data: 'position', name: 'position' },
            { data: 'department', name: 'department' },
            { data: 'created_at', name: 'created_at'},
            { data: 'group_name', name: 'group_name'},
            { data: 'department_id', name: 'department_id', visible: false},
            { data: 'ticket_id', name: 'ticket_id', visible: false},
        ],
        columnDefs: [
            { 
              orderable: true, 
              targets: [0,1,2,3]
            },

            {targets: 0, orderable: false, render: (data,type,row)=> { 
                let ischecked = '';
                if(department_id == 60666){
                    return `<a href='/view/reported/ticket/${row.ticket_id}' class='table__subject'>${data}</a>`;
                }

                return `<span class="table__info">${data}</span>`;
               
            }},

            
        ]
       
    });
}