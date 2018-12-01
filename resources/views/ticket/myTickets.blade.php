@extends('layouts.dashboardLayout')
@section('title','My Tickets')

@section('dashboardContent')
    <main>
        <div class="row">
            <div class="col-1-of-4">
                <aside class="side">
                    <div class="side__title">
                        <h3 class="heading-tertiary">Ticket types</h3>
                        <span class="side__filter"><i class="fas fa-filter"></i></span>
                    </div>
                    <div class="side__content">
                        <dl class="side__dl">
                            <dt class="side__dt">All types <span class="side__count">(2)</span></dt>
                            <dd class="side__dd">Incident <span class="side__count">(1)</span></dd>
                            <dd class="side__dd">Request <span class="side__count">(1)</span></dd>
                        </dl>
                    </div>
                </aside>
            </div>
            <div class="col-3-of-4">
                <table class="table" id="tickets-table">
                    <thead class="table__thead">
                    <th class="table__th">Subject</th>
                    <th class="table__th">Priority</th>
                    <th class="table__th">Status</th>
                    <th class="table__th">Branch</th>
                    <th class="table__th">Created At</th>
                    <th class="table__th">Expiration Date</th>
                    <th class="table__th"><input type="checkbox"></th>
                    </thead>
                    <tbody class="table__tbody">

                    </tbody><tbody class="table__tbody">

                    </tbody>
                </table>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        $(function() {
            $('#tickets-table').DataTable({
                ajax: '{!! route('datatables.tickets',['status' => 'user']) !!}',
                order: [[4,'desc']],
                columns: [
                    { data: 'subject_display',name:'incident.subject'},
                    { data: 'priority',name:'priorityRelation.order'},
                    { data: 'status',orderable: false},
                    { data: 'store_name',name:'incident.call.contact.store.store_name'},
                    { data: 'created_at',visible:true},
                    { data: 'expiration'},
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


