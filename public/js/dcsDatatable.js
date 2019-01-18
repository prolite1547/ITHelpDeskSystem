 

$(function() {
    
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
    
    try{
        let dcStats;
        let dcStatsRegex = new RegExp('\/datacorrections\/sdc\/([a-z]+)', 'gm');
        dcStats = dcStatsRegex.exec(window.location.pathname)[1];
        
        $('#sdc-table').DataTable({
            processing: true,
            serverSide: true,
            order: [[5, 'desc']],
            "bPaginate": true,
            "sPaginationType": "full_numbers",
            ajax: '/datacorrections/sdc-data/'+ dcStats,
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
                            var status = "";    
                            if(row.status == 1){
                                status = "POSTED";
                            }else if(row.status == 2){
                                status = "ON GOING";
                            }else if(row.status == 3){
                                status = "FOR APPROVAL";
                            }else if(row.status == 4){
                                status = "APPROVED";
                            }else if(row.status == 5){
                                status = "DONE";
                            }else{
                                status = "SAVED";
                            }
                            if(row.status < 4 || row.status == 5 ){
                                return `<a href='/system/${row.id}/print/' class='table__subject' target='_blank'>${row.subject}</a><br>
                                <span class='table__info'>Ticket #: ${row.ticket_id}</span>
                                <span class='table__info'>SDC #: ${row.id}</span>\t
                                <span class='table__info'>${status} </span>
                                `
                            }else{
                                return `<a href='/sdc/${row.id}/edit/' class='table__subject'>${row.subject}</a><br>
                                <span class='table__info'>Ticket #: ${row.ticket_id}</span>
                                <span class='table__info'>SDC #: ${row.id}</span>\t
                                <span class='table__info'>${status} </span>
                                `
                            }
                          
                        }

                    }  
            ]

        });

    }catch(err){
         
    }
        
   



// END OF SUPPORT SDC DATATABLE PERSPECTIVE



 //  START OF TREASURY TABLE OPTIONS
 
    const allTreasury = {
        processing: true,
        serverSide: true,
        order: [[4, 'desc']],
        "bPaginate": true,
        "sPaginationType": "full_numbers",
        ajax: '/datacorrections/ty-data/all',
        columns: [
            { data: 'subject', name: 'subject' },
            { data: 'requestor_name', name: 'requestor_name' },
            { data: 'department', name: 'department' },
            { data: 'position', name: 'position' },
            { data: 'date_submitted', name: 'date_submitted' },
            { data: 'ticket_id', name: 'ticket_id', visible: false},
            { data: 'sdc_no', name: 'sdc_no', visible: false}
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
                        var status = "PENDING";
                        if(row.status == 1){
                            status = "PENDING";
                            return `<a href='/sdc/${row.id}/edit/' class='table__subject'>${row.subject}</a><br>
                            <span class='table__info'>Ticket #: ${row.ticket_id}</span>
                            <span class='table__info'>SDC #: ${row.id}</span>\t
                            <span class='table__info'>${status} </span>
                             `
                        }else if(row.status >= 2){
                            status = "DONE";
                            return `<a href='/system/${row.id}/print/' class='table__subject' target='_blank'>${row.subject}</a><br>
                            <span class='table__info'>Ticket #: ${row.ticket_id}</span>
                            <span class='table__info'>SDC #: ${row.id}</span>\t
                            <span class='table__info'>${status} </span>
                             `
                        }

                    
                      
                    }

                 }  
         ]
    };

    const pendingTreasury = {
        processing: true,
        serverSide: true,
        order: [[4, 'desc']],
        "bPaginate": true,
        "sPaginationType": "full_numbers",
        ajax: '/datacorrections/ty-data/pending',
        columns: [
            { data: 'subject', name: 'subject' },
            { data: 'requestor_name', name: 'requestor_name' },
            { data: 'department', name: 'department' },
            { data: 'position', name: 'position' },
            { data: 'date_submitted', name: 'date_submitted' },
            { data: 'ticket_id', name: 'ticket_id', visible: false},
            { data: 'sdc_no', name: 'sdc_no', visible: false}
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
                        var status = "PENDING";
                       
                        return `<a href='/sdc/${row.id}/edit/' class='table__subject'>${row.subject}</a><br>
                        <span class='table__info'>Ticket #: ${row.ticket_id}</span>
                        <span class='table__info'>SDC #: ${row.id}</span>\t
                        <span class='table__info'>${status} </span>
                         `
                    }

                 }  
         ]
    };

    const doneTreasury = {
        processing: true,
        serverSide: true,
        order: [[4, 'desc']],
        "bPaginate": true,
        "sPaginationType": "full_numbers",
        ajax: '/datacorrections/ty-data/done',
        columns: [
            { data: 'subject', name: 'subject' },
            { data: 'requestor_name', name: 'requestor_name' },
            { data: 'department', name: 'department' },
            { data: 'position', name: 'position' },
            { data: 'date_submitted', name: 'date_submitted' },
            { data: 'ticket_id', name: 'ticket_id', visible: false},
            { data: 'sdc_no', name: 'sdc_no', visible: false}
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
                      
                        status = "DONE";
                       
                        return `<a href='/system/${row.id}/print/' class='table__subject' target='_blank'>${row.subject}</a><br>
                        <span class='table__info'>Ticket #: ${row.ticket_id}</span>
                        <span class='table__info'>SDC #: ${row.id}</span>\t
                        <span class='table__info'>${status} </span>
                         `
                    }

                 }  
         ]
    };
