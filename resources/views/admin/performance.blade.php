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
                                    <!-- ko foreach: $root.current.studentAttendances -->
                                    <!-- ko if: $data.student.id == $parentContext.$data.id -->
                                    <!-- ko if: $data.occupationType === "lecture" -->
                                    <span data-bind="$data.student"></span>
                                    <td rel="toggle" class="state0"
                                        data-bind="attr: {'id': 'toggleLecture'+$parentContext.$index()+'_'+$index()},
                                                 click: function () {$root.current.showToggleLecture($index(),$parentContext.$index())}">
                                    </td>
                                    <!-- /ko -->
                                    <!-- /ko -->
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
                                    <!-- ko foreach: $root.current.studentAttendances -->
                                    <!-- ko if: $data.student.id == $parentContext.$data.id -->
                                    <!-- ko if: $data.occupationType === "practical" -->
                                    <td rel="toggle" class="state0"
                                        data-bind="attr: {'id': 'togglePractical'+$parentContext.$index()+'_'+$index()},
                                                 click: function () {$root.current.showTogglePractical($index(),$parentContext.$index())}">
                                    </td>
                                    <!-- /ko -->
                                    <!-- /ko -->
                                    <!-- /ko -->
                                </tr>
                                </tbody>

                            </table>
                        </section>
                        <section id="content-tab3" class="table-wrapper"
                                 data-bind="visible: $root.current.tableWidthLaboratory().length > 0">
                            <table>
                                <thead class="items-body">

                                <tr>
                                    <th>
                                        <span class="info">СТУДЕНТ</span>
                                    </th>
                                    <!-- ko foreach: $root.current.tableWidthLaboratory -->
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
                                    <!-- ko foreach: $root.current.studentProgresses -->
                                    <!-- ko if: $data.student.id == $parentContext.$data.id -->
                                    <td rel="input">
                                        <input data-bind="attr: {'id': 'inputLaboratory'+$parentContext.$index()+'_'+$index()},
                                               click: function () {$root.current.showToggleLaboratory($index(),$parentContext.$index())}"
                                               class="filter-input">
                                    </td>
                                    <!-- /ko -->
                                    <!-- /ko -->
                                </tr>
                                </tbody>
                            </table>
                        </section>
                        {{--<div class="details-row float-buttons">--}}
                            {{--<div class="details-column float-right width-100p">--}}
                                {{--<button class="cancel" data-bind="click: $root.actions.cancel">Отмена</button>--}}
                                {{--<button id="bUpdateStudyplanItem" accept-validation title="Проверьте правильность заполнения полей"--}}
                                        {{--class="approve" data-bind="click: $root.actions.end.update">Сохранить--}}
                                {{--</button>--}}
                            {{--</div>--}}
                        {{--</div>--}}
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


