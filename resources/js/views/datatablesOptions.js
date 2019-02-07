const userTickets = {
    ajax: '/tickets/ticket-data/user',
    order: [[5, 'desc']],
    columns: [
        {data: null,name: 'tickets.id'},
        {data: 'category', visible: false,name:'cat.name'},
        {data: 'priority'},
        {data: 'status', name:'status.name',orderable: false},
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
        {data: null,name: 'tickets.id'},
        {data: 'category', visible: false,defaultContent: 'Not Set'},
        {data: 'priority',defaultContent: 'Not Set'},
        {data: 'status', orderable: false,defaultContent: 'Not Set'},
        {data: 'store_name',name:'stores.store_name'},
        {data: 'created_at',visible: true},
        {data: 'expiration',defaultContent: 'Not Set'},
        {data: 'id', orderable: false}
    ],

};

const expiredTickets = {
    ajax: '/tickets/ticket-data/expired',
    order: [[4, 'desc']],
    columns: [
        {data: null,name: 'tickets.id'},
        {data: 'category', visible: false,name:'cat.name'},
        {data: 'priority'},
        {data: 'status', name:'status.name',orderable: false},
        {data: 'store_name',name:'stores.store_name'},
        {data: 'created_at',visible: true},
        {data: 'expiration'},
        {data: 'assignee',visible: true},
        {data: 'id', orderable: false}
    ],
};

const ongoingTickets = {
    ajax: '/tickets/ticket-data/ongoing',
    order: [[5, 'desc']],
    columns: [
        {data: null,name: 'tickets.id'},
        {data: 'category', visible: false,name:'cat.name'},
        {data: 'priority'},
        {data: 'status', name:'status.name',orderable: false},
        {data: 'store_name',name:'stores.store_name'},
        {data: 'created_at',visible: true},
        {data: 'expiration'},
        {data: 'assignee',visible: true},
        {data: 'id', orderable: false}
    ],
};

const closedTickets = {
    ajax: '/tickets/ticket-data/closed',
    order: [[4, 'desc']],
    columns: [
        {data: null,name: 'tickets.id'},
        {data: 'category',visible: false},
        {data: 'priority'},
        {data: 'status', name:'status.name',orderable: false},
        {data: 'store_name',name:'stores.store_name'},
        {data: 'created_at',visible: true},
        {data: 'expiration',visible: false},
        {data: 'resolved_date'},
        {data: 'assignee',visible: true},
        {data: 'resolved_by',visible: true},
        {data: 'id', orderable: false}
    ],
};

const fixedTickets = {
    ajax: '/tickets/ticket-data/fixed',
    order: [[4, 'desc']],
    columns: [
        {data: null,name: 'tickets.id'},
        {data: 'category', visible: false,name:'cat.name'},
        {data: 'priority'},
        {data: 'status', name:'status.name',orderable: false},
        {data: 'store_name',name:'stores.store_name'},
        {data: 'created_at',visible: true},
        {data: 'expiration',visible: false},
        {data: 'fixed_date'},
        {data: 'assignee',visible: true},
        {data: 'id', orderable: false}
    ],
};

const allTickets = {
    ajax: '/tickets/ticket-data/all',
    order: [[5, 'desc']],
    columns: [
        {data: null,name: 'tickets.id'},
        {data: 'category', visible: false,name:'cat.name'},
        {data: 'priority'},
<<<<<<< HEAD
        {data: 'status', name:'status.name',orderable: false},
=======
        {data: 'status', orderable: false},
>>>>>>> 5569d51a4d7ec9ad315bb9cc55d8061eeb5ed5f5
        {data: 'store_name',name:'stores.store_name'},
        {data: 'created_at',visible: true},
        {data: 'expiration'},
        {data: 'assignee',visible: true},
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
    }  else if (ticketStatus === 'fixed') {
        options = fixedTickets;
    }else if (ticketStatus === 'expired') {
        options = expiredTickets;
    }else {
        console.log('ticket status not found');
    }


    /*APPLY THE GENERATED DATATABLE OPTION*/
    return $('table').DataTable(options);



};