// END OF TREASURY TABLE OPTIONS

//  START OF GOV.COMP TABLE OPTIONS 

    const pendingGC = {
        processing: true,
        serverSide: true,
        order: [[4, 'desc']],
        "bPaginate": true,
        "sPaginationType": "full_numbers",
        ajax: '/datacorrections/gc-data/pending',
        columns: [
            { data: 'subject', name: 'subject' },
            { data: 'requestor_name', name: 'requestor_name' },
            { data: 'department', name: 'department' },
            { data: 'position', name: 'position' },
            { data: 'date_submitted', name: 'date_submitted' },
            { data: 'ticket_id', name: 'ticket_id', visible: false},
            { data: 'sdc_no', name: 'sdc_no', visible: false}
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
                        var status = "";
                        if(row.status == 2){
                            status = "PENDING";
                        } 
                        return `<a href='/sdc/${row.id}/edit/' class='table__subject'>${row.subject}</a><br>
                        <span class='table__info'>Ticket #: ${row.ticket_id}</span>
                        <span class='table__info'>SDC #: ${row.id}</span>\t
                        <span class='table__info'>${status} </span>
                         `
                    }

                 }  
         ]
    };

    const doneGC = {
        processing: true,
        serverSide: true,
        order: [[4, 'desc']],
        "bPaginate": true,
        "sPaginationType": "full_numbers",
        ajax: '/datacorrections/gc-data/done',
        columns: [
            { data: 'subject', name: 'subject' },
            { data: 'requestor_name', name: 'requestor_name' },
            { data: 'department', name: 'department' },
            { data: 'position', name: 'position' },
            { data: 'date_submitted', name: 'date_submitted' },
            { data: 'ticket_id', name: 'ticket_id', visible: false},
            { data: 'sdc_no', name: 'sdc_no', visible: false}
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
                        var status = "";
                        if(row.status == 3){
                            status = "DONE"
                        }
                        return `<a href='/system/${row.id}/print/' class='table__subject' target='_blank'>${row.subject}</a><br>
                        <span class='table__info'>Ticket #: ${row.ticket_id}</span>
                        <span class='table__info'>SDC #: ${row.id}</span>\t
                        <span class='table__info'>${status} </span>
                         `
                    }

                 }  
         ]
    };

    const allGC = {
        processing: true,
        serverSide: true,
        order: [[4, 'desc']],
        "bPaginate": true,
        "sPaginationType": "full_numbers",
        ajax: '/datacorrections/gc-data/all',
        columns: [
            { data: 'subject', name: 'subject' },
            { data: 'requestor_name', name: 'requestor_name' },
            { data: 'department', name: 'department' },
            { data: 'position', name: 'position' },
            { data: 'date_submitted', name: 'date_submitted' },
            { data: 'ticket_id', name: 'ticket_id', visible: false},
            { data: 'sdc_no', name: 'sdc_no', visible: false}
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
                        var status = "PENDING";
                        if(row.status == 2){
                            status = "PENDING";
                            return `<a href='/sdc/${row.id}/edit/' class='table__subject'>${row.subject}</a><br>
                            <span class='table__info'>Ticket #: ${row.ticket_id}</span>
                            <span class='table__info'>SDC #: ${row.id}</span>\t
                            <span class='table__info'>${status} </span>
                             `

                        }else if(row.status >= 3){
                            status = "DONE"
                            return `<a href='/system/${row.id}/print/' class='table__subject' target='_blank'>${row.subject}</a><br>
                            <span class='table__info'>Ticket #: ${row.ticket_id}</span>
                            <span class='table__info'>SDC #: ${row.id}</span>\t
                            <span class='table__info'>${status} </span>
                             `
                        }
                     
                    }

                 }  
         ]
    };

// END OF GOV. COMP TABLE OPTIONS

