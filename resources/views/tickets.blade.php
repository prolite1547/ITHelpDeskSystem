@extends('layouts.dashboardLayout')
@section('title','Tickets')

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
                <table class="table">
                    <thead class="table__thead">
                        <th class="table__th"></th>
                    </thead>
                    <tbody class="table__tbody">
                        <tr>
                            <td class="table__td"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
@endsection


