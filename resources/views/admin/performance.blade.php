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
                            <table style="float: left; width: auto; border-right:none" class="perf">
                                <thead>
                                <tr>
                                    <th style="height: 54px;">
                                        <span class="info">СТУДЕНТ</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody data-bind='foreach: $root.current.students'>
                                <tr>
                                    <td height="40px"
                                        style="padding-bottom: 6px; padding-top: 6px;">
                                        <span class="info-performance"
                                              data-bind="text: $root.current.student().studentInitials($data.student)"></span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                            <div style="overflow-y:auto; overflow-x:auto;">
                                <table style="overflow: auto; float: left; width: 100%" class="perf">
                                    <thead>
                                    <tr>
                                        <!-- ko foreach: $root.current.tableWidthLecture -->
                                        <th height="54px" width="30px">
                                            <span class="info" data-bind="text: $data"></span>
                                        </th>
                                        <!-- /ko -->
                                    </tr>
                                    </thead>
                                    <tbody data-bind='foreach: $root.current.students'>
                                    <tr>
                                        <!-- ko foreach: $data.studentAttendances -->
                                        <!-- ko if: $data.occupationType === "lecture" -->
                                        <span data-bind="$data.student"></span>
                                        <td height="40px" width="30px"
                                            rel="toggle"
                                            data-bind="attr: {'id': 'toggleLecture'+$parentContext.$index()+'_'+$index(), 'class': 'state'+$data.visitStatus},
                                                 click: function () {$root.current.showToggleLecture($index(),$parentContext.$index())}">
                                        </td>
                                        <!-- /ko -->
                                        <!-- /ko -->
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </section>

                        <section id="content-tab2" class="table-wrapper"
                                 data-bind="visible: $root.current.tableWidthPractical().length > 0">
                            <table style="float: left; width: auto; border-right:none"  class="perf">
                                <thead>
                                <tr>
                                    <th style="height: 54px;">
                                        <span class="info">СТУДЕНТ</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody data-bind='foreach: $root.current.students'>
                                <tr>
                                    <td height="40px"
                                        style="padding-bottom: 6px; padding-top: 6px;">
                                        <span class="info-performance"
                                              data-bind="text: $root.current.student().studentInitials($data.student)"></span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                            <div style="overflow-y:auto; overflow-x:auto;">
                                <table style="overflow: auto; float: left; width: 100%"  class="perf">
                                    <thead>
                                    <tr>
                                        <!-- ko foreach: $root.current.tableWidthPractical -->
                                        <th height="54px" width="30px">
                                            <span class="info" data-bind="text: $data"></span>
                                        </th>
                                        <!-- /ko -->
                                    </tr>
                                    </thead>
                                    <tbody data-bind='foreach: $root.current.students'>
                                    <tr>
                                        <!-- ko foreach: $data.studentAttendances -->
                                        <!-- ko if: $data.occupationType === "practical" -->
                                        <td height="40px" width="30px"
                                            rel="toggle"
                                            data-bind="attr: {'id': 'togglePractical'+$parentContext.$index()+'_'+$index(), 'class': 'state'+$data.visitStatus},
                                                 click: function () {$root.current.showTogglePractical($index(),$parentContext.$index())}">
                                        </td>
                                        <!-- /ko -->
                                        <!-- /ko -->
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </section>

                        <section id="content-tab3" class="table-wrapper"
                                 data-bind="visible: $root.current.tableWidthLaboratory().length > 0">
                            <table style="float: left; width: auto; border-right:none">
                                <thead>
                                <tr>
                                    <th style="height: 54px;">
                                        <span class="info">СТУДЕНТ</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody data-bind='foreach: $root.current.students' class="perf">
                                <tr>
                                    <td height="40px"
                                        style="padding-bottom: 6px; padding-top: 6px;">
                                        <span class="info-performance"
                                              data-bind="text: $root.current.student().studentInitials($data.student)"></span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                            <div style="overflow-y:auto; overflow-x:auto;">
                                <table style="overflow: auto; float: left; width: 100%">
                                    <thead>
                                    <tr>
                                        <!-- ko foreach: $root.current.tableWidthLaboratory -->
                                        <th height="54px" width="30px">
                                            <span class="info" data-bind="text: $data"></span>
                                        </th>
                                        <!-- /ko -->
                                    </tr>
                                    </thead>
                                    <tbody data-bind='foreach: $root.current.students' class="perf">
                                    <tr>
                                        <!-- ko foreach: $data.studentProgresses -->
                                        <td height="40px" width="30px" style="padding: 0px">
                                            <table class="cell-table">
                                                <tr>
                                                    <td style="border: 0px; padding: 0px"
                                                        rel="input">
                                                        <input style="background: #EDEEF0; border: none"
                                                               type="text" validate
                                                               data-bind="attr: {'id': 'inputLaboratory'+$parentContext.$index()+'_'+$index()},
                                               value: $data.workMark,
                                               validationElement: workMark"
                                                               class="filter-input">
                                                    </td>
                                                </tr>
                                                <!-- ko ifnot: $data.updatedAt == null -->
                                                <tr>
                                                    <td class="cell-date">
                                                        <span style="font-size: x-small"
                                                              data-bind="text: $root.current.studentProgress().formattedDate($data.updatedAt)"></span>
                                                    </td>
                                                </tr>
                                                <!-- /ko -->
                                            </table>
                                        </td>
                                        <!-- /ko -->
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </section>
                        <div class="details-row float-buttons">
                            <div class="details-column float-right width-100p">
                                <button class="cancel" data-bind="click: $root.actions.cancel">Отмена</button>
                                <button id="bUpdateStudyplanItem"
                                        {{--accept-validation title="Проверьте правильность заполнения полей"--}}
                                        class="approve" data-bind="click: $root.actions.update">Сохранить
                                </button>
                            </div>
                        </div>
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