// START OF APPROVER TABLE OPTIONS
    const pendingAPP = {
        processing: true,
        serverSide: true,
        order: [[4, 'desc']],
        "bPaginate": true,
        "sPaginationType": "full_numbers",
        ajax: '/datacorrections/app-data/pending',
        columns: [
            { data: 'subject', name: 'subject' },
            { data: 'requestor_name', name: 'requestor_name' },
            { data: 'department', name: 'department' },
            { data: 'position', name: 'position' },
            { data: 'date_submitted', name: 'date_submitted' },
            { data: 'ticket_id', name: 'ticket_id', visible: false},
            { data: 'sdc_no', name: 'sdc_no', visible: false}
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
                        var status = "PENDING";
                        return `<a href='/sdc/${row.id}/edit/' class='table__subject'>${row.subject}</a><br>
                        <span class='table__info'>Ticket #: ${row.ticket_id}</span>
                        <span class='table__info'>SDC #: ${row.id}</span>\t
                        <span class='table__info'>${status} </span>
                         `
                    }

                 }  
         ]
    };

    const doneApp = {
        processing: true,
        serverSide: true,
        order: [[4, 'desc']],
        "bPaginate": true,
        "sPaginationType": "full_numbers",
        ajax: '/datacorrections/app-data/done',
        columns: [
            { data: 'subject', name: 'subject' },
            { data: 'requestor_name', name: 'requestor_name' },
            { data: 'department', name: 'department' },
            { data: 'position', name: 'position' },
            { data: 'date_submitted', name: 'date_submitted' },
            { data: 'ticket_id', name: 'ticket_id', visible: false},
            { data: 'sdc_no', name: 'sdc_no', visible: false}
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
                        var status = "DONE";
                    
                        return `<a href='/system/${row.id}/print/' class='table__subject' target='_blank'>${row.subject}</a><br>
                        <span class='table__info'>Ticket #: ${row.ticket_id}</span>
                        <span class='table__info'>SDC #: ${row.id}</span>\t
                        <span class='table__info'>${status} </span>
                         `
                    }

                 }  
         ]
    };

    const allAPP = {
        processing: true,
        serverSide: true,
        order: [[4, 'desc']],
        "bPaginate": true,
        "sPaginationType": "full_numbers",
        ajax: '/datacorrections/app-data/all',
        columns: [
            { data: 'subject', name: 'subject' },
            { data: 'requestor_name', name: 'requestor_name' },
            { data: 'department', name: 'department' },
            { data: 'position', name: 'position' },
            { data: 'date_submitted', name: 'date_submitted' },
            { data: 'ticket_id', name: 'ticket_id', visible: false},
            { data: 'sdc_no', name: 'sdc_no', visible: false}
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
                        var status = "";
                        if(row.status == 3){
                            status = "PENDING";
                            return `<a href='/sdc/${row.id}/edit/' class='table__subject'>${row.subject}</a><br>
                            <span class='table__info'>Ticket #: ${row.ticket_id}</span>
                            <span class='table__info'>SDC #: ${row.id}</span>\t
                            <span class='table__info'>${status} </span>
                             `
                        }else if(row.status >= 4){
                            status = "DONE";
                            return `<a href='/system/${row.id}/print/' class='table__subject' target='_blank'>${row.subject}</a><br>
                            <span class='table__info'>Ticket #: ${row.ticket_id}</span>
                            <span class='table__info'>SDC #: ${row.id}</span>\t
                            <span class='table__info'>${status} </span>
                             `
                        }
                      
                    }

                 }  
         ]
    };
// END OF APPROVER TABLE OPTIONS
try {
    

    let dcUser,dcStatus;
    let dcURegex = new RegExp('\/datacorrections\/([a-z]+)', 'gm');
    dcUser = dcURegex.exec(window.location.pathname)[1];

    switch(dcUser){
        case 'ty':
            dcRegex = new RegExp('\/datacorrections\/ty\/sdc\/([a-z]+)', 'gm');
            dcStatus = dcRegex.exec(window.location.pathname)[1];

            switch(dcStatus){
                case "pending":
                    $('#treasury-table').DataTable(pendingTreasury);
                break;
                case "done":
                    $('#treasury-table').DataTable(doneTreasury);
                break;
                case "all":
                    $('#treasury-table').DataTable(allTreasury);
                break;
            }
        break;
        case 'gc':
            dcRegex = new RegExp('\/datacorrections\/gc\/sdc\/([a-z]+)', 'gm');
            dcStatus = dcRegex.exec(window.location.pathname)[1];

            switch(dcStatus){
                case "pending":
                    $('#gc-table').DataTable(pendingGC);
                break;
                case "done":
                    $('#gc-table').DataTable(doneGC);
                break;
                case "all":
                    $('#gc-table').DataTable(allGC);
                break;
            }
        break;
        case 'app':
        dcRegex = new RegExp('\/datacorrections\/app\/sdc\/([a-z]+)', 'gm');
        dcStatus = dcRegex.exec(window.location.pathname)[1];

        switch(dcStatus){
            case "pending":
                $('#app-table').DataTable(pendingAPP);
            break;
            case "done":
                $('#app-table').DataTable(doneApp);
            break;
            case "all":
                $('#app-table').DataTable(allAPP);
            break;
        }

        break;
    }

} catch (error) {
    
}

//  SUPPORTS DATATABLE

// let dcStats;
// let dcStatsRegex = new RegExp('\/datacorrections\/sdc\/([a-z]+)', 'gm');
// dcStats = dcStatsRegex.exec(window.location.pathname)[1];
 
// switch(dcStats){
//     case "approved":
//         $('#sdc-table').DataTable($sdcapproved);
//     break;

// }
    
    
});