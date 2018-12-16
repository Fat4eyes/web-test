@extends('layouts.manager')
    <link rel="stylesheet" href="{{ URL::asset('css/app.css')}}"/>
    <link rel="stylesheet" href="{{ URL::asset('css/performance.css')}}"/>
@section('title', 'Успеваемость')
@section('javascript')
    <script src="{{ URL::asset('js/min/manager-performance.js')}}"></script>
@endsection

@section('content')

    <div class="performance-wrapper">
        <h1 class="head-text">Учет успеваемости студентов</h1>
        <hr class="petails">
        <div class="row">
            <div class="first-select">
                <label class="grey-title">Название дисциплины <span class="required">*</span></label>
                <select class="inside-select">
                    <option selected disabled>Выберите дисциплину</option>
                    <option>Пункт 1</option>
                    <option>Пункт 2</option>
                </select>
            </div>
            <div class="second-select">
                <label class="grey-title">Название группы <span class="required">*</span></label>
                <select class="inside-select">
                    <option selected disabled>Выберите группу</option>
                    <option>Пункт 1</option>
                    <option>Пункт 2</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="table-wrapper">
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
                    <tr>
                        <td>Студент 1</td>
                        <td><input type="text" value="" class="filter-input"></td>
                        <td><input type="text" value="" class="filter-input"></td>
                        <td><input type="text" value="" class="filter-input"></td>
                        <td><input type="text" value="" class="filter-input"></td>
                        <td><input type="text" value="" class="filter-input"></td>
                        <td><input type="text" value="" class="filter-input"></td>
                        <td><input type="text" value="" class="filter-input"></td>
                        <td><input type="text" value="" class="filter-input"></td>
                        <td><input type="text" value="" class="filter-input"></td>
                        <td><input type="text" value="" class="filter-input"></td>
                        <td><input type="text" value="" class="filter-input"></td>
                        <td><input type="text" value="" class="filter-input"></td>
                    </tr>
                    <tr>
                        <td>Студент 2</td>
                        <td><input type="text" value="" class="filter-input"></td>
                        <td><input type="text" value="" class="filter-input"></td>
                        <td><input type="text" value="" class="filter-input"></td>
                        <td><input type="text" value="" class="filter-input"></td>
                        <td><input type="text" value="" class="filter-input"></td>
                        <td><input type="text" value="" class="filter-input"></td>
                        <td><input type="text" value="" class="filter-input"></td>
                        <td><input type="text" value="" class="filter-input"></td>
                        <td><input type="text" value="" class="filter-input"></td>
                        <td><input type="text" value="" class="filter-input"></td>
                        <td><input type="text" value="" class="filter-input"></td>
                        <td><input type="text" value="" class="filter-input"></td>
                    </tr>
                    <tr>
                        <td>Студент 3</td>
                        <td><input type="text" value="" class="filter-input"></td>
                        <td><input type="text" value="" class="filter-input"></td>
                        <td><input type="text" value="" class="filter-input"></td>
                        <td><input type="text" value="" class="filter-input"></td>
                        <td><input type="text" value="" class="filter-input"></td>
                        <td><input type="text" value="" class="filter-input"></td>
                        <td><input type="text" value="" class="filter-input"></td>
                        <td><input type="text" value="" class="filter-input"></td>
                        <td><input type="text" value="" class="filter-input"></td>
                        <td><input type="text" value="" class="filter-input"></td>
                        <td><input type="text" value="" class="filter-input"></td>
                        <td><input type="text" value="" class="filter-input"></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection


