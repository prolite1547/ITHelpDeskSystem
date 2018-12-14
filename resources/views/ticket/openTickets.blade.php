@extends('layouts.ticketLayout')
@section('title','Open Tickets')

@section('table')
    <table class="table" id="tickets-table">
        <thead class="table__thead">
        <th class="table__th">Subject</th>
        <th class="table__th">Priority</th>
        <th class="table__th">Status</th>
        <th class="table__th">Branch</th>
        <th class="table__th" title="">Created At</th>
        <th class="table__th">Expiration Date</th>
        <th class="table__th"><input type="checkbox"></th>
        </thead>
        <tbody class="table__tbody">

        </tbody><tbody class="table__tbody">

        </tbody>
    </table>
@endsection

@push('scripts')
    <script>
        $(function() {
            $('#tickets-table').DataTable({
                ajax: '{!! route('datatables.tickets',['status' => 'open']) !!}',
                order: [[4,'desc']],
                columns: [
                    { data: 'subject_display',name:'incident.subject'},
                    { data: 'priority',name:'priorityRelation.order'},
                    { data: 'status',orderable: false},
                    { data: 'store_name',name:'incident.call.contact.store.store_name'},
                    { data: 'created_at',name:'created_at',visible:true,createdCell: (cell,cellData,rowData) => {
                            cell.textContent = moment(cell.textContent).fromNow();
                            cell.setAttribute('title',cellData);
                        }},
                    { data: 'expiration',defaultContent: '<span>TAE</span>',render:(data,type,row) => {
                           return data.toLowerCase() === 'expired' ? `<span class="expired">${data}</span>` : data;
                        }},
                    { data: 'action' ,orderable: false,className: 'select-checkbox'}
                ],
                select: {
                    style:    'os',
                    selector: 'td:last-child'
                }
            });
        });
    </script>
@endpush


