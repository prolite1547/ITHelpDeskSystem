@extends('layouts.ticketLayout')
@section('title','Tickets')

@section('table')
    <table class="table" id="tickets-table">
        <thead class="table__thead">
        <th class="table__th">Subject</th>
        <th class="table__th">Status</th>
        <th class="table__th">Branch</th>
        <th class="table__th">Created At</th>
        <th class="table__th">Closed Date</th>
        <th class="table__th">Resolved By</th>
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
                ajax: '{!! route('datatables.tickets',['status' => 'closed']) !!}',
                order: [[4,'desc']],
                columns: [
                    { data: 'subject_display',name:'incident.subject'},
                    { data: 'status',orderable: false},
                    { data: 'store_name',name:'incident.call.contact.store.store_name'},
                    { data: 'created_at',visible:true},
                    { data: 'resolve.created_at'},
                    { data: 'resolve.resolved_by.name'},
                ]
            });
        });
    </script>
@endpush


