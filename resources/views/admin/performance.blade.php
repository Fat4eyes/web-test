@extends('layouts.manager')
<link rel="stylesheet" href="{{ URL::asset('css/app.css')}}"/>
<link rel="stylesheet" href="{{ URL::asset('css/performance.css')}}"/>
@section('title', 'Успеваемость')
@section('javascript')
    <script src="{{ URL::asset('js/min/manager-performance.js')}}"></script>
@endsection

@section('content')
    <div class="performance-wrapper">
        <div class="row">
            <div class="col-lg-11">
                <div class="performance-wrapper">
                    <h1 class="head-text">Учет успеваемости студентов</h1>
                    <hr class="petails">

                    <div class="tabs">
                        <input id="tab1" type="radio" name="tabs" checked>
                        <label for="tab1" title="Вкладка 1">Лекции</label>

                        <input id="tab2" type="radio" name="tabs">
                        <label for="tab2" title="Вкладка 2">Практические занятия</label>

                        <input id="tab3" type="radio" name="tabs">
                        <label for="tab3" title="Вкладка 3">Лабораторные</label>

                        <section id="content-tab1" class="table-wrapper"
                                 data-bind="visible: $root.current.tableWidthLecture().length > 0">
                            <table>
                                <thead>
                                <tr>
                                    <th>
                                        <span class="info">СТУДЕНТ</span>
                                    </th>
                                    <!-- ko foreach: $root.current.tableWidthLecture -->
                                    <th>
                                        <span class="info" data-bind="text: $data"></span>
                                    </th>
                                    <!-- /ko -->
                                </tr>
                                </thead>
                                <tbody data-bind='foreach: $root.current.students'>
                                <tr>
                                    <td style="padding-bottom: 6px; padding-top: 6px;">
                                        <span class="info-performance"
                                              data-bind="text: $root.current.student().studentInitials($data)"></span>
                                    </td>
                                    <!-- ko foreach: $root.current.tableWidthLecture -->
                                    <td rel="toggle" class="state0"
                                        data-bind="attr: {'id': 'toggleLecture'+$parentContext.$index()+'_'+$index()},
                                                 click: function () {$root.current.showToggleLecture($index(),$parentContext.$index())}">
                                    </td>
                                    <!-- /ko -->
                                </tr>
                                </tbody>
                            </table>
                        </section>
                        <section id="content-tab2" class="table-wrapper"
                                 data-bind="visible: $root.current.tableWidthPractical().length > 0">
                            <table>
                                <thead class="items-body">

                                <tr>
                                    <th>
                                        <span class="info">СТУДЕНТ</span>
                                    </th>
                                    <!-- ko foreach: $root.current.tableWidthPractical -->
                                    <th>
                                        <span class="info" data-bind="text: $data"></span>
                                    </th>
                                    <!-- /ko -->
                                </tr>
                                </thead>
                                <tbody class="items-body" data-bind='foreach: $root.current.students'>
                                <tr>
                                    <td style="padding-bottom: 6px; padding-top: 6px;">
                                        <span class="info-performance"
                                              data-bind="text: $root.current.student().studentInitials($data)"></span>
                                    </td>
                                    <!-- ko foreach: $root.current.tableWidthPractical -->
                                    <td rel="toggle" class="state0"
                                        data-bind="attr: {'id': 'togglePractical'+$parentContext.$index()+'_'+$index()},
                                                 click: function () {$root.current.showTogglePractical($index(),$parentContext.$index())}">
                                    </td>
                                    <!-- /ko -->
                                </tr>
                                </tbody>

                            </table>
                        </section>
                        <section id="content-tab3" class="table-wrapper"
                                 data-bind="visible: $root.current.tableWidthLaboratory().length > 0">
                            <table>
                                <thead class="items-body">

                                <tr data-bind='foreach: $root.current.tableWidthLaboratory'>
                                    <th>
                                        <span class="info" data-bind="text: $data"></span>
                                    </th>
                                </tr>
                                </thead>


                                <tbody class="items-body" data-bind='foreach: $root.current.students'>
                                <tr>
                                    <td>
                                        {{--<span class=info data-bind="textI discipline">--}}
                                        <span class="info" data-bind="text: name"></span>

                                        {{--<span class="info" data-bind="text: firstName">.</span>--}}
                                        {{--<span class="info" data-bind="text: patronymic">.</span>--}}
                                    </td>
                                    <td><input type="text" value="21" class="filter-input"></td>
                                    {{--<td>--}}
                                    {{--<span class=info data-bind="textI discipline">--}}
                                    {{--<span class="info" data-bind="text: lastName">.</span>--}}
                                    {{--</td>--}}
                                    <td>
                                        <input data-bind="textInput: firstName" class="filter-input"></input>
                                    </td>
                                    <td><input type="text" value="21" class="filter-input"></td>
                                </tr>
                                </tbody>
                            </table>
                        </section>
                    </div>
                </div>


            </div>
            <div class="filter-performance">
                <div class="filter-block-performance">
                    <label class="title">Направление</label>
                    <select data-bind="options: $root.filter.profiles,
                       optionsText: 'name',
                       value: $root.filter.profile,
                       optionsCaption: 'Выберите направление'"></select>
                </div>
                <div class="filter-block-performance">
                    <label class="title">Группа</label>
                    <select data-bind="options: $root.filter.groups,
                       optionsText: 'name',
                       value: $root.filter.group,
                       optionsCaption: 'Выберите группу',
                       enable: $root.filter.profile"></select>
                </div>
                <div class="filter-block-performance">
                    <label class="title">Дисциплина</label>
                    <select data-bind="options: $root.filter.uniqueDisciplines,
                                         optionsText: function(item) {
                       return item.discipline;
                       },
              value: $root.filter.discipline,
                       optionsCaption: 'Выберите дисциплину',
                       enable: $root.filter.group"></select>
                </div>
                <div class="filter-block-performance">
                    <label class="title">Семестр</label>
                    <select data-bind="options: $root.filter.semesters,
                                         optionsText: function(item) {
                       return item.semester + ' семестр'
                       },
              value: $root.filter.semester,
                       optionsCaption: 'Выберите семестр',
                       enable: $root.filter.discipline"></select>
                </div>
            </div>
        </div>
    </div>
@endsection


