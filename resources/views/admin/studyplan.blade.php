@extends('layouts.manager')
<link rel="stylesheet" href="{{ URL::asset('css/studyplan.css')}}"/>
<link rel="stylesheet" href="{{ URL::asset('css/app.css')}}"/>
@section('title', 'Учебные планы')
@section('javascript')
    <script src="{{ URL::asset('js/min/manager-studyplan.js')}}"></script>
@endsection
@section('content')

    <div class="performance-wrapper">
        <div class="items-head">
            <h1 class="head-text">Детализация учебного плана</h1>
            <label class="adder" data-bind="click: $root.actions.start.create">Добавить дисциплину</label><br>
            <!-- ko if: $root.user.role() === role.admin.name -->
            <div class="search">
                <div class="filter-block">
                    <label class="title">Дисциплина</label>
                    <input style="width: 200px" type="text" placeholder="Полное название дисциплины"
                           data-bind="value: $root.filter.discipline, valueUpdate: 'keyup'">
                </div>
                <div class="filter-block">
                    <span class="clear" data-bind="click: $root.filter.clear">очистить</span>
                </div>
            </div>
            <!-- /ko -->
        </div>
        <div class="row">
            <!-- ko if: $root.mode() === state.create -->
            <div class="details"
                 data-bind="template: {name: 'create-discipline', data: $root.current.discipline}"></div>
            <!-- /ko -->

            <div class="table-wrapper">
                <table data-bind='visible: $root.current.disciplines().length > 0' cellpadding="5"
                       cellspacing="0">
                    <thead>
                    <tr>
                        <th rowspan="2" colspan="1">Наименование</th>
                        <th rowspan="2" colspan="1">Семестр</th>
                        <th colspan="5">Часы работы</th>
                        <th colspan="3">Количество</th>
                        <th colspan="7">Формы контроля</th>
                    </tr>
                    <tr>
                        <th>Всего</th>
                        <th>Лекций</th>
                        <th>Практ. занятий</th>
                        <th>Лабор. занятий</th>
                        <th>Самост. изучения</th>

                        <th>Лекций</th>
                        <th>Практ. занятий</th>
                        <th>Лабор. работ</th>

                        <th>Экзамен</th>
                        <th>Курс.работа</th>
                        <th>Курс.проект</th>
                        <th>РГЗ</th>
                        <th>Реферат</th>
                        <th>Ауд.КР</th>
                        <th>Дом.КР</th>
                    </tr>
                    </thead>


                    <tbody class="items-body" data-bind='foreach: $root.actions.sortedDiscipline()'>
                    <tr class="item" data-bind="click: $root.actions.show">
                        <td>
                            <span class="info" data-bind="visible: disciplineVisible, text: discipline"></span>
                        </td>
                        <td>
                            <span class="info" data-bind="text: semester"></span>
                        </td>
                        <td>
                            <span class="info" data-bind="text: hoursAll"></span>
                        </td>
                        <td>
                            <span class="info" data-bind="text: hoursLecture"></span>
                        </td>
                        <td>
                            <span class="info" data-bind="text: hoursPractical"></span>
                        </td>
                        <td>
                            <span class="info" data-bind="text: hoursLaboratory"></span>
                        </td>
                        <td>
                            <span class="info" data-bind="text: hoursSolo"></span>
                        </td>
                        <td>
                            <span class="info" data-bind="text: countLecture"></span>
                        </td>
                        <td>
                            <span class="info" data-bind="text: countPractical"></span>
                        </td>
                        <td>
                            <span class="info" data-bind="text: countLaboratory"></span>
                        </td>
                        <td>
                            <span class="info" data-bind="if: hasExam">&#10004;</span>
                        </td>
                        <td>
                            <span class="info" data-bind="if: hasCoursework">&#10004</span>
                        </td>
                        <td>
                            <span class="info" data-bind="if: hasCourseProject">&#10004</span>
                        </td>
                        <td>
                            <span class="info" data-bind="if: hasDesignAssignment">&#10004</span>
                        </td>
                        <td>
                            <span class="info" data-bind="if: hasEssay">&#10004</span>
                        </td>
                        <td>
                            <span class="info" data-bind="if: hasAudienceTest">&#10004</span>
                        </td>
                        <td>
                            <span class="info" data-bind="if: hasHomeTest">&#10004</span>
                        </td>
                    </tr>
                    <!-- ko if: id() === $root.current.discipline().id() -->
                    <!-- ko if: $root.mode() === state.info -->
                    <tr class="details"
                        data-bind="visible: $root.current.discipline().id() > 0,  template: {name: 'update-discipline', data: $root.current.discipline}"></tr>
                    <!-- /ko -->
                    <!-- /ko -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="g-hidden">
        <div class="box-modal" id="remove-discipline-plan-modal">
            <div class="popup-delete">
                <div><h3>Вы действительно хотите удалить выбранную дисциплину?</h3></div>
                <h5 style="color: #a33137">Все данные успеваемости студентов по дисциплине будут удалены</h5>
                <div>
                    <button class="remove arcticmodal-close" data-bind="click: $root.actions.end.remove">Удалить
                    </button>
                    <button class="cancel arcticmodal-close" data-bind="click: $root.actions.cancel">Отмена</button>
                </div>
            </div>
        </div>
    </div>
