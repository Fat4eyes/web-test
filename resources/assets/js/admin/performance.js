$(document).ready(function(){
    var performanceViewModel = function(){
        return new function(){
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
                    studentAttendances: ko.observableArray([]),
                    studentProgresses: ko.observableArray([]),
                }),
                planId: ko.observable()

                //performances                    results: ko.observableArray([]),

                // student: ko.validatedObservable({
                //     id: ko.observable(''),
                //     firstname: ko.observable('').extend({
                //         required: true,
                //         pattern: '^[А-ЯЁ][а-яё]+(\-{1}(?:[А-ЯЁ]{1}(?:[а-яё]+)))?$',
                //         maxLength: 80
                //     }),
                //     lastname: ko.observable('').extend({
                //         required: true,
                //         pattern: '^[А-ЯЁ][а-яё]+(\-{1}(?:[А-ЯЁ]{1}(?:[а-яё]+)))?$',
                //         maxLength: 80
                //     }),
                //     patronymic: ko.observable('').extend({
                //         pattern: '^[А-ЯЁ][а-яё]+(\-{1}(?:[А-ЯЁ]{1}(?:[а-яё]+)))?$',
                //         maxLength: 80
                //     }),
                //     group: ko.observable(null).extend({required: true}),
                //     email: ko.observable('').extend({required: true, email: true}),
                //     password: ko.observable('').extend({
                //         required: true,
                //         minLength: 6,
                //         maxLength: 16
                //     }),
                //     active: ko.observable(true)
                // }),
                // password: ko.observable(null).extend({
                //     required: true,
                //     minLength: 6,
                //     maxLength: 16
                // })
            };
            //
            // self.filter = {
            //     discipline: ko.observable(),
            //     group : ko.observable(),
            //     clear: function(){
            //         self.filter.discipline(null).group(null);
            //     }
            // };
            self.filter = {

                profile: ko.observable(),
                discipline: ko.observable(),
                group: ko.observable({
                    group: ko.observable(''),
                    studyPlanId: ko.observable(''),
                }),
                planId: ko.observable(),

                profiles: ko.observableArray([]),
                disciplines: ko.observableArray([]),
                groups: ko.observableArray([]),

                set: {
                    profile: function(){
                        var id = self.settings().result_profile;
                        if (!id) return;
                        $.each(self.filter.profiles(), function(i, item){
                            if (item.id() == id()){
                                self.filter.profile(item);
                            }
                        });
                    },
                    discipline: function(){
                        var id = self.settings().result_discipline;
                        if (!id) return;
                        $.each(self.filter.disciplines(), function(i, item){
                            if (item.id() == id()){
                                self.filter.discipline(item);
                            }
                        });
                    },
                    group: function(id){
                        var id = id || self.settings().result_group;
                        if (!id) return;
                        $.each(self.filter.groups(), function(i, item){
                            if (item.id() == id()){
                                self.filter.group(item);

                               // self.filter.planId(item.studyPlanId);
                                console.log(self.filter.group.studyPlanId);
                            }
                        });
                    },
                },
                clear: function(){
                    self.filter.group() ? self.filter.group(null) : null;
                    self.filter.discipline() ? self.filter.discipline(null) : null;
                }
            };
            // self.filter = {
            //     name: ko.observable(''),
            //     group: ko.observable(),
            //     request: ko.observable(filters.active.all),
            //     clear: function(){
            //         self.filter
            //             .name('')
            //             .group(null)
            //             .request(filters.active.all);
            //     },
            //     set: {
            //         group: function(id){
            //             $.each(self.initial.groups(), function(i, item){
            //                 if (item.id() == id) self.filter.group(item);
            //             });
            //         }
            //     }
            // };
            // self.actions = {
            //     show: function(data){
            //         if (self.mode() === state.none || self.current.student().id() !== data.id()){
            //             self.get.student(data.id());
            //             return;
            //         }
            //         self.mode(state.none);
            //         self.alter.empty();
            //     },
            //     start: {
            //         create: function(){
            //             self.alter.empty();
            //             self.mode() === state.create
            //                 ? self.mode(state.none)
            //                 : self.mode(state.create);
            //             commonHelper.buildValidationList(self.validation);
            //         },
            //         update: function(data){
            //             self.mode(state.update);
            //             self.alter.fill(data);
            //             commonHelper.buildValidationList(self.validation);
            //         },
            //         remove: function(){
            //             commonHelper.modal.open('#remove-request-modal');
            //         }
            //     },
            //     end: {
            //         update: function(){
            //             self.current.student.isValid()
            //                 ? self.post.student()
            //                 : self.validation[$('[accept-validation]').attr('id')].open();
            //         },
            //         remove: function(){
            //             self.post.request();
            //         }
            //     },
            //     cancel: function(){
            //         self.mode(state.none);
            //         self.alter.empty();
            //         self.current.password(null);
            //     },
            //
            //     password: {
            //         change: function(){
            //             commonHelper.modal.open('#change-password-modal');
            //         },
            //         cancel: function(){
            //             self.current.password(null);
            //             self.validation[$('.box-modal [validate]').attr('id')].close();
            //             commonHelper.modal.close('#change-password-modal');
            //         },
            //         approve: function(){
            //             self.current.password.isValid()
            //                 ? self.post.password()
            //                 : self.validation[$('.box-modal [validate]').attr('id')].open();
            //         }
            //     },
            //     switch: {
            //         on: function(data, e){
            //             self.confirm.show({
            //                 message: 'Вы действительно хотите подтвердить заявку?',
            //                 approve: function(){
            //                     self.post.approval(data.id());
            //                 }
            //             });
            //             e.stopPropagation();
            //         },
            //         off: function(data, e){
            //             self.confirm.show({
            //                 message: 'Заявка будет удалена. Вы действительно хотите отклонить выбранную заявку?',
            //                 approve: function(){
            //                     self.post.request(data.id());
            //                 }
            //             });
            //             e.stopPropagation();
            //         }
            //     }
            // };
            //
            self.alter = {
                // set: {
                //     group: function(id){
                //         $.each(self.initial.groups(), function(i, item){
                //             if (item.id() === id)
                //                 self.current.student().group(item);
                //         });
                //     }
                // },
                stringify: {
                    student: function(){
                        var student = ko.mapping.toJS(self.current.student);
                        delete student.group;

                        self.mode() === state.create
                            ? delete student.id
                            : delete student.password;

                        return JSON.stringify({
                            student: student,
                            groupId: self.current.student().group().id()
                        });
                    },
                },
                fill: function(data){
                    self.current.student().id(data.id())
                        .firstname(data.firstname()).lastname(data.lastname())
                        .patronymic(data.patronymic())
                    ko.mapping.fromJS(data, {}, self.filter.group);
                },
                empty: function(){
                    self.current.student().id('').group(null)
                        .firstname('').lastname('').patronymic('')
                }
            };


            self.get = {
                settings: function(){
                    var json = JSON.stringify({
                        settings: [
                            "result_profile",
                            "result_discipline",
                            "result_group",
                            "result_test"
                        ]
                    });
                    $ajaxpost({
                        url: '/api/uisettings/get',
                        data: json,
                        errors: self.errors,
                        successCallback: function(data){
                            self.settings(data);
                            self.get.profiles();
                        },
                        errorCallback: function(){
                            self.settings(null);
                            self.get.profiles();
                        }
                    });
                },
                profiles: function(){
                    $ajaxget({
                        url: '/api/profiles',
                        errors: self.errors,
                        successCallback: function(data){
                            self.filter.profiles(data());
                            self.settings() ? self.filter.set.profile() : null;
                        }
                    });
                },
                disciplines: function(){
                    $ajaxget({
                        url: '/api/profile/'+ self.filter.profile().id() +'/disciplines',
                        errors: self.errors,
                        successCallback: function(data){
                            self.filter.disciplines(data());
                            self.settings() ? self.filter.set.discipline() : null;
                        }
                    });
                    console.log(self.filter.disciplines);
                },


                studyplan: function () {
                    var name = self.filter.discipline() ? '&name=' + self.filter.groupId() : '';
                    var url = '/api/plan/discipline/show' +
                        '?studyplan=' + self.current.planId() + name;

                    var requestOptions = {
                        url: url,
                        errors: self.errors,
                        data: null,
                        successCallback: function (data) {
                            self.current.disciplines(data.data());
                        }
                    };
                    $ajaxpost(requestOptions);
                },


                groups: function(){
                    $ajaxget({
                        url: '/api/profile/'+ self.filter.profile().id() +'/groups',
                        errors: self.errors,
                        successCallback: function(data){
                            self.filter.groups(data());
                            self.settings() ? self.filter.set.group() : null;
                        }
                    });
                },
                tests: function(){
                    $ajaxget({
                        url: '/api/disciplines/' + self.filter.discipline().id()+ '/tests',
                        errors: self.errors,
                        successCallback: function(data){
                            self.filter.tests(data());
                            self.settings() ? self.filter.set.test() : null;
                        }
                    });
                },
                results: function(){
                    var group = self.filter.group();
                    var discipline = self.filter.discipline();

                    console.log(self.filter.group().studyPlanId);
                    if(!discipline) return;

                    if (!group){
                        group = {
                            id : function(){ return 0;}
                        }
                    }

                    $ajaxget({
                    //    Route::get('{id}/students', 'GroupController@getGroupStudents');
                        url: '/api/groups/'+ group.id()
                        + '/students',
                        errors: self.errors,
                        successCallback: function(data){
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
                settings: function(settings){
                    $ajaxpost({
                        url: '/api/uisettings/set',
                        errors: self.errors,
                        data: JSON.stringify({settings: settings})
                    });
                }
            };

            self.get.settings();

            //SUBSCRIPTIONS

            self.filter.profile.subscribe(function(value){
                if (value){
                    self.post.settings({'result_profile': self.filter.profile().id()});
                    self.get.groups();
                    self.get.disciplines();
                    return;
                }
                self.filter
                    .disciplines([])
                    .groups([]);
                self.post.settings({'result_profile': null});
            });
            self.filter.discipline.subscribe(function(value){
                if (value){
                    self.post.settings({'result_discipline': self.filter.discipline().id()});
                    //self.get.tests();
                    return;
                }
               // self.filter.tests([]);
                self.post.settings({'result_discipline': null});
            });
            self.filter.group.subscribe(function(value){
                if (value){
                    self.post.settings({'result_group': self.filter.group().id()});
                    self.get.results();
                    return;
                }
                self.post.settings({'result_group': null});
                self.get.results();
            });


            // self.get = {
            //     // students: function(){
            //     //     var filter = self.filter;
            //     //     var discipline = 'discipline=' + (filter.discipline() ? filter.discipline().id() : '');
            //     //     var group = 'group=' + (filter.group() ? filter.group().id() : '');
            //     //     var url = '/api/performance/show?' + discipline + '&' + group;
            //     //
            //     //     $ajaxget({
            //     //         url: url,
            //     //         errors: self.errors,
            //     //         successCallback: function(data){
            //     //             self.current.students(data.data());
            //     //             // self.pagination.itemsCount(data.count());
            //     //             commonHelper.tooltip({selector: '.item > .fa', side: 'top'});
            //     //         }
            //     //     });
            //     // },
            //     // student: function(id){
            //     //     $ajaxget({
            //     //         url: '/api/user/getStudent/' + id,
            //     //         errors: self.errors,
            //     //         successCallback: function(data){
            //     //             self.alter.fill(data);
            //     //             self.alter.set.group(data.group.id());
            //     //             self.mode(state.info);
            //     //         }
            //     //     });
            //     // },
            //     // groups: function(){
            //     //     $ajaxget({
            //     //         url: '/api/groups',
            //     //         errors: self.errors,
            //     //         successCallback: function(data){
            //     //             self.initial.groups(data());
            //     //             var cookie = $.cookie();
            //     //             if (!$.isEmptyObject(cookie)){
            //     //                 self.filter.set.group(cookie.groupId);
            //     //                 commonHelper.cookies.remove(cookie);
            //     //                 return;
            //     //             }
            //     //             self.get.students();
            //     //         }
            //     //     });
            //     // }
            //     disciplines: function(){
            //         $ajaxget({
            //             url: '/api/profile/'+ self.filter.profile().id() +'/disciplines',
            //             errors: self.errors,
            //             successCallback: function(data){
            //                 self.filter.disciplines(data());
            //                 self.settings() ? self.filter.set.discipline() : null;
            //             }
            //         });
            //     },
            //     groups: function(){
            //         $ajaxget({
            //             url: '/api/profile/'+ self.filter.profile().id() +'/groups',
            //             errors: self.errors,
            //             successCallback: function(data){
            //                 self.filter.groups(data());
            //                 self.settings() ? self.filter.set.group() : null;
            //             }
            //         });
            //     },
            //
            //     results: function(){
            //         var group = self.filter.group();
            //         var discipline = self.filter.discipline();
            //
            //         if(!discipline) return;
            //
            //         if (!group){
            //             group = {
            //                 id : function(){ return 0;}
            //             }
            //         }
            //
            //         if(!test){
            //             test = {
            //                 id : function(){ return 0;}
            //             }
            //         }
            //
            //         $ajaxget({
            //             url: '/api/results/show?groupId='+ group.id()
            //             + '&testId=' + test.id()
            //             + '&disciplineId=' + discipline.id(),
            //             errors: self.errors,
            //             successCallback: function(data){
            //                 self.current.results(data());
            //             }
            //         });
            //     },
            // };
            // self.get.disciplines();
            // self.get.groups();
            // //
            // // self.post = {
            // //     request: function(studentId){
            // //         var id = studentId ? studentId : self.current.student().id();
            // //         $ajaxpost({
            // //             url: '/api/user/delete/' + id,
            // //             data: null,
            // //             errors: self.errors,
            // //             successCallback: function(){
            // //                 self.actions.cancel();
            // //                 self.get.students();
            // //             }
            // //         });
            // //     },
            // //     approval: function(id){
            // //         $ajaxpost({
            // //             url: '/api/user/activate/' + id,
            // //             errors: self.errors,
            // //             successCallback: function(){
            // //                 self.get.students();
            // //             }
            // //         })
            // //     },
            // //     student: function(){
            // //         $ajaxpost({
            // //             url: '/api/groups/student/' + self.mode(),
            // //             errors: self.errors,
            // //             data: self.alter.stringify.student(),
            // //             successCallback: function(){
            // //                 self.actions.cancel();
            // //                 self.get.students();
            // //             }
            // //         });
            // //     },
            // //     password: function(){
            // //         $ajaxpost({
            // //             url: '/api/user/setPassword',
            // //             errors: self.errors,
            // //             data: self.alter.stringify.password(),
            // //             successCallback: function(){
            // //                 self.actions.password.cancel();
            // //                 self.inform.show({
            // //                     message: 'Пароль успешно изменен'
            // //                 });
            // //             }
            // //         });
            // //     }
            // // };
            // //
            // // self.filter.group.subscribe(function(){
            // //     self.actions.cancel();
            // //     self.pagination.currentPage(1);
            // //     self.get.students();
            // // });
            //
            //
            // // self.filter.discipline.subscribe(function(){
            // //     self.mode(state.none);
            // //     self.get.students();
            // // });
            // // self.filter.group.subscribe(function(){
            // //     self.mode(state.none);
            // //     self.get.students();
            // // });
            // self.filter.discipline.subscribe(function(value){
            //     if (value){
            //         self.post.settings({'result_discipline': self.filter.discipline().id()});
            //         return;
            //     }
            //     // self.post.settings({'result_discipline': null});
            //     self.get.results();
            // });
            // self.filter.group.subscribe(function(value){
            //     if (value){
            //         self.post.settings({'result_group': self.filter.group().id()});
            //         self.get.results();
            //         return;
            //     }
            //     //todo if true and discipline true => вернуть результат
            //     self.get.results();
            // });




            // self.filter.name.subscribe(function(){
            //     self.actions.cancel();
            //     self.pagination.currentPage(1);
            //     self.get.students();
            // });
            // self.filter.request.subscribe(function(){
            //     self.actions.cancel();
            //     self.pagination.currentPage(1);
            //     self.get.students();
            // });
            // self.pagination.itemsCount.subscribe(function(value){
            //     if (value){
            //         self.pagination.totalPages(Math.ceil(
            //             value/self.pagination.pageSize()
            //         ));
            //     }
            // });
            // self.pagination.currentPage.subscribe(function(){
            //     self.get.students();
            // });

            return returnStandart.call(self);
        };
    };

    ko.applyBindings(performanceViewModel());
});















$(document).ready(function(){
    var resultsViewModel = function(){
        return new function(){
            var self = this;

            initializeViewModel.call(self, {
                page: menu.admin.results
            });

            self.theme = ko.observable({});
            self.settings = ko.observable(null);

            self.current = {
                results: ko.observableArray([]),
                markScale: ko.observable(100)
            };
            self.filter = {
                profile: ko.observable(),
                discipline: ko.observable(),
                group: ko.observable(),
                test: ko.observable(),

                profiles: ko.observableArray([]),
                disciplines: ko.observableArray([]),
                groups: ko.observableArray([]),
                tests: ko.observableArray([]),

                set: {
                    profile: function(){
                        var id = self.settings().result_profile;
                        if (!id) return;
                        $.each(self.filter.profiles(), function(i, item){
                            if (item.id() == id()){
                                self.filter.profile(item);
                            }
                        });
                    },
                    discipline: function(){
                        var id = self.settings().result_discipline;
                        if (!id) return;
                        $.each(self.filter.disciplines(), function(i, item){
                            if (item.id() == id()){
                                self.filter.discipline(item);
                            }
                        });
                    },
                    group: function(id){
                        var id = id || self.settings().result_group;
                        if (!id) return;
                        $.each(self.filter.groups(), function(i, item){
                            if (item.id() == id()){
                                self.filter.group(item);
                            }
                        });
                    },
                    // test: function(){
                    //     var id = self.settings().result_test;
                    //     if (!id) return;
                    //     $.each(self.filter.tests(), function(i, item){
                    //         if (item.id() == id()){
                    //             self.filter.test(item);
                    //         }
                    //     });
                    // }todo студенты
                },
                clear: function(){
                    self.filter.profile() ? self.filter.profile(null) : null;
                    self.filter.group() ? self.filter.group(null) : null;
                    self.filter.discipline() ? self.filter.discipline(null) : null;
                    self.filter.test() ? self.filter.test(null) : null;
                    self.settings(null);
                }
            };


            self.actions = {
                show: function(data){
                    window.location.href = '/admin/result/' + data.id();
                },
                overall: function(){

                    self.filter.profile() ? self.post.settings({'overall_profile': self.filter.profile().id()}) : null;
                    self.filter.discipline() ? self.post.settings({'overall_discipline': self.filter.discipline().id()}): null;
                    self.filter.group() ? self.post.settings({'overall_group': self.filter.group().id()}) : null;
                    window.location.href = '/admin/overallresults';
                }
            };


            self.filter.test.subscribe(function(value){
                if (value){
                    self.post.settings({'result_test': self.filter.test().id()});
                    self.get.results();
                    return;
                }
                self.current.results([]);
                self.post.settings({'result_test': null});
                self.get.results();
            });


            return returnStandart.call(self);
        };
    };

    ko.applyBindings(resultsViewModel());
});