$(document).ready(function () {

    var performanceViewModel = function () {
        return new function () {
            var self = this;

            initializeViewModel.call(self, {
                page: menu.admin.performance,
                pagination: 20,
                mode: true
            });

            self.initial = {
                groups: ko.observableArray([])
            };

            self.settings = ko.observable(null);
            self.current = {
                disciplineGroup: ko.validatedObservable(),
                tableWidthLecture: ko.observableArray([]),
                tableWidthPractical: ko.observableArray([]),
                tableWidthLaboratory: ko.observableArray([]),
                students: ko.observableArray([]),
                student: ko.validatedObservable({
                    id: ko.observable(''),
                    firstName: ko.observable('').extend({
                        required: true,
                        pattern: '^[А-ЯЁ][а-яё]+(\-{1}(?:[А-ЯЁ]{1}(?:[а-яё]+)))?$',
                        maxLength: 80
                    }),
                    lastName: ko.observable('').extend({
                        required: true,
                        pattern: '^[А-ЯЁ][а-яё]+(\-{1}(?:[А-ЯЁ]{1}(?:[а-яё]+)))?$',
                        maxLength: 80
                    }),
                    patronymic: ko.observable('').extend({
                        pattern: '^[А-ЯЁ][а-яё]+(\-{1}(?:[А-ЯЁ]{1}(?:[а-яё]+)))?$',
                        maxLength: 80
                    }),
                    studentInitials: function (data) {
                        console.log(data);

                        return data.lastName() + " " + data.firstName().charAt(0) + "." + data.patronymic().charAt(0) + ".";
                    },
                    studentAttendances: ko.observableArray([]),
                    studentProgresses: ko.observableArray([]),
                }),
                planId: ko.observable(),
                showToggleLecture: function (index, parentIndex) {
                    let id = 'toggleLecture' + parentIndex + '_' + index;
                    let state = 'state0';
                    if (!(document.getElementById(id).className.toString().slice(-1) === '3')) {
                        state = 'state' + (Number(document.getElementById(id).className.toString().slice(-1)) + 1);
                    }
                    document.getElementById(id).className = state;
                },
                showTogglePractical: function (index, parentIndex) {
                    let id = 'togglePractical' + parentIndex + '_' + index;
                    let state = 'state0';
                    if (!(document.getElementById(id).className.toString().slice(-1) === '3')) {
                        state = 'state' + (Number(document.getElementById(id).className.toString().slice(-1)) + 1);
                    }
                    document.getElementById(id).className = state;
                },
                showToggleLaboratory: function (student) {
                    return;
                }
            };
            self.filter = {

                profile: ko.observable(),
                discipline: ko.observable(),
                group: ko.observable(),
                semester: ko.observable(),

                planId: ko.observable(),

                profiles: ko.observableArray([]),
                disciplines: ko.observableArray([]),

                semesters: ko.observableArray([]),
                uniqueDisciplines: ko.observableArray([]),

                groups: ko.observableArray([]),
                uniqueDisciplinesFunction: function () {
                    let allDisciplines = ko.mapping.toJS(self.filter.disciplines());
                    ret = [];
                    allDisciplines.forEach(d => {
                        if (!ret.find(t => t.discipline === d.discipline))
                            ret.push(d);
                    });
                    console.log(ret);
                    return ret;
                },
                disciplineSemesters: function () {
                    let allDisciplines = ko.mapping.toJS(self.filter.disciplines());
                    ret = [];
                    allDisciplines.forEach(d => {
                        if (d.discipline === self.filter.discipline().discipline)
                            ret.push(d);
                    });
                    console.log(ret);
                    return ret;
                },

                set: {
                    profile: function () {
                        var id = self.settings().result_profile;
                        if (!id) return;
                        $.each(self.filter.profiles(), function (i, item) {
                            if (item.id() == id()) {
                                self.filter.profile(item);
                            }
                        });
                    },
                    group: function (id) {
                        var id = id || self.settings().result_group;
                        if (!id) return;
                        $.each(self.filter.groups(), function (i, item) {
                            if (item.id() == id()) {
                                self.filter.group(item);
                            }
                        });
                    },
                    discipline: function (id) {
                        var id = id || self.settings().result_discipline;
                        if (!id) return;
                        $.each(self.filter.uniqueDisciplines(), function (i, item) {
                            if (item.id == id()) {
                                self.filter.discipline(item);
                            }
                        });
                    },
                    semester: function (id) {
                        var id = id || self.settings().result_semester;
                        if (!id) return;
                        $.each(self.filter.semesters(), function (i, item) {
                            if (item.id == id()) {
                                self.filter.semester(item);
                            }
                        });
                    },
                },
                clear: function () {
                    self.filter.group() ? self.filter.group(null) : null;
                    self.filter.discipline() ? self.filter.discipline(null) : null;
                    self.filter.semester() ? self.filter.semester(null) : null;
                }
            };

            // self.alter = {
            //     stringify: {
            //         student: function () {
            //             var student = ko.mapping.toJS(self.current.student);
            //             delete student.group;
            //
            //             self.mode() === state.create
            //                 ? delete student.id
            //                 : delete student.password;
            //
            //             return JSON.stringify({
            //                 student: student,
            //                 groupId: self.current.student().group().id()
            //             });
            //         },
            //     },
            //     fill: function (data) {
            //         self.current.student().id(data.id())
            //             .firstname(data.firstname()).lastname(data.lastname())
            //             .patronymic(data.patronymic());
            //         ko.mapping.fromJS(data, {}, self.filter.group);
            //     },
            // };


            self.get = {
                settings: function () {
                    var json = JSON.stringify({
                        settings: [
                            "result_profile",
                            "result_discipline",
                            "result_group",
                            "result_semester"
                        ]
                    });
                    $ajaxpost({
                        url: '/api/uisettings/get',
                        data: json,
                        errors: self.errors,
                        successCallback: function (data) {
                            self.settings(data);
                            self.get.profiles();
                        },
                        errorCallback: function () {
                            self.settings(null);
                            self.get.profiles();
                        }
                    });
                },
                profiles: function () {
                    $ajaxget({
                        url: '/api/profiles',
                        errors: self.errors,
                        successCallback: function (data) {
                            self.filter.profiles(data());
                            self.settings() ? self.filter.set.profile() : null;
                        }
                    });
                },
                groups: function () {
                    $ajaxget({
                        url: '/api/profile/' + self.filter.profile().id() + '/groups',
                        errors: self.errors,
                        successCallback: function (data) {
                            self.filter.groups(data());
                            self.settings() ? self.filter.set.group() : null;
                        }
                    });
                },
                disciplines: function () {
                    //console.log(self.filter.group().studyplanId());
                    if (self.filter.group()) {
                        let url = '/api/plan/discipline/show' +
                            '?studyplan=' + self.filter.group().studyplanId();
                        $ajaxpost({
                            url: url,
                            // url: '/api/profile/'+ self.filter.profile().id() +'/disciplines',
                            errors: self.errors,
                            data: null,
                            successCallback: function (data) {
                                self.filter.disciplines(data.data());
                                self.filter.uniqueDisciplines(self.filter.uniqueDisciplinesFunction());
                                // self.filter.disciplines(data());
                                self.settings() ? self.filter.set.discipline() : null;
                            }
                        });

                        // todo было
                        // $ajaxget({
                        //     url: '/api/profile/'+ self.filter.profile().id() +'/disciplines',
                        //     errors: self.errors,
                        //     data: null,
                        //     successCallback: function(data){
                        //         self.filter.disciplines(data());
                        //         self.settings() ? self.filter.set.discipline() : null;
                        //     }
                        // });

                    }
                },


                studyplan: function () {

                    // let url = '/api/performance/group/1';
                    //
                    // let requestOptions = {
                    //     url: url,
                    //     errors: self.errors,
                    //     successCallback: function (data) {
                    //         self.filter.disciplines(data());
                    //     }
                    // };
                    // $ajaxpost(requestOptions);

                    $ajaxget({
                        url: '/api/performance/2/attendances',
                        errors: self.errors,
                        successCallback: function (data) {
                            self.current.student().studentAttendances(data());
                            console.log(self.current.student().studentAttendances());
                        }
                    });

                    var url = '/api/plan/discipline/show' +
                        '?discipline=' + self.current.discipline().id() + '&student=2';

                    var requestOptions = {
                        url: url,
                        errors: self.errors,
                        data: null,
                        successCallback: function (data) {
                            self.filter.disciplines(data.data());
                        }
                    };
                    $ajaxpost(requestOptions);

                    //
                    // var name = self.filter.discipline() ? '&name=' + self.filter.groupId() : '';
                    // var url = '/api/plan/discipline/show' +
                    //     '?studyplan=' + self.current.planId() + name;
                    //
                    // var requestOptions = {
                    //     url: url,
                    //     errors: self.errors,
                    //     data: null,
                    //     successCallback: function (data) {
                    //         self.filter.disciplines(data.data());
                    //     }
                    // };
                    // $ajaxpost(requestOptions);
                },
                semesters: function () {
                    if (self.filter.discipline) {
                        self.filter.semesters(self.filter.disciplineSemesters());
                        self.settings() ? self.filter.set.semester() : null;
                    }
                },
                results: function () {
                    var group = self.filter.group();
                    var discipline = self.filter.discipline;
                    var semester = self.filter.semester();

                    // if(group){
                    //     console.log(self.filter.group().studyplanId());
                    // }

                    console.log(semester);

                    if (!semester) {
                        self.current.tableWidthLecture([]);
                        self.get.semesters();
                        return;
                    }

                    if (!discipline) {
                        self.current.tableWidthLecture([]);
                        self.get.disciplines();
                        return;
                    }

                    if (!group) {
                        self.current.tableWidthLecture([]);
                        self.get.groups();
                        group = {
                            id: function () {
                                return 0;
                            }
                        }
                    }

                    // self.filter.discipline = self.filter.discipline();

                    let ret = [];
                    for (let i = 1; i < semester.countLecture; i++)
                        ret.push('ЛЕК ' + i);
                    self.current.tableWidthLecture(ret);

                    console.log(self.filter.semester());
                    console.log(self.current.tableWidthLecture().length);

                    let ret2 = [];
                    for (let i = 1; i < semester.countPractical; i++)
                        ret2.push('ПРЗ ' + i);
                    self.current.tableWidthPractical(ret2);

                    let ret3 = [];
                    for (let i = 1; i < semester.countLaboratory; i++)
                        ret3.push('ЛАБ ' + i);
                    self.current.tableWidthLaboratory(ret3);

                    self.get.studyplan();

                    // let students = ko.mapping.toJS(self.current.students());

                    $ajaxget({
                        //    Route::get('{id}/students', 'GroupController@getGroupStudents');
                        url: '/api/groups/' + group.id()
                        + '/students',
                        errors: self.errors,
                        successCallback: function (data) {
                            self.current.students(data());
                        }
                    });

                },
                // markScale: function(){
                //     $ajaxget({
                //         url: '/api/settings/get/maxMarkValue',
                //         errors: self.errors,
                //         successCallback: function(data){
                //             self.current.markScale(data.value());
                //         }
                //     });
                // }todo поменять со студентами
            };
            self.post = {
                settings: function (settings) {
                    $ajaxpost({
                        url: '/api/uisettings/set',
                        errors: self.errors,
                        data: JSON.stringify({settings: settings})
                    });
                }
            };

            self.get.settings();

            //SUBSCRIPTIONS

            self.filter.profile.subscribe(function (value) {
                if (value) {
                    self.post.settings({'result_profile': self.filter.profile().id()});
                    self.get.groups();
                    self.get.disciplines();
                    return;
                }
                self.filter
                    .groups([]);
                self.post.settings({'result_profile': null});
            });
            self.filter.group.subscribe(function (value) {
                if (value) {
                    self.post.settings({'result_group': self.filter.group().id()});
                    self.get.disciplines();
                    self.get.semesters();
                    self.get.results();
                    return;
                }
                self.filter.uniqueDisciplines([]);
                self.post.settings({'result_group': null});
                //self.get.results();
            });
            self.filter.discipline.subscribe(function (value) {
                if (value) {
                    self.post.settings({'result_discipline': self.filter.discipline().id});
                    // self.filter.discipline = value;
                    console.log(self.filter.discipline());
                    self.get.semesters();
                    // self.filter.disciplineSemesters();

                    self.get.results();
                    return;
                }
                self.filter.semesters([]);
                self.post.settings({'result_discipline': null});
            });
            self.filter.semester.subscribe(function (value) {
                if (value) {
                    self.post.settings({'result_semester': self.filter.semester().id});
                    // self.get.groups();
                    self.get.results();
                    return;
                }
                // self.filter.semesters([]);
                self.post.settings({'result_semester': null});
                self.get.results();
            });
            return returnStandart.call(self);
        };
    };

    ko.applyBindings(performanceViewModel());
});