@endsection



<script type="text/html" id="show-discipline">
    <tr class="details-row">
        <td><label class="title">Семестр</label>
            <span class="info" data-bind="text: semester"></span>
        </td>
        <td><label class="title">Количество часов</label>
            <span class="info" data-bind="text: hoursAll"></span>
        </td>
        <td><label class="title">Часов лекций</label>
            <span class="info" data-bind="text: hoursLecture"></span>
        </td>
        <td><label class="title">Часов лабораторных занятий</label>
            <span class="info" data-bind="text: hoursLaboratory"></span>
        </td>
        <td><label class="title">Часов практических занятий</label>
            <span class="info" data-bind="text: hoursPractical"></span>
        </td>
        <td><label class="title">Часов самостоятельной работы</label>
            <span class="info" data-bind="text: hoursSolo"></span>
        </td>
        <td><label class="title">Количество лекций</label>
            <span class="info" data-bind="text: countLecture"></span>
        </td>
        <td><label class="title">Количество практич. занятий</label>
            <span class="info" data-bind="text: countPractical"></span>
        </td>
        <td><label class="title">Количество лаб. работ</label>
            <span class="info" data-bind="text: countLaboratory"></span>
        </td>
        <td><label class="title">Дополнительные условия сдачи</label>
            <span class="info coloredin-patronus" data-bind="text: hasExam() ? 'Экзамен ' : ''"></span>
            <span class="info coloredin-patronus" data-bind="text: hasCoursework() ? 'Курс.работа ' : ''"></span>
            <span class="info coloredin-patronus" data-bind="text: hasCourseProject() ? 'Курс.проект ' : ''"></span>
            <span class="info coloredin-patronus" data-bind="text: hasDesignAssignment() ? 'РГЗ ' : ''"></span>
            <span class="info coloredin-patronus" data-bind="text: hasEssay() ? 'Реферат ' : ''"></span>
            <span class="info coloredin-patronus" data-bind="text: hasHomeTest() ? 'Дом.КР ' : ''"></span>
            <span class="info coloredin-patronus" data-bind="text: hasAudienceTest() ? 'Ауд.КР ' : ''"></span>
        </td>
    </tr>
    <!-- ko if: $root.user.role() === role.admin.name -->
    <div class="details-row float-buttons">
        <div class="details-column float-right width-100p">
            <button class="remove" data-bind="click: $root.actions.start.remove"><span class="fa">&#xf014;</span>&nbsp;Удалить
            </button>
            <button class="approve" data-bind="click: $root.actions.start.update"><span class="fa">&#xf040;</span>&nbsp;Редактировать
            </button>
        </div>
    </div>
    <!-- /ko -->
</script>

