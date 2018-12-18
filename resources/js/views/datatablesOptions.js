const userTickets = {
    ajax: '/tickets/ticket-data/user',
    order: [[5, 'desc']],
    columns: [
        {data: 'id'},
        {data: 'category',name:'cat.name', visible: false},
        {data: 'priority',name:'prio.name'},
        {data: 'status',name:'status.name', orderable: false},
        {data: 'store_name',name:'stores.store_name'},
        {data: 'created_at',visible: true},
        {data: 'expiration'},
        {data: 'id', orderable: false}
    ],

};


const openTickets = {
    ajax: '/tickets/ticket-data/open',
    order: [[5, 'desc']],
    columns: [
        {data: 'id'},
        {data: 'category',name:'cat.name', visible: false},
        {data: 'priority',name:'prio.name'},
        {data: 'status',name:'status.name', orderable: false},
        {data: 'store_name',name:'stores.store_name'},
        {data: 'created_at',visible: true},
        {data: 'expiration'},
        {data: 'id', orderable: false}
    ],

};

const ongoingTickets = {
    ajax: '/tickets/ticket-data/ongoing',
    order: [[5, 'desc']],
    columns: [
        {data: 'id'},
        {data: 'category',name:'cat.name', visible: false},
        {data: 'priority',name:'prio.name'},
        {data: 'status',name:'status.name', orderable: false},
        {data: 'store_name',name:'stores.store_name'},
        {data: 'created_at',visible: true},
        {data: 'expiration'},
        {data: 'assignee',name:'assignee.name',visible: true},
        {data: 'id', orderable: false}
    ],
};

const closedTickets = {
    ajax: '/tickets/ticket-data/closed',
    order: [[4, 'desc']],
    columns: [
        {data: 'id'},
        {data: 'category',name:'cat.name', visible: false},
        {data: 'priority',name:'prio.name'},
        {data: 'status',name:'status.name', orderable: false},
        {data: 'store_name',name:'stores.store_name'},
        {data: 'created_at',visible: true},
        {data: 'expiration',visible: false},
        {data: 'resolved_date',name:'resolves.created_at'},
        {data: 'resolved_by',name:'resolver.name',visible: true},
        {data: 'id', orderable: false}
    ],
};

const allTickets = {
    ajax: '/tickets/ticket-data/all',
    order: [[5, 'desc']],
    columns: [
        {data: 'id'},
        {data: 'category',name:'cat.name', visible: false},
        {data: 'priority',name:'prio.name'},
        {data: 'status',name:'status.name', orderable: false},
        {data: 'store_name',name:'stores.store_name'},
        {data: 'created_at',visible: true},
        {data: 'expiration'},
        {data: 'assignee',name:'assignee.name',visible: true},
        {data: 'id', orderable: false}
    ]
};









export const initDataTables = () => {

    let options, ticketStatus;

    /*REGEX STRING FOR TICKET ROUTES TO CATURE THE TICKET STATUS*/
    const ticketRegex = new RegExp('\/tickets\/([a-z]+)', 'gm');

    /*GET TICKET STATUS FROM THE URL*/
    ticketStatus = ticketRegex.exec(window.location.pathname)[1];


    /*IF STATEMENT FOR THE RIGHT OPTION TO BE INITIALIZED TO DATATABLE*/
    if (ticketStatus === 'open') {
        options = openTickets;
    } else if (ticketStatus === 'all') {
        options = allTickets;
    } else if (ticketStatus === 'my') {
        options = userTickets;
    } else if (ticketStatus === 'ongoing') {
        options = ongoingTickets;
    } else if (ticketStatus === 'closed') {
        options = closedTickets;
    } else {
        console.log('ticket status not found');
    }


    /*APPLY THE GENERATED DATATABLE OPTION*/
    return $('table').DataTable(options);
    ;


};
