const columnStrings = {
    category:'',
    priority:'',
    status_name:'status_name',
    store_name:'store_name',
    created_at:'',
    expiration: '',
    resolved_by: 'resolver',
};


const userTickets = {
    ajax: '/tickets/ticket-data/my',
    order: [[5, 'desc']],
    columns: [
        {data: null,name: 'tickets.id'},
        {data: 'category', visible: false,name:'cat.name'},
        {data: 'priority'},
        {data: columnStrings.status_name, name:'status.name',orderable: false},
        {data: 'store_name',name:columnStrings.store_name},
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
        {data: columnStrings.status_name, orderable: false,defaultContent: 'Not Set'},
        {data: 'store_name',name:columnStrings.store_name},
        {data: 'created_at',visible: true},
        {data: 'expiration',defaultContent: 'Not Set'},
        {data: 'logged_by'},
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
        {data: columnStrings.status_name, name:'status.name',orderable: false},
        {data: 'store_name',name:columnStrings.store_name},
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
        {data: columnStrings.status_name, name:'status.name',orderable: false},
        {data: 'store_name',name:columnStrings.store_name},
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
        {data: columnStrings.status_name, name:'status.name',orderable: false},
        {data: 'store_name',name:columnStrings.store_name},
        {data: 'created_at',visible: true},
        {data: 'expiration',visible: false},
        {data: 'resolved_date'},
        {data: 'assignee',visible: true},
        {data: columnStrings.resolved_by,visible: true},
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
        {data: columnStrings.status_name, name:'status.name',orderable: false},
        {data: 'store_name',name:columnStrings.store_name},
        {data: 'created_at',visible: true},
        {data: 'expiration',visible: false},
        {data: 'fix_date'},
        {data: 'fixed_by',visible: true},
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
        {data: columnStrings.status_name, name:'status.name',orderable: false},
        {data: 'store_name',name:columnStrings.store_name},
        {data: 'created_at',visible: true},
        {data: 'expiration'},
        {data: 'assignee',visible: true},
        {data: 'id', orderable: false}
    ]
};


export const posTickets = {
    ajax: '/tickets/ticket-data/pos',
    order: [[5, 'desc']],
    columns: [
        {data: null,name: 'tickets.id'},
        {data: 'category', visible: false,name:'cat.name'},
        {data: 'priority'},
        {data: columnStrings.status_name, name:'status.name',orderable: false},
        {data: 'store_name',name:columnStrings.store_name},
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