<script type="text/html" id="create-discipline">
    <div class="details-row" data-bind="if: $root.mode() === state.create">
        <div class="details-column width-15p">
            <label class="title">Название дисциплины <span class="required">*</span></label>
            <select id="sDisciplineSelection" validate
                    data-bind="options: $root.initial.disciplines,
                       optionsText: 'name',
                       value: $root.initial.selection,
                       optionsCaption: 'Выберите дисциплину',
                       validationElement: $root.initial.selection,
                       event: {focusout: $root.events.focusout, focusin: $root.events.focusin}"></select>
        </div>

        <div class="details-column width-15p">
            <label class="title">Семестр обучения <span class="required">*</span></label>
            <input id="iSemester" type="text" validate
                   data-bind="value: semester,
                   validationElement: semester,
                   event: {focusout: $root.events.focusout, focusin: $root.events.focusin}"/>
        </div>
    </div>
    <div class="details-row">
        <div class="details-column width-15p">
            <label class="title">Общее количество часов <span class="required">*</span></label>
            <input id="iHours" type="text" validate
                   data-bind="value: hoursAll,
                   validationElement: hoursAll,
                   event: {focusout: $root.events.focusout, focusin: $root.events.focusin}"/>
        </div>
        <div class="details-column width-15p">
            <label class="title">Часов лекций <span class="required">*</span></label>
            <input id="iHoursLect" type="text" validate
                   data-bind="value: hoursLecture,
                   validationElement: hoursLecture,
                   event: {focusout: $root.events.focusout, focusin: $root.events.focusin}"/>
        </div>
        <div class="details-column width-15p">
            <label class="title">Часов практ. занятий <span class="required">*</span></label>
            <input id="iHoursPrakt" type="text" validate
                   data-bind="value: hoursPractical,
                   validationElement: hoursPractical,
                   event: {focusout: $root.events.focusout, focusin: $root.events.focusin}"/>
        </div>
        <div class="details-column width-15p">
            <label class="title">Часов лабор. занятий <span class="required">*</span></label>
            <input id="iHoursLabour" type="text" validate
                   data-bind="value: hoursLaboratory,
                   validationElement: hoursLaboratory,
                   event: {focusout: $root.events.focusout, focusin: $root.events.focusin}"/>
        </div>
        <div class="details-column width-15p">
            <label class="title">Часов cамост. изучения <span class="required">*</span></label>
            <input id="iHoursSamost" type="text" validate
                   data-bind="value: hoursSolo,
                   validationElement: hoursSolo,
                   event: {focusout: $root.events.focusout, focusin: $root.events.focusin}"/>
        </div>
    </div>
    <div class="details-column width-15p">
        <label class="title">Количество лекций <span class="required">*</span></label>
        <input id="iCountLekt" type="text" validate
               data-bind="value: countLecture,
                   validationElement: countLecture,
                   event: {focusout: $root.events.focusout, focusin: $root.events.focusin}"/>
    </div>
    <div class="details-column width-15p">
        <label class="title">Количество практ. занятий <span class="required">*</span></label>
        <input id="iCountPrakt" type="text" validate
               data-bind="value: countPractical,
                   validationElement: countPractical,
                   event: {focusout: $root.events.focusout, focusin: $root.events.focusin}"/>
    </div>
    <div class="details-column width-15p">
        <label class="title">Количество лабор. работ <span class="required">*</span></label>
        <input id="iCountLab" type="text" validate
               data-bind="value: countLaboratory,
                   validationElement: countLaboratory,
                   event: {focusout: $root.events.focusout, focusin: $root.events.focusin}"/>
    </div>
    <div class="details-row">
        <div class="details-column wrapper-column-radio width-18p">
            <label class="title">Экзамен</label>
            <span class="radio" data-bind="click: $root.actions.switchExam.on, css: {'radio-important' : hasExam()}">Есть</span>
            <span class="radio" data-bind="click: $root.actions.switchExam.off, css: {'radio-important' : !hasExam()}">Нет</span>
        </div>
        <div class="details-column wrapper-column-radio width-18p">
            <label class="title">Курсовая работа</label>
            <span class="radio"
                  data-bind="click: $root.actions.switchCoursework.on, css: {'radio-important' : hasCoursework()}">Есть</span>
            <span class="radio"
                  data-bind="click: $root.actions.switchCoursework.off, css: {'radio-important' : !hasCoursework()}">Нет</span>
        </div>
        <div class="details-column wrapper-column-radio width-18p">
            <label class="title">Курсовой проект</label>
            <span class="radio"
                  data-bind="click: $root.actions.switchCourseProject.on, css: {'radio-important' : hasCourseProject()}">Есть</span>
            <span class="radio"
                  data-bind="click: $root.actions.switchCourseProject.off, css: {'radio-important' : !hasCourseProject()}">Нет</span>
        </div>
        <div class="details-column wrapper-column-radio width-18p">
            <label class="title">&nbsp;&nbsp;&nbsp;&nbsp;РГЗ&nbsp;&nbsp;&nbsp;</label>
            <span class="radio"
                  data-bind="click: $root.actions.switchDesignAssignment.on, css: {'radio-important' : hasDesignAssignment()}">Есть</span>
            <span class="radio"
                  data-bind="click: $root.actions.switchDesignAssignment.off, css: {'radio-important' : !hasDesignAssignment()}">Нет</span>
        </div>
        <div class="details-column wrapper-column-radio width-18p">
            <label class="title">Реферат</label>
            <span class="radio" data-bind="click: $root.actions.switchEssay.on, css: {'radio-important' : hasEssay()}">Есть</span>
            <span class="radio"
                  data-bind="click: $root.actions.switchEssay.off, css: {'radio-important' : !hasEssay()}">Нет</span>
        </div>
        <div class="details-column wrapper-column-radio width-18p">
            <label class="title">Аудит. КР</label>
            <span class="radio"
                  data-bind="click: $root.actions.switchAudienceTest.on, css: {'radio-important' : hasAudienceTest()}">Есть</span>
            <span class="radio"
                  data-bind="click: $root.actions.switchAudienceTest.off, css: {'radio-important' : !hasAudienceTest()}">Нет</span>
        </div>
        <div class="details-column wrapper-column-radio width-18p">
            <label class="title">Домаш. КР</label>
            <span class="radio"
                  data-bind="click: $root.actions.switchHomeTest.on, css: {'radio-important' : hasHomeTest()}">Есть</span>
            <span class="radio"
                  data-bind="click: $root.actions.switchHomeTest.off, css: {'radio-important' : !hasHomeTest()}">Нет</span>
        </div>
    </div>
    <div class="details-row float-buttons">
        <div class="details-column float-right width-100p">
            <button class="cancel" data-bind="click: $root.actions.cancel">Отмена</button>
            <button id="bUpdateStudyplanItem" accept-validation title="Проверьте правильность заполнения полей"
                    class="approve" data-bind="click: $root.actions.end.update">Сохранить
            </button>
        </div>
    </div>
