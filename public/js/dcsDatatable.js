 

$(function() {
        
    $('#sdc-table').DataTable({
        processing: true,
        serverSide: true,
        order: [[5, 'desc']],
        "bPaginate": true,
        "sPaginationType": "full_numbers",
        ajax: '/datacorrections/sdc',
        columns: [
            { data: 'subject', name: 'subject' },
            { data: 'requestor_name', name: 'requestor_name' },
            { data: 'dept_supervisor', name: 'dept_supervisor' },
            { data: 'department', name: 'department' },
            { data: 'position', name: 'position' },
            { data: 'date_submitted', name: 'date_submitted' },
            { data: 'ticket_id', name: 'ticket_id', visible: false},
            { data: 'sdc_no', name: 'sdc_no', visible: false},
            { data: 'posted', name: 'posted', visible: false}
        ],
         columnDefs: [
                { 
                  orderable: false, 
                  targets: [0,1,2,3,4]
                },
                {
                    targets: 0, /*SUBJECT*/
                    createdCell: ( cell, cellData,rowData) => {
                        cell.setAttribute('title',rowData.subject);
                    },
                    orderable: false,
                    render: (data, type, row) => {
                        var posted = "UNPOSTED";
                        if(row.posted == 1){
                            posted = "POSTED";
                        }
                        return `<a href='/system/${row.id}/print/' class='table__subject' target='_blank'>${row.subject}</a><br>
                        <span class='table__info'>Ticket #: ${row.ticket_id}</span>
                        <span class='table__info'>SDC #: ${row.id}</span>\t
                        <span class='table__info'>${posted} </span>
                         `
                    }

                 }  
         ]

    });


    $('#mdc-table').DataTable({
        processing: true,
        serverSide: true,
        order: [[4, 'desc']],
        "bPaginate": true,
        "sPaginationType": "full_numbers",
        ajax: '/datacorrections/mdc',
        columns: [
            { data: 'subject', name: 'subject' },
            { data: 'requestor_name', name: 'requestor_name' },
            { data: 'department', name: 'department' },
            { data: 'position', name: 'position' },
            { data: 'date_submitted', name: 'date_submitted' },
            { data: 'ticket_id', name: 'ticket_id', visible: false},
            { data: 'mdc_no', name: 'mdc_no', visible: false}
        ],
         columnDefs: [
                { 
                  orderable: false, 
                  targets: [0,1,2,3]
                },
                {
                    targets: 0, /*SUBJECT*/
                    createdCell: ( cell, cellData,rowData) => {
                        cell.setAttribute('title',rowData.subject);
                    },
                    orderable: false,
                    render: (data, type, row) => {
                        var posted = "UNPOSTED";
                        if(row.posted == 1){
                            posted = "POSTED";
                        }
                        return `<a href='/manual/${row.id}/print/' class='table__subject' target='_blank'>${row.subject}</a><br>
                        <span class='table__info'>Ticket #: ${row.ticket_id}</span>
                        <span class='table__info'>MDC #: ${row.id}</span>\t
                        <span class='table__info'>${posted} </span>
                         `
                    }

                 }  
         ]

    });

});