@extends('layouts.manager')
<link rel="stylesheet" href="{{ URL::asset('css/app.css')}}"/>
<link rel="stylesheet" href="{{ URL::asset('css/performance.css')}}"/>
@section('title', 'Успеваемость')
@section('javascript')
    <script src="{{ URL::asset('js/min/manager-performance.js')}}"></script>
@endsection

@section('content')
    <div class="content">
        <div class="items">
            <div class="performance-wrapper">
                <h1 class="head-text">Учет успеваемости студентов</h1>
                <hr class="petails">
                {{--<div class="row">--}}
                    {{--<div class="first-select">--}}
                        {{--<label class="grey-title">Название дисциплины <span class="required">*</span></label>--}}
                        {{--<select class="inside-select">--}}
                            {{--<option selected disabled>Выберите дисциплину</option>--}}
                            {{--<option>Пункт 1</option>--}}
                            {{--<option>Пункт 2</option>--}}
                        {{--</select>--}}
                    {{--</div>--}}
                    {{--<div class="second-select">--}}
                        {{--<label class="grey-title">Название группы <span class="required">*</span></label>--}}
                        {{--<select class="inside-select">--}}
                            {{--<option selected disabled>Выберите группу</option>--}}
                            {{--<option>Пункт 1</option>--}}
                            {{--<option>Пункт 2</option>--}}
                        {{--</select>--}}
                    {{--</div>--}}
                {{--</div>--}}
                <div class="row">
                    <div class="table-wrapper" data-bind="visible: $root.current.students().length > 0">
                        <table>
                            <tr>
                                <th>СТУДЕНТЫ</th>
                                <th>ЛЕК 1</th>
                                <th>ЛЕК 2</th>
                                <th>ЛЕК 3</th>
                                <th>ЛЕК 1</th>
                                <th>ПРЗ 1</th>
                                <th>ПРЗ 2</th>
                                <th>ПРЗ 3</th>
                                <th>ПРЗ 4</th>
                                <th>ЛАБ 1</th>
                                <th>ЛАБ 2</th>
                                <th>ЛАБ 3</th>
                                <th>ЛАБ 4</th>
                            </tr>




                            <tbody class="items-body" data-bind='foreach: $root.current.students'>
                            <tr>
                                <td>
                                    {{--<span class=info data-bind="textI discipline">--}}
                                    <span class="info" data-bind="text: lastName"></span>
                                    <span class="info" data-bind="text: firstName">.</span>
                                    <span class="info" data-bind="text: patronymic">.</span>
                                </td>
                                {{--<td>--}}
                                    {{--<span class=info data-bind="textI discipline">--}}
                                    {{--<span class="info" data-bind="text: lastName">.</span>--}}
                                {{--</td>--}}
                                {{--<td>--}}
                                    {{--<span class=info data-bind="textI discipline">--}}
                                    {{--<span class="info" data-bind="text: patronymic">.</span>--}}
                                {{--</td>--}}
                                <td>
                                    <input data-bind="textInput: firstName" class="filter-input"></input>
                                </td>


                                <td><input type="text" value="11"></td>
                                <td><input type="text" value="21" class="filter-input"></td>
                                <td><input type="text" value="33" class="filter-input"></td>
                                <td><input type="text" value="33" class="filter-input"></td>
                                <td><input type="text" value="12" class="filter-input"></td>
                                <td><input type="text" value="32" class="filter-input"></td>
                                <td><input type="text" value="44" class="filter-input"></td>
                                <td><input type="text" value="33" class="filter-input"></td>
                                <td><input type="text" value="12" class="filter-input"></td>
                                <td><input type="text" value="32" class="filter-input"></td>
                                <td><input type="text" value="44" class="filter-input"></td>

                            </tr>





                            {{--<tr>--}}
                                {{--<td>Студент 1</td>--}}
                                {{--<td><input type="text" value="" class="filter-input"></td>--}}
                                {{--<td><input type="text" value="" class="filter-input"></td>--}}
                                {{--<td><input type="text" value="" class="filter-input"></td>--}}
                                {{--<td><input type="text" value="" class="filter-input"></td>--}}
                                {{--<td><input type="text" value="" class="filter-input"></td>--}}
                                {{--<td><input type="text" value="" class="filter-input"></td>--}}
                                {{--<td><input type="text" value="" class="filter-input"></td>--}}
                                {{--<td><input type="text" value="" class="filter-input"></td>--}}
                                {{--<td><input type="text" value="" class="filter-input"></td>--}}
                                {{--<td><input type="text" value="" class="filter-input"></td>--}}
                                {{--<td><input type="text" value="" class="filter-input"></td>--}}
                                {{--<td><input type="text" value="" class="filter-input"></td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                                {{--<td>Студент 2</td>--}}
                                {{--<td><input type="text" value="" class="filter-input"></td>--}}
                                {{--<td><input type="text" value="" class="filter-input"></td>--}}
                                {{--<td><input type="text" value="" class="filter-input"></td>--}}
                                {{--<td><input type="text" value="" class="filter-input"></td>--}}
                                {{--<td><input type="text" value="" class="filter-input"></td>--}}
                                {{--<td><input type="text" value="" class="filter-input"></td>--}}
                                {{--<td><input type="text" value="" class="filter-input"></td>--}}
                                {{--<td><input type="text" value="" class="filter-input"></td>--}}
                                {{--<td><input type="text" value="" class="filter-input"></td>--}}
                                {{--<td><input type="text" value="" class="filter-input"></td>--}}
                                {{--<td><input type="text" value="" class="filter-input"></td>--}}
                                {{--<td><input type="text" value="" class="filter-input"></td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                                {{--<td>Студент 3</td>--}}
                                {{--<td><input type="text" value="" class="filter-input"></td>--}}
                                {{--<td><input type="text" value="" class="filter-input"></td>--}}
                                {{--<td><input type="text" value="" class="filter-input"></td>--}}
                                {{--<td><input type="text" value="" class="filter-input"></td>--}}
                                {{--<td><input type="text" value="" class="filter-input"></td>--}}
                                {{--<td><input type="text" value="" class="filter-input"></td>--}}
                                {{--<td><input type="text" value="" class="filter-input"></td>--}}
                                {{--<td><input type="text" value="" class="filter-input"></td>--}}
                                {{--<td><input type="text" value="" class="filter-input"></td>--}}
                                {{--<td><input type="text" value="" class="filter-input"></td>--}}
                                {{--<td><input type="text" value="" class="filter-input"></td>--}}
                                {{--<td><input type="text" value="" class="filter-input"></td>--}}
                            {{--</tr>--}}
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="filter">
            <div class="filter-block">
                <label class="title">Направление</label>
                <select data-bind="options: $root.filter.profiles,
                       optionsText: 'name',
                       value: $root.filter.profile,
                       optionsCaption: 'Выберите направление'"></select>
            </div>
            <div class="filter-block">
                <label class="title">Группа</label>
                <select data-bind="options: $root.filter.groups,
                       optionsText: 'name',
                       value: $root.filter.group,
                       optionsCaption: 'Выберите группу',
                       enable: $root.filter.profile"></select>
            </div>
            <div class="filter-block">
                <label class="title">Дисциплина</label>
                <select data-bind="options: $root.filter.disciplines,
                       optionsText: 'name',
                       value: $root.filter.discipline,
                       optionsCaption: 'Выберите дисциплину',
                       enable: $root.filter.profile"></select>
            </div>
        </div>
        {{--<div class="filter">--}}
        {{--<div class="filter-block">--}}
        {{--<label class="title">Дисциплина</label>--}}
        {{--<select data-bind="options: $root.multiselect.data,--}}
        {{--optionsText: 'name',--}}
        {{--value: $root.filter.profile,--}}
        {{--optionsCaption: 'Выберите дисциплину'"></select>--}}
        {{--</div>--}}
        {{--<div class="filter-block">--}}
        {{--<label class="title">Группа</label>--}}
        {{--<select data-bind="options: $root.multiselect.data,--}}
        {{--optionsText: 'name',--}}
        {{--value: $root.filter.profile,--}}
        {{--optionsCaption: 'Выберите группу'"></select>--}}
        {{--</div>--}}
        {{--<div class="filter-block">--}}
        {{--<span class="clear" data-bind="click: $root.filter.clear">Очистить</span>--}}
        {{--</div>--}}
        {{--</div>--}}
    </div>
@endsection


