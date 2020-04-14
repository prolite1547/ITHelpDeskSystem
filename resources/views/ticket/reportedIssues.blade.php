@extends('layouts.ticketLayout')
@section('title','Reported Issues')

@section('table')
    <table class="table" id="reported-table" data-department="{{ $department_id }}">
        <thead class="table__thead">
        <tr>
            <th class="table__th">Subject</th>
            <th class="table__th">Branch</th>
            <th class="table__th">Caller</th>
            <th class="table__th">Position</th>
            <th class="table__th">Department</th>
            <th class="table__th">Created At</th>
            <th class="table__th">Group</th>
        </tr>
        </thead>
        <tbody class="table__tbody">

        </tbody>
    </table>
@endsection