</script>

<script type="text/html" id="update-discipline">
    <td>
        <div class="wrapper-center">
            <button class="btn-danger" data-bind="click: $root.actions.start.remove"><span class="fa-smaller">&#xf014;</span>
            </button>
            <button class="cancel" data-bind="click: $root.actions.show"><span class="fa-smaller">Отмена</span></button>
            <div style="padding-top: 5px" >
                <button id="bUpdateStudyplanItem" accept-validation title="Проверьте правильность заполнения полей"
                        class="approve" data-bind="click: $root.actions.end.update"><span class="fa-smaller">&nbsp;&nbsp;Сохранить&nbsp;&nbsp;</span>
                </button>
            </div>
        </div>
    </td>

    <td class="wrapper-column"><label class="title">Семестр обучения <span class="required">*</span></label>
        <input id="iSemester" type="text" validate
               data-bind="value: semester,
                   validationElement: semester,
                   event: {focusout: $root.events.focusout, focusin: $root.events.focusin}"/>
    </td>
    <td class="wrapper-column">
        <label class="title">Количество часов <span class="required">*</span></label>
        <input id="iHours" type="text" validate
               data-bind="value: hoursAll,
                   validationElement: hoursAll,
                   event: {focusout: $root.events.focusout, focusin: $root.events.focusin}"/>
    </td>
    <td class="wrapper-column">
        <label class="title">Часов<br> лекций <span class="required">*</span></label>
        <input id="iHoursLect" type="text" validate
               data-bind="value: hoursLecture,
                   validationElement: hoursLecture,
                   event: {focusout: $root.events.focusout, focusin: $root.events.focusin}"/>
    </td>
    <td class="wrapper-column">
        <label class="title">Часов практ. занятий <span class="required">*</span></label>
        <input id="iHoursPrakt" type="text" validate
               data-bind="value: hoursPractical,
                   validationElement: hoursPractical,
                   event: {focusout: $root.events.focusout, focusin: $root.events.focusin}"/>
    </td>
    <td class="wrapper-column">
        <label class="title">Часов лабор. занятий <span class="required">*</span></label>
        <input id="iHoursLabour" type="text" validate
               data-bind="value: hoursLaboratory,
                   validationElement: hoursLaboratory,
                   event: {focusout: $root.events.focusout, focusin: $root.events.focusin}"/>
    </td>
    <td class="wrapper-column">
        <label class="title">Часов cамост. изучения <span class="required">*</span></label>
        <input id="iHoursSamost" type="text" validate
               data-bind="value: hoursSolo,
                   validationElement: hoursSolo,
                   event: {focusout: $root.events.focusout, focusin: $root.events.focusin}"/>
    </td>
    <td class="wrapper-column">
        <label class="title">Количество лекций <span class="required">*</span></label>
        <input id="iCountLekt" type="text" validate
               data-bind="value: countLecture,
                   validationElement: countLecture,
                   event: {focusout: $root.events.focusout, focusin: $root.events.focusin}"/>
    </td>
    <td class="wrapper-column">
        <label class="title">Количество практ. занятий <span class="required">*</span></label>
        <input id="iCountPrakt" type="text" validate
               data-bind="value: countPractical,
                   validationElement: countPractical,
                   event: {focusout: $root.events.focusout, focusin: $root.events.focusin}"/>
    </td>
    <td class="wrapper-column">
        <label class="title">Количество лабор. работ <span class="required">*</span></label>
        <input id="iCountLab" type="text" validate
               data-bind="value: countLaboratory,
                   validationElement: countLaboratory,
                   event: {focusout: $root.events.focusout, focusin: $root.events.focusin}"/>
    </td>
    <td class="wrapper-column-radio">
        <label class="title">Экзамен</label>
        <span class="radio"
              data-bind="click: $root.actions.switchExam.on, css: {'radio-important' : hasExam()}">Есть</span>
        <span class="radio"
              data-bind="click: $root.actions.switchExam.off, css: {'radio-important' : !hasExam()}">Нет</span>
    </td>
    <td class="wrapper-column-radio">
        <label class="title">Курсовая работа</label>
        <span class="radio"
              data-bind="click: $root.actions.switchCoursework.on, css: {'radio-important' : hasCoursework()}">Есть</span>
        <span class="radio"
              data-bind="click: $root.actions.switchCoursework.off, css: {'radio-important' : !hasCoursework()}">Нет</span>
    </td>
    <td class="wrapper-column-radio">
        <label class="title">Курсовой проект</label>
        <span class="radio"
              data-bind="click: $root.actions.switchCourseProject.on, css: {'radio-important' : hasCourseProject()}">Есть</span>
        <span class="radio"
              data-bind="click: $root.actions.switchCourseProject.off, css: {'radio-important' : !hasCourseProject()}">Нет</span>
    </td>
    <td class="wrapper-column-radio">
        <label class="title">РГЗ</label>
        <span class="radio"
              data-bind="click: $root.actions.switchDesignAssignment.on, css: {'radio-important' : hasDesignAssignment()}">Есть</span>
        <span class="radio"
              data-bind="click: $root.actions.switchDesignAssignment.off, css: {'radio-important' : !hasDesignAssignment()}">Нет</span>
    </td>
    <td class="wrapper-column-radio">
        <label class="title">Реферат</label>
        <span class="radio"
              data-bind="click: $root.actions.switchEssay.on, css: {'radio-important' : hasEssay()}">Есть</span>
        <span class="radio"
              data-bind="click: $root.actions.switchEssay.off, css: {'radio-important' : !hasEssay()}">Нет</span>
    </td>
    <td class="wrapper-column-radio">
        <label class="title">Аудит. КР</label>
        <span class="radio"
              data-bind="click: $root.actions.switchAudienceTest.on, css: {'radio-important' : hasAudienceTest()}">Есть</span>
        <span class="radio"
              data-bind="click: $root.actions.switchAudienceTest.off, css: {'radio-important' : !hasAudienceTest()}">Нет</span>
    </td>
    <td class="wrapper-column-radio">
        <label class="title">Домаш. КР</label>
        <span class="radio"
              data-bind="click: $root.actions.switchHomeTest.on, css: {'radio-important' : hasHomeTest()}">Есть</span>
        <span class="radio"
              data-bind="click: $root.actions.switchHomeTest.off, css: {'radio-important' : !hasHomeTest()}">Нет</span>
    </td>
</script>