@extends('layouts.ticketLayout')
@section('title','Ongoing Tickets')

@section('table')
    <table class="table responsive" id="tickets-table">
        <thead class="table__thead">
        <tr>
        <th class="table__th">Subject</th>
        <th class="table__th">Category</th>
        <th class="table__th">Priority</th>
        <th class="table__th">Status</th>
        <th class="table__th">Branch</th>
        <th class="table__th">Created At</th>
        <th class="table__th">Expiration Date</th>
        <th class="table__th">Assignee</th>
        <th class="table__th"><input type="checkbox"></th>
        </tr>
        </thead>
        <tbody class="table__tbody">

        </tbody>
    </table>
@endsection


